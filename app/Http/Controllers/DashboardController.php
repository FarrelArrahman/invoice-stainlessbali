<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $years = range(2023, 2019);
        return view('dashboard', [
            'years' => $years
        ]);
    }
}
