<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        "client_id",
        "title",
        "description",
        "status",
        "start_date",
        "end_date"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
