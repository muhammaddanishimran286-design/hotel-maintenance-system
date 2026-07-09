<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use App\Models\MaintenanceTask;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaintenanceRequestController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        abort_unless($user instanceof User, 403);

        if ($user->isAdmin() || $user->isManager()) {
            $requests = MaintenanceRequest::with('user', 'task')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $requests = MaintenanceRequest::where('user_id', $user->id)
                ->with('task')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('maintenance.index', compact('requests'));
    }

    public function create()
    {
        return view('maintenance.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'urgency' => 'required|in:low,medium,high,critical',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('maintenance', 'public');
        }

        $maintenanceRequest = MaintenanceRequest::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'location' => $validated['location'],
            'urgency' => $validated['urgency'],
            'status' => 'pending',
            'image' => $imagePath,
        ]);

        $admins = User::whereIn('role', ['admin', 'manager'])->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'request_id' => $maintenanceRequest->id,
                'message' => "New maintenance request: {$maintenanceRequest->title} from {$maintenanceRequest->location}",
                'is_read' => false,
            ]);
        }

        return redirect()->route('maintenance.index')
            ->with('success', 'Maintenance request submitted successfully!');
    }

    public function show(MaintenanceRequest $maintenanceRequest)
    {
        $maintenanceRequest->load('user', 'task.assignedTo');
        return view('maintenance.show', compact('maintenanceRequest'));
    }

    public function edit(MaintenanceRequest $maintenanceRequest)
    {
        return view('maintenance.edit', compact('maintenanceRequest'));
    }

    public function update(Request $request, MaintenanceRequest $maintenanceRequest)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'urgency' => 'required|in:low,medium,high,critical',
            'status' => 'required|in:pending,in_progress,on_hold,completed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($maintenanceRequest->image) {
                Storage::disk('public')->delete($maintenanceRequest->image);
            }
            $validated['image'] = $request->file('image')->store('maintenance', 'public');
        }

        if ($validated['status'] === 'completed' && $maintenanceRequest->status !== 'completed') {
            $validated['completed_at'] = now();
        }

        $maintenanceRequest->update($validated);

        return redirect()->route('maintenance.index')
            ->with('success', 'Maintenance request updated successfully!');
    }

    public function destroy(MaintenanceRequest $maintenanceRequest)
    {
        if ($maintenanceRequest->image) {
            Storage::disk('public')->delete($maintenanceRequest->image);
        }

        $maintenanceRequest->delete();

        return redirect()->route('maintenance.index')
            ->with('success', 'Maintenance request deleted successfully!');
    }

    public function assignForm(MaintenanceRequest $maintenanceRequest)
    {
        $staff = User::where('role', 'staff')->get();
        return view('maintenance.assign', compact('maintenanceRequest', 'staff'));
    }

    public function assign(Request $request, MaintenanceRequest $maintenanceRequest)
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:users,id',
            'priority' => 'required|in:low,medium,high,critical',
            'notes' => 'nullable|string',
        ]);

        $task = MaintenanceTask::create([
            'request_id' => $maintenanceRequest->id,
            'assigned_to' => $validated['staff_id'],
            'assigned_by' => Auth::id(),
            'priority' => $validated['priority'],
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        $maintenanceRequest->update(['status' => 'in_progress']);

        Notification::create([
            'user_id' => $validated['staff_id'],
            'request_id' => $maintenanceRequest->id,
            'message' => "You have been assigned to: {$maintenanceRequest->title}",
            'is_read' => false,
        ]);

        return redirect()->route('maintenance.show', $maintenanceRequest)
            ->with('success', 'Task assigned successfully!');
    }
}
