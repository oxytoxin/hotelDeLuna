<?php

namespace App\Traits;

trait XNotification
{
    public function alert($details = [])
    {
        $this->dispatchBrowserEvent('notify',[
            'type' => $details['type'] ?? 'success',
            'title' => $details['title'] ?? 'Notification!',
            'message' => $details['message'] ?? 'Operation completed successfully.',
        ]);
    }
}