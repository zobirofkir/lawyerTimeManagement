<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeEntry extends Model
{
    protected $fillable = [
        "project_id",
        'task',
        "description",
        "start_time",
        "end_time",
        "duration_minutes"
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
