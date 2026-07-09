@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="page-title">
            <i class="fas fa-user-plus text-white me-2"></i> Assign Task
        </h2>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-tools me-2"></i>
                    Assign: {{ $maintenanceRequest->title }}
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3 p-3 rounded-3" style="background: rgba(102,126,234,0.05);">
                    <p class="mb-1"><strong>📍 Location:</strong> {{ $maintenanceRequest->location }}</p>
                    <p class="mb-0"><strong>⚠️ Urgency:</strong>
                        <span class="badge badge-urgency-{{ $maintenanceRequest->urgency }}">
                            {{ ucfirst($maintenanceRequest->urgency) }}
                        </span>
                    </p>
                </div>

                <form action="{{ route('maintenance.assign', $maintenanceRequest->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-user text-primary me-1"></i> Staff Member
                        </label>
                        <select name="staff_id" class="form-control" required>
                            <option value="">Select Staff</option>
                            @foreach($staff as $staffMember)
                            <option value="{{ $staffMember->id }}">{{ $staffMember->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-flag text-primary me-1"></i> Priority Level
                        </label>
                        <select name="priority" class="form-control" required>
                            <option value="low">🟢 Low</option>
                            <option value="medium" selected>🟡 Medium</option>
                            <option value="high">🟠 High</option>
                            <option value="critical">🔴 Critical</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-sticky-note text-primary me-1"></i> Additional Notes
                        </label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Add any instructions or details..."></textarea>
                    </div>

                    <div class="d-grid gap-2 d-md-flex">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check me-2"></i> Assign Task
                        </button>
                        <a href="{{ route('maintenance.show', $maintenanceRequest->id) }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
