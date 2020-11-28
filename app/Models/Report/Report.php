<?php

namespace App\Models\Report;

use App\Models\Photo\Photo;
use App\Models\Position\Position;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Report\Report
 *
 * @property int $id
 * @property int|null $size 0 - small, 1 - medium, 2 - large
 * @property int|null $with_children
 * @property int|null $alive
 * @property int $is_tracks 0 - boar, 1 - tracks
 * @property string|null $description
 * @property int $user_id
 * @property int $position_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Photo|null $photo
 * @property-read Position|null $position
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Report newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Report query()
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereAlive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereIsTracks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereWithChildren($value)
 * @mixin \Eloquent
 */
class Report extends Model
{
    protected $fillable = [
        'size',
        'with_children',
        'alive',
        'is_tracks',
        'description',
        'user_id',
    ];

    public static function boot(){
        parent::boot();

        static::deleting(function($report) {
            $report->position()->delete();
        });
    }

    public function position(){
        return $this->hasOne(Position::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function photo(){
        return $this->hasOne(Photo::class);
    }
}
