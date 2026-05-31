<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CenterController extends Controller
{
    public function volunteer()
    {
        return view('centers.volunteer');
    }

    public function organization()
    {
        return view('centers.organization');
    }

    public function admin()
    {
        return redirect()->route('admin.dashboard');
    }
}
