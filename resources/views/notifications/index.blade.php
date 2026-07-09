@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title">
        <i class="fas fa-bell text-white me-2"></i> Notifications
    </h2>
    <form action="{{ route('notifications.read-all') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-check-double me-2"></i> Mark All as Read
        </button>
    </form>
</div>

<div class="card">
    <div class="card-body">
        @forelse($notifications ?? [] as $notification)
        <div class="notification-item p-3 mb-2 rounded-3 {{ $notification->is_read ? '' : 'unread' }}">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1">
                        @if(!$notification->is_read)
                            <span class="badge bg-primary me-2">New</span>
                        @endif
                        {{ $notification->message }}
                    </p>
                    <small class="text-muted">
                        <i class="far fa-clock me-1"></i>
                        {{ $notification->created_at->diffForHumans() }}
                    </small>
                </div>
                @if(!$notification->is_read)
                <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-check me-1"></i> Mark as Read
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <i class="fas fa-bell-slash fa-4x mb-3 d-block" style="color: rgba(102,126,234,0.3);"></i>
            <h5 class="text-muted">No notifications</h5>
            <p class="text-muted">You're all caught up! 🎉</p>
        </div>
        @endforelse

        @if(isset($notifications) && method_exists($notifications, 'links'))
            <div class="d-flex justify-content-center mt-3">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
