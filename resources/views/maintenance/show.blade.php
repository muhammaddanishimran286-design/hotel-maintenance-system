@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h2 class="page-title">
            <i class="fas fa-file-alt text-white me-2"></i> Request Details
        </h2>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-hashtag me-2"></i> #{{ $maintenanceRequest->id }}
                </h5>
                <div>
                    <span class="badge badge-status-{{ str_replace('_', '-', $maintenanceRequest->status) }} me-1">
                        {{ ucfirst(str_replace('_', ' ', $maintenanceRequest->status)) }}
                    </span>
                    <span class="badge badge-urgency-{{ $maintenanceRequest->urgency }}">
                        {{ ucfirst($maintenanceRequest->urgency) }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <h3 class="mb-3">{{ $maintenanceRequest->title }}</h3>
                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <p>
                            <strong><i class="fas fa-map-marker-alt text-primary me-2"></i>Location:</strong>
                            {{ $maintenanceRequest->location }}
                        </p>
                        <p>
                            <strong><i class="fas fa-align-left text-primary me-2"></i>Description:</strong>
                        </p>
                        <p class="p-3 bg-light rounded-3" style="background: rgba(102,126,234,0.05) !important;">
                            {{ $maintenanceRequest->description }}
                        </p>
                        <p>
                            <strong><i class="fas fa-user text-primary me-2"></i>Reported By:</strong>
                            @if($maintenanceRequest->user)
                                <span class="badge bg-info text-white">{{ $maintenanceRequest->user->name }}</span>
                            @else
                                Unknown User
                            @endif
                        </p>
                        <p>
                            <strong><i class="fas fa-calendar-alt text-primary me-2"></i>Date:</strong>
                            {{ $maintenanceRequest->created_at->format('d M Y H:i') }}
                        </p>
                    </div>
                </div>

                @if($maintenanceRequest->image)
                <div class="mt-3">
                    <img src="{{ asset('storage/' . $maintenanceRequest->image) }}"
                         class="img-fluid rounded-3" style="max-height: 300px; border: 3px solid rgba(102,126,234,0.2);">
                </div>
                @endif

                @if($maintenanceRequest->task)
                <hr>
                <div class="mt-3 p-3 rounded-3" style="background: rgba(102,126,234,0.05);">
                    <h6 class="mb-3"><i class="fas fa-tasks text-primary me-2"></i>Task Details</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Assigned To:</strong>
                                <span class="badge bg-info text-white">
                                    {{ $maintenanceRequest->task->assignedTo->name ?? 'Not Assigned' }}
                                </span>
                            </p>
                            <p><strong>Priority:</strong>
                                <span class="badge badge-urgency-{{ $maintenanceRequest->task->priority ?? 'medium' }}">
                                    {{ ucfirst($maintenanceRequest->task->priority ?? 'N/A') }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Task Status:</strong>
                                <span class="badge badge-status-{{ str_replace('_', '-', $maintenanceRequest->task->status ?? 'pending') }}">
                                    {{ ucfirst($maintenanceRequest->task->status ?? 'N/A') }}
                                </span>
                            </p>
                            @if($maintenanceRequest->task->notes ?? false)
                                <p><strong>Notes:</strong> {{ $maintenanceRequest->task->notes }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('maintenance.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Back
                    </a>
                    @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                    <a href="{{ route('maintenance.edit', $maintenanceRequest->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i> Edit
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        @if((auth()->user()->isAdmin() || auth()->user()->isManager()) && !$maintenanceRequest->task)
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Assign Task</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('maintenance.assign', $maintenanceRequest->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Staff Member</label>
                        <select name="staff_id" class="form-control" required>
                            <option value="">Select Staff</option>
                            @php
                                $staff = \App\Models\User::where('role', 'staff')->get();
                            @endphp
                            @foreach($staff as $staffMember)
                            <option value="{{ $staffMember->id }}">{{ $staffMember->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Priority</label>
                        <select name="priority" class="form-control" required>
                            <option value="low">🟢 Low</option>
                            <option value="medium" selected>🟡 Medium</option>
                            <option value="high">🟠 High</option>
                            <option value="critical">🔴 Critical</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Add any instructions..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-check me-2"></i> Assign Task
                    </button>
                </form>
            </div>
        </div>
        @endif

        @if($maintenanceRequest->task && $maintenanceRequest->task->assigned_to == auth()->id())
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-play-circle me-2"></i>Task Actions</h5>
            </div>
            <div class="card-body text-center">
                @if($maintenanceRequest->task->status == 'pending')
                <form action="{{ route('tasks.start', $maintenanceRequest->task->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-play me-2"></i> Start Task
                    </button>
                </form>
                @endif

                @if($maintenanceRequest->task->status == 'in_progress')
                <form action="{{ route('tasks.complete', $maintenanceRequest->task->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-check-circle me-2"></i> Complete Task
                    </button>
                </form>
                @endif

                @if($maintenanceRequest->task->status == 'completed')
                <div class="py-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    <h5 class="text-success mt-3">Task Completed! 🎉</h5>
                    <p class="text-muted">
                        Completed on: {{ $maintenanceRequest->task->completed_at?->format('d M Y H:i') ?? 'Not recorded' }}
                    </p>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
