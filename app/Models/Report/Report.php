<?php

namespace App\Models\Report;

use App\Models\Photo\Photo;
use App\Models\Position\Position;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'size',
        'with_children',
        'alive',
        'is_tracks',
        'description',
        'user_id',
        'position_id',
    ];

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
