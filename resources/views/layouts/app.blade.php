<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏨 Hotel Maintenance System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            padding-top: 20px;
            box-shadow: 5px 0 30px rgba(0,0,0,0.3);
            position: sticky;
            top: 0;
        }

        .sidebar .brand {
            text-align: center;
            padding: 20px 15px 30px;
            border-bottom: 2px solid rgba(255,255,255,0.1);
        }

        .sidebar .brand h4 {
            color: #fff;
            font-weight: 700;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .sidebar .brand small {
            color: rgba(255,255,255,0.6);
        }

        .sidebar .user-info {
            text-align: center;
            padding: 20px 15px;
            border-bottom: 2px solid rgba(255,255,255,0.1);
        }

        .sidebar .user-info .avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-size: 24px;
            color: white;
            font-weight: 600;
            box-shadow: 0 5px 20px rgba(245, 87, 108, 0.4);
        }

        .sidebar .user-info .name {
            color: #fff;
            font-weight: 600;
            font-size: 14px;
        }

        .sidebar .user-info .role {
            color: rgba(255,255,255,0.6);
            font-size: 12px;
        }

        .sidebar .user-info .role-badge {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .sidebar .nav {
            padding: 15px 0;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.6);
            padding: 12px 25px;
            border-radius: 12px;
            margin: 4px 15px;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 14px;
        }

        .sidebar .nav-link i {
            width: 24px;
            margin-right: 12px;
            font-size: 16px;
        }

        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
            transform: translateX(5px);
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .sidebar .nav-link .badge {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            float: right;
            margin-top: 3px;
        }

        .sidebar .logout-btn {
            background: none;
            border: none;
            color: rgba(255,255,255,0.6);
            padding: 12px 25px;
            border-radius: 12px;
            margin: 4px 15px;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 14px;
            width: calc(100% - 30px);
            text-align: left;
        }

        .sidebar .logout-btn:hover {
            background: rgba(255,0,0,0.2);
            color: #ff6b6b;
            transform: translateX(5px);
        }

        .sidebar .logout-btn i {
            width: 24px;
            margin-right: 12px;
        }

        .sidebar-divider {
            border-color: rgba(255,255,255,0.08);
            margin: 10px 20px;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            min-height: 100vh;
            padding: 30px;
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(10px);
        }

        .main-content .page-title {
            color: #fff;
            font-weight: 700;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
            margin-bottom: 25px;
        }

        /* ===== CARDS ===== */
        .card {
            border-radius: 16px;
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(0,0,0,0.25);
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 16px 16px 0 0 !important;
            padding: 18px 25px;
            font-weight: 600;
            border: none;
        }

        .card-header h5 {
            margin: 0;
            font-weight: 600;
        }

        .card-body {
            padding: 25px;
        }

        /* ===== STATS CARDS ===== */
        .stats-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
            border: none;
        }

        .stats-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 50px rgba(0,0,0,0.25);
        }

        .stats-card .icon {
            font-size: 35px;
            margin-bottom: 10px;
        }

        .stats-card .number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .stats-card .label {
            color: #7f8c8d;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .stats-card.total .icon { color: #667eea; }
        .stats-card.pending .icon { color: #f39c12; }
        .stats-card.in-progress .icon { color: #3498db; }
        .stats-card.completed .icon { color: #2ecc71; }

        .stats-card.total .number { color: #667eea; }
        .stats-card.pending .number { color: #f39c12; }
        .stats-card.in-progress .number { color: #3498db; }
        .stats-card.completed .number { color: #2ecc71; }

        /* ===== BADGES ===== */
        .badge-urgency-critical {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
        }
        .badge-urgency-high {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: #333;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
        }
        .badge-urgency-medium {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            color: #333;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
        }
        .badge-urgency-low {
            background: linear-gradient(135deg, #a8edea 0%, #76d6d6 100%);
            color: #333;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
        }

        .badge-status-pending {
            background: #95a5a6;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
        }
        .badge-status-in-progress {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
        }
        .badge-status-in_progress {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
        }
        .badge-status-on-hold {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
        }
        .badge-status-on_hold {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
        }
        .badge-status-completed {
            background: linear-gradient(135deg, #a8edea 0%, #2ecc71 100%);
            color: #333;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
        }

        /* ===== BUTTONS ===== */
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 10px 25px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.5);
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        .btn-success {
            background: linear-gradient(135deg, #a8edea 0%, #2ecc71 100%);
            border: none;
            padding: 10px 25px;
            border-radius: 12px;
            font-weight: 600;
            color: #333;
            box-shadow: 0 5px 20px rgba(46, 204, 113, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(46, 204, 113, 0.5);
        }

        .btn-warning {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            border: none;
            padding: 10px 25px;
            border-radius: 12px;
            font-weight: 600;
            color: #333;
            box-shadow: 0 5px 20px rgba(250, 112, 154, 0.3);
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(250, 112, 154, 0.5);
        }

        .btn-danger {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
            padding: 10px 25px;
            border-radius: 12px;
            font-weight: 600;
            box-shadow: 0 5px 20px rgba(245, 87, 108, 0.3);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(245, 87, 108, 0.5);
        }

        .btn-info {
            background: linear-gradient(135deg, #a8edea 0%, #3498db 100%);
            border: none;
            padding: 10px 25px;
            border-radius: 12px;
            font-weight: 600;
            color: #333;
        }

        .btn-info:hover {
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255,255,255,0.3);
            padding: 10px 25px;
            border-radius: 12px;
            font-weight: 600;
            color: white;
        }

        .btn-secondary:hover {
            background: rgba(255,255,255,0.3);
            color: white;
        }

        /* ===== TABLE ===== */
        .table {
            border-radius: 12px;
            overflow: hidden;
        }

        .table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .table thead th {
            font-weight: 600;
            padding: 15px;
            border: none;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: rgba(102, 126, 234, 0.05);
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        /* ===== ALERTS ===== */
        .alert-success {
            background: linear-gradient(135deg, #a8edea 0%, #2ecc71 100%);
            border: none;
            color: #333;
            border-radius: 12px;
            font-weight: 500;
            box-shadow: 0 5px 20px rgba(46, 204, 113, 0.3);
        }

        .alert-danger {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
            color: white;
            border-radius: 12px;
            font-weight: 500;
            box-shadow: 0 5px 20px rgba(245, 87, 108, 0.3);
        }

        /* ===== FORM ===== */
        .form-control {
            border-radius: 12px;
            padding: 12px 18px;
            border: 2px solid rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.2);
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        /* ===== NOTIFICATIONS ===== */
        .notification-item {
            border-radius: 12px;
            transition: all 0.3s ease;
            border: none;
        }

        .notification-item:hover {
            background: rgba(102, 126, 234, 0.05);
        }

        .notification-item.unread {
            background: rgba(102, 126, 234, 0.08);
            border-left: 4px solid #667eea;
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.6s ease forwards;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        /* ===== SCROLLBAR ===== */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
                padding-bottom: 20px;
            }

            .main-content {
                padding: 15px;
            }

            .stats-card .number {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- ===== SIDEBAR ===== -->
            <div class="col-md-2 col-lg-2 sidebar">
                <div class="brand">
                    <h4>🏨 HMMS</h4>
                    <small>Hotel Maintenance System</small>
                </div>

                <div class="user-info">
                    <div class="avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="name">{{ Auth::user()->name }}</div>
                    <div class="role">
                        <span class="role-badge">{{ ucfirst(Auth::user()->role) }}</span>
                    </div>
                </div>

                <nav class="nav flex-column">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                    <a href="{{ route('maintenance.index') }}" class="nav-link {{ request()->routeIs('maintenance.*') ? 'active' : '' }}">
                        <i class="fas fa-tools"></i> Maintenance
                    </a>
                    @if(auth()->user()->isAdmin() || auth()->user()->isManager() || auth()->user()->isReceptionist())
                    <a href="{{ route('maintenance.create') }}" class="nav-link">
                        <i class="fas fa-plus-circle"></i> New Request
                    </a>
                    @endif
                    <a href="{{ route('notifications.index') }}" class="nav-link">
                        <i class="fas fa-bell"></i> Notifications
                        @php
                            $unreadCount = \App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->count();
                        @endphp
                        @if($unreadCount > 0)
                            <span class="badge pulse">{{ $unreadCount }}</span>
                        @endif
                    </a>
                    <hr class="sidebar-divider">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </nav>
            </div>

            <!-- ===== MAIN CONTENT ===== -->
            <div class="col-md-10 col-lg-10 main-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show animate-fade-in" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show animate-fade-in" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="animate-fade-in">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
