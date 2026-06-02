<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteerApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone_number',
        'city',
        'skills',
        'experience',
        'status',
        'category',
        'certification',
        'cv_path',
        'motivation',
        'availability',
        'assignment_area',
        'emergency_contact_name',
        'emergency_contact_relation',
        'emergency_contact_phone',
        'preferred_team',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
