<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MarkNotificationAsRead
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->query('nid');
        $user = $request->user();
        if($id && $user)
        {
            $user->unreadNotifications->markAsRead(); // وبنخليه يعمل كل المش مقروء مقروء وبنعملها عالكوليكشن
            $notification = $user->unreadNotifications()->find($id);
            if($notification)
            {
                $notification->markAsRead();
            }
        }
        return $next($request);
    }
}
