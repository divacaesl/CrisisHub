<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerTask extends Model
{
    protected $guarded = ['id'];

    public function volunteer()
    {
        return $this->belongsTo(User::class, 'volunteer_id');
    }

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
