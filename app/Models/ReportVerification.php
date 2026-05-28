<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportVerification extends Model
{
    protected $guarded = ['id'];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
