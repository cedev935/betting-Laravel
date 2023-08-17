<?php

namespace App\Http\Controllers;

use App\Events\UpdateAdminNotification;
use App\Events\UpdateUserNotification;
use App\Models\Admin;
use App\Models\SiteNotification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class SiteNotificationController extends Controller
{
    public function showByAdmin()
    {
        $siteNotifications = SiteNotification::whereHasMorph(
            'siteNotificational',
            [Admin::class],
            function ($query) {
                $query->where([
                    'site_notificational_id' => Auth::id()
                ]);
            }
        )->latest()->get();

        return $siteNotifications;
    }

    public function show()
    {
        $siteNotifications = SiteNotification::whereHasMorph(
            'siteNotificational',
            [User::class],
            function ($query) {
                $query->where([
                    'site_notificational_id' => Auth::id()
                ]);
            }
        )->latest()->get();

        return $siteNotifications;
    }

    public function readAt($id)
    {
        $siteNotification = SiteNotification::find($id);
        if ($siteNotification) {
            $siteNotification->delete();
            if (Auth::guard('admin')->check()) {
                event(new UpdateAdminNotification(Auth::id()));
            } else {
                event(new UpdateUserNotification(Auth::id()));
            }
            $data['status'] = true;
        } else {
            $data['status'] = false;
        }
        return $data;
    }

    public function readAllByAdmin()
    {
        $siteNotification = SiteNotification::whereHasMorph(
            'siteNotificational',
            [Admin::class],
            function ($query) {
                $query->where([
                    'site_notificational_id' => Auth::id()
                ]);
            }
        )->delete();

        if ($siteNotification) {
            event(new UpdateAdminNotification(Auth::id()));
        }
        $data['status'] = true;
        return $data;
    }

    public function readAll()
    {
        $siteNotification = SiteNotification::whereHasMorph(
            'siteNotificational',
            [User::class],
            function ($query) {
                $query->where([
                    'site_notificational_id' => Auth::id()
                ]);
            }
        )->delete();
        if ($siteNotification) {
            event(new UpdateUserNotification(Auth::id()));
        }

        $data['status'] = true;
        return $data;
    }
}
