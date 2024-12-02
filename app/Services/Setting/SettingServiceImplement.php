<?php

namespace App\Services\Setting;

use LaravelEasyRepository\Service;
use Illuminate\Support\Facades\Storage;

class SettingServiceImplement extends Service implements SettingService {

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $pathData;

    public function __construct()
    {
      $this->pathData = 'settings.json';
    }

    public function getSetting() {
      if(!Storage::exists($this->pathData)) {
        return [
          'app_title' => 'Stockify',
          'app_logo' => '/storage/app/public/images/logo/stockify_logo.svg',
        ];
      }

      $data = json_decode(Storage::get($this->pathData), true);

      if(!is_array($data)) {
        return [
          'app_title' => 'Stockify',
          'app_logo' => '/storage/app/public/images/logo/stockify_logo.svg',
        ];
      }

      if(!str_starts_with($data['app_logo'], '/storage')) {
        $data['app_logo'] = '/storage/app' . $data['app_logo']; 
      }
      
      return $data;
    }

    public function updateSetting($data) {
      $currentSetting = $this->getSetting();
      $newSetting = array_merge($currentSetting, $data);

      Storage::put($this->pathData, json_encode($newSetting, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
  }
