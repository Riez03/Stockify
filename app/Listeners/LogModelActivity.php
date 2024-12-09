<?php

namespace App\Listeners;

use App\Events\ModelActivity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\File;

class LogModelActivity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ModelActivity $event): void
    {
        $activity = [
            'user_id' => $event->user->name,
            'action' => $event->action,
            'entity' => $event->entity,
            'entity_name' => $event->entity_name,
            'message' => $event->message,
            'timestamp' => $event->timestamp,
        ];

        $filePath = public_path('data/userActivities.json');
    
        $activities = [];

        if(File::exists($filePath)) {
            $activities = json_decode(File::get($filePath), true);

            if(!is_array($activities)) {
                $activities = [];
            }
        }

        $activities[] = $activity;

        File::put($filePath, json_encode($activities, JSON_PRETTY_PRINT));
    }
}
