<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrganizationApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'organization_name',
        'type',
        'registration_number',
        'contact_person',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
