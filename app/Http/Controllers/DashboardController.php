<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use App\Models\MaintenanceTask;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        abort_unless($user instanceof User, 403);

        // Statistics
        $totalRequests = MaintenanceRequest::count();
        $pendingRequests = MaintenanceRequest::where('status', 'pending')->count();
        $inProgressRequests = MaintenanceRequest::where('status', 'in_progress')->count();
        $completedRequests = MaintenanceRequest::where('status', 'completed')->count();

        $recentRequests = MaintenanceRequest::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $unreadNotifications = Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();

        // For staff, show their assigned tasks
        $myTasks = [];
        if ($user->isStaff()) {
            $myTasks = MaintenanceTask::with('request')
                ->where('assigned_to', $user->id)
                ->where('status', '!=', 'completed')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        return view('dashboard', compact(
            'totalRequests',
            'pendingRequests',
            'inProgressRequests',
            'completedRequests',
            'recentRequests',
            'unreadNotifications',
            'myTasks'
        ));
    }
}
