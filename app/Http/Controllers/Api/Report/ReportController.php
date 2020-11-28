<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Http\Requests\Report\ReportStoreRequest;
use App\Http\Requests\Report\ReportUpdateRequest;
use App\Http\Utils\CoordinatesHelper;
use App\Models\Photo\Photo;
use App\Models\Position\Position;
use App\Models\Report\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


/**
 * @group reports
 *
 * Managing reports
 */
class ReportController extends Controller
{
    /**
     * report
     *
     * add new record of report with localization
     *
     * returns id of new report
     *
     * @bodyParam is_tracks boolean optional default value is 0
     * @bodyParam latitude float required
     * @bodyParam longitude float required
     * @bodyParam country string optional
     * @bodyParam voivodeship string optional
     * @bodyParam subregion string optional powiat
     * @bodyParam disctrict string optional gmina
     * @bodyParam city string optional
     * @bodyParam street string optional
     * @bodyParam image file optional
     */
    public function store(ReportStoreRequest $rsr){

        $userId = Auth::id();

        $isTracks = $rsr->get('is_tracks', 0);

        $report = Report::create([
           'is_tracks' => $isTracks,
           'user_id' => $userId,
        ]);

        $position = Position::create([
            'latitude' =>  $rsr->get('latitude'),
            'longitude' =>  $rsr->get('longitude'),
            'country' => $rsr->get('country', null),
            'voivodeship' => $rsr->get('voivodeship', null),
            'subregion' => $rsr->get('subregion', null),
            'disctrict' => $rsr->get('disctrict', null),
            'city' => $rsr->get('city', null),
            'street' => $rsr->get('street', null),
            'report_id' => $report->id,
        ]);

        $data = [
          'report' => $report->load('position'),
          'message' => 'Zgłoszenie dodane pomyślnie',
        ];

        return response()->json($data);
    }

    /**
     * report/{id}
     *
     * updates a record of report
     *
     * @queryParam id integer required id of record
     * @bodyParam _method string required PUT
     * @bodyParam size integer optional 0(small) 1(medium) 2(large)
     * @bodyParam with_children boolean optional
     * @bodyParam alive boolean optional
     * @bodyParam description string optional
     * @bodyParam image file:jpg,png optional
     */
    public function update(ReportUpdateRequest $rur, $id){
        $report = Report::findOrFail($id);
        $report->update([
            'size' => $rur->get('size', $report->size),
            'with_children' => $rur->get('with_children', $report->with_children),
            'alive' => $rur->get('alive', $report->alive),
            'description' => $rur->get('description', $report->description),
        ]);

        Log::info($rur->hasFile('image'));

        $report->save();

        if($rur->image){
            $photo = Photo::where('report_id', $id)->first();
            if($photo) {
                Storage::delete('public/images/'.$photo->name);
                $photo->delete();
            }

            $path = Storage::put('public/images', $rur->image);

            Photo::create([
                'directory' => 'images/',
                'name' => explode('/', $path)[2],
                'report_id' => $id,
            ]);
        }

        $data = [
            'report' => $report->load(['position', 'photo']),
            'message' => 'Zgłoszenie zaktualizowane pomyślnie',
        ];

        return response()->json($data);
    }

    /**
     * report/{id}
     *
     * deletes a record of report
     *
     * @queryParam id integer required id of record
     */
    public function delete($id){
        $message = '';
        try {
            $photo = Photo::where('report_id', $id)->first();
            Storage::delete('public/images/'.$photo->name);
            Report::findOrFail($id)->delete();
            $message = 'Pomyślnie usunięto zgłoszenie';
        } catch (Exception $e) {
            $message = "Nie udało się usunąć zgłoszenia";
        }

        return response()->json(['data' => [
            'message' => $message
        ]]);
    }

    /**
     * report/latitude/longitude/radius
     *
     * returns all positions with reports based on given coordinates and in between given radius
     * @queryParam latitude float required
     * @queryParam longitude float required
     * @queryParam radius float required
     */
    public function indexByRadius(Report $request, $latitude, $longitude, $radius){
        $messages = [];

        if($latitude == null){
            array_push($messages, "Musisz podać argument latitude");
        }
        if($longitude == null){
            array_push($messages, "Musisz podać argument longitude");
        }

        if(sizeof($messages) > 0) {
            return response()->json([
                'data' => $messages
            ],406);
        }

        $positiveCords = CoordinatesHelper::coordinatesPlusMeters($latitude, $longitude, $radius);
        $negativeCords = CoordinatesHelper::coordinatesPlusMeters($latitude, $longitude, $radius * -1);

        $reports = Position::with('report')
        ->whereBetween('latitude', [$negativeCords['latitude'], $positiveCords['latitude']])
        ->whereBetween('longitude', [$negativeCords['longitude'], $positiveCords['longitude']])
            ->orderBy('created_at')
            ->get();

        return response()->json(['data' => $reports]);
    }
}
