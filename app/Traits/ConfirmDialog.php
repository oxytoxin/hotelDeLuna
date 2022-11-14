<?php

namespace App\Traits;

trait ConfirmDialog
{
    public function confirmDialog($details = [])
    {
        $this->dispatchBrowserEvent('confirm',[
            'title' => $details['title'] ?? 'Are you sure?',
            'message' => $details['description'] ?? 'This action cannot be undone.',
            'confirmButtonText' => $details['accept']['label'] ?? 'Yes, continue',
            'cancelButtonText' => $details['reject']['label'] ?? 'No, cancel',
            'confirmMethod' => $details['accept']['method'] ?? 'confirm',
            'confirmParams' => $details['accept']['params'] ?? [],
            'cancelMethod' => $details['reject']['method'] ?? null,
            'cancelParams' => $details['reject']['params'] ?? [],
        ]);
    }

    public function sample()
    {
        $this->dispatchBrowserEvent('confirm',[
            'title' => "Are you sure?",
            'message' => "This action cannot be undone.",
            'confirmMethod' => $details['accept']['method'] ?? 'confirm',
            'confirmParams' => 1,
        ]);
    }
}