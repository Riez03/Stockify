<?php

namespace App\Services\Setting;

use LaravelEasyRepository\BaseService;

interface SettingService extends BaseService {
    public function getSetting();
    public function updateSetting($data);
}
