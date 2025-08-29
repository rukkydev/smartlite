<?php
namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Notifications extends Component
{
    public $notifications;

    public function mount()
    {   
    $this->notifications = Auth::user()->notifications;
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
            $this->notifications = Auth::user()->fresh()->notifications;
        }
    }

    public function render()
    {
        return view('livewire.notifications');
    }
}