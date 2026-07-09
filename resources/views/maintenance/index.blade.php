@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title">
        <i class="fas fa-tools text-white me-2"></i> Maintenance Requests
    </h2>
    @if(auth()->user()->isAdmin() || auth()->user()->isManager() || auth()->user()->isReceptionist())
    <a href="{{ route('maintenance.create') }}" class="btn btn-primary">
        <i class="fas fa-plus-circle me-2"></i> New Request
    </a>
    @endif
</div>

<div class="card">
    <div class="card-body">
        @if(isset($requests) && $requests->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Location</th>
                        <th>Reported By</th>
                        <th>Urgency</th>
                        <th>Status</th>
                        <th>Assigned To</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                    <tr>
                        <td><strong>#{{ $request->id }}</strong></td>
                        <td>{{ Str::limit($request->title, 25) }}</td>
                        <td>
                            <i class="fas fa-map-marker-alt text-primary me-1"></i>
                            {{ $request->location }}
                        </td>
                        <td>
                            <i class="fas fa-user text-primary me-1"></i>
                            {{ $request->user->name ?? 'Unknown' }}
                        </td>
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
                            @if($request->task)
                                <span class="badge bg-info text-white">
                                    {{ $request->task->assignedTo->name ?? 'N/A' }}
                                </span>
                            @else
                                <span class="text-muted">Not assigned</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('maintenance.show', $request->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                                <a href="{{ route('maintenance.edit', $request->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if(!$request->task)
                                <a href="{{ route('maintenance.assign.form', $request->id) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-user-plus"></i>
                                </a>
                                @endif
                                <form action="{{ route('maintenance.destroy', $request->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this request?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if(method_exists($requests, 'links'))
            <div class="d-flex justify-content-center mt-3">
                {{ $requests->links() }}
            </div>
        @endif
        @else
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-4x text-muted mb-3 d-block" style="color: rgba(102,126,234,0.3) !important;"></i>
            <h5 class="text-muted">No maintenance requests found</h5>
            <p class="text-muted">Start by creating your first request!</p>
            <a href="{{ route('maintenance.create') }}" class="btn btn-primary mt-2">
                <i class="fas fa-plus-circle"></i> Create First Request
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
