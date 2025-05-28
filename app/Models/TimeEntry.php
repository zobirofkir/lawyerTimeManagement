<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeEntry extends Model
{
    protected $fillable = [
        "user_id",
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
