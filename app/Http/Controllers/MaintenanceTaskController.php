<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceTask;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceTaskController extends Controller
{
    /**
     * Start a task.
     */
    public function start($id)
    {
        $task = MaintenanceTask::findOrFail($id);

        // Check if the logged-in user is assigned to this task
        if ($task->assigned_to !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not assigned to this task.');
        }

        $task->update([
            'status' => 'in_progress',
            'started_at' => now(),
        ]);

        // Update the request status
        $task->request->update(['status' => 'in_progress']);

        // Notify the manager
        $managers = User::whereIn('role', ['admin', 'manager'])->get();
        foreach ($managers as $manager) {
            Notification::create([
                'user_id' => $manager->id,
                'request_id' => $task->request_id,
                'message' => "Task started: {$task->request->title} by " . Auth::user()->name,
                'is_read' => false,
            ]);
        }

        return redirect()->back()->with('success', 'Task started successfully!');
    }

    /**
     * Complete a task.
     */
    public function complete($id)
    {
        $task = MaintenanceTask::findOrFail($id);

        if ($task->assigned_to !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not assigned to this task.');
        }

        $task->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        // Update the request status
        $task->request->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        // Notify the manager
        $managers = User::whereIn('role', ['admin', 'manager'])->get();
        foreach ($managers as $manager) {
            Notification::create([
                'user_id' => $manager->id,
                'request_id' => $task->request_id,
                'message' => "Task completed: {$task->request->title} by " . Auth::user()->name,
                'is_read' => false,
            ]);
        }

        return redirect()->back()->with('success', 'Task completed successfully! 🎉');
    }
}
