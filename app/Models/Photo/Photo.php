<?php

namespace App\Models\Photo;

use App\Models\Report\Report;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $appends = ['url'];

    protected $fillable = [
        'directory', 'name', 'report_id'
    ];

    public function report(){
        return $this->belongsTo(Report::class);
    }

    public function getUrlAttribute(){
        return url(Storage::url($this->directory.$this->name));
    }
}
