@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="page-title">
            <i class="fas fa-chart-pie text-white me-2"></i> Dashboard
        </h2>
    </div>
</div>

<!-- ===== STATISTICS ===== -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stats-card total">
            <div class="icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="number">{{ $totalRequests ?? 0 }}</div>
            <div class="label">Total Requests</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card pending">
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="number">{{ $pendingRequests ?? 0 }}</div>
            <div class="label">Pending</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card progress">
            <div class="icon">
                <i class="fas fa-spinner fa-spin"></i>
            </div>
            <div class="number">{{ $inProgressRequests ?? 0 }}</div>
            <div class="label">In Progress</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card completed">
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="number">{{ $completedRequests ?? 0 }}</div>
            <div class="label">Completed</div>
        </div>
    </div>
</div>

<!-- ===== RECENT REQUESTS ===== -->
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-history me-2"></i> Recent Maintenance Requests</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Location</th>
                                <th>Urgency</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentRequests ?? [] as $request)
                            <tr>
                                <td><strong>#{{ $request->id }}</strong></td>
                                <td>{{ Str::limit($request->title, 30) }}</td>
                                <td><i class="fas fa-map-marker-alt text-primary me-1"></i> {{ $request->location }}</td>
                                <td>
                                    <span class="badge badge-urgency-{{ $request->urgency }}">
                                        {{ ucfirst($request->urgency) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-status-{{ str_replace('_', '-', $request->status) }}">
                                        {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        {{ $request->created_at->diffForHumans() }}
                                    </small>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-inbox fa-2x text-muted mb-2 d-block"></i>
                                    <p class="text-muted">No requests found. Create your first request!</p>
                                    <a href="{{ route('maintenance.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Create Request
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== MY TASKS (STAFF) ===== -->
    @if(auth()->user()->isStaff())
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-tasks me-2"></i> My Tasks</h5>
            </div>
            <div class="card-body">
                @forelse($myTasks ?? [] as $task)
                <div class="mb-3 p-3 border rounded-3" style="border-color: rgba(102,126,234,0.2) !important;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <strong>{{ $task->request->title }}</strong>
                            <br>
                            <small class="text-muted">
                                <i class="fas fa-map-marker-alt text-primary me-1"></i>
                                {{ $task->request->location }}
                            </small>
                        </div>
                    </div>
                    <div class="mt-2">
                        <span class="badge badge-status-{{ str_replace('_', '-', $task->status) }}">
                            {{ ucfirst($task->status) }}
                        </span>
                        <span class="badge badge-urgency-{{ $task->priority }}">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <i class="fas fa-check-circle fa-3x text-success mb-3 d-block"></i>
                    <p class="text-muted">No tasks assigned! 🎉</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
