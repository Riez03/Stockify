<?php

namespace App\Listeners;

use App\Events\EntityActivity;
use App\Events\ModelActivity;
use App\Events\ProductActivity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
            'user_id' => $event->user->id,
            'action' => $event->action,
            'entity' => $event->entity,
            'entity_name' => $event->entity_name,
            'message' => $event->message,
            'timestamp' => $event->timestamp,
        ];
    
        $activities = session()->get('product_activities', []);
        
        $activities[] = $activity;
    
        session()->put('product_activities', $activities);
    }
}
