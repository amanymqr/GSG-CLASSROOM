<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class UserNotificationMenue extends Component
{
    /**
     * Create a new component instance.
     */
    public $notifications;
    public $unreadCount;

    public function __construct($count = 10)
    {
        $user = Auth::user();
        $this->notifications = $user->notifications()
            ->take($count)
            ->get();

        $this->unreadCount = $user->unreadNotifications()->count();
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user-notification-menue');
    }
}
