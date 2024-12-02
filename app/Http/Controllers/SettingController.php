<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\Setting\SettingService;

class SettingController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService) {
        $this->settingService = $settingService;
    }

    public function index() {
        $settings = $this->settingService->getSetting();

        return view('roles.admin.setting.index', [
            'title' => 'Application Settings',
            'setting' => $settings,
        ]);
    }

    public function update(Request $request) {
        $data = ['app_title' => $request->app_title];

        if($request->hasFile('app_logo')) {
            $path = $request->file('app_logo')->store('public/images/logo');
            $data['app_logo'] = Storage::url($path);
        }

        $this->settingService->updateSetting($data);

        notify()->preset('user-created', [
            'title' => 'Setting Updated',
            'message' => 'Setting has been updated successfully'
        ]);

        return redirect()->route('setting.index')->with('success', 'Settings updated successfully');
    }
}
