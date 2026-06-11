<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <title>@yield('title', 'Админ-панель')</title>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>

<div class="admin-wrapper">
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <span>Кедровый</span>
            </a>
            <button class="sidebar-toggle d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <nav class="sidebar-nav collapse d-lg-block" id="sidebarMenu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Дашборд</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.applications.index') }}"
                       class="nav-link {{ request()->routeIs('admin.applications.*') ? 'active' : '' }}">
                        <i class="bi bi-calendar-check"></i>
                        <span>Бронирования</span>
                        @php
                            $pendingCount = \App\Models\Application::where('status', \App\Enums\ApplicationStatusEnum::PENDING)->count();
                        @endphp
                        @if($pendingCount > 0)
                            <span class="badge bg-danger rounded-pill ms-auto">{{ $pendingCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.services.index') }}"
                       class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                        <i class="bi bi-briefcase"></i>
                        <span>Услуги</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.rooms.index') }}"
                       class="nav-link {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                        <i class="bi bi-door-open"></i>
                        <span>Номера</span>
                    </a>
                </li>
                <li class="nav-item mt-3 pt-3 border-top">
                    <a href="/" class="nav-link">
                        <i class="bi bi-house"></i>
                        <span>На сайт</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="sidebar-footer">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                   data-bs-toggle="dropdown">
                    <div class="user-avatar">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <div class="user-info">
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <small class="text-muted">Администратор</small>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-box-arrow-right"></i> Выйти
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="admin-content">
        <div class="container-fluid py-4">
            @yield('content')
        </div>
    </main>
</div>

<!-- Scripts -->
<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script defer src="/js/admin.js?v=1"></script>

</body>
</html>
