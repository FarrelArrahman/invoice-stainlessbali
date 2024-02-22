<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('admin.settings.index', ['setting' => $setting]);
    }

    public function update(Setting $setting, Request $request)
    {
        $data = [
            'value' => $request->value,
        ];

        $setting->update($data);

        return to_route('settings.index')
            ->with('message', "Berhasil memperbarui note.")
            ->with('status', 'success');
    }
}
