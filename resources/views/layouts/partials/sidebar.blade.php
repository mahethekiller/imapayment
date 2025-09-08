<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

    {{-- Always visible --}}
    <li class="nav-item">
        <a href="{{ route('dashboard') }}" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>Dashboard</p>
        </a>
    </li>

    {{-- Visible only to admins --}}
    @role('admin')
    <li class="nav-item">
        <a href="{{ route('users.index') }}" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>Manage Users</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('landing-pages.index') }}" class="nav-link">
            <i class="nav-icon fas fa-file"></i>
            <p>Landing Pages</p>
        </a>
    </li>
    @endrole

    {{-- Visible to admin & editor --}}
    @hasanyrole('admin|editor')
    <li class="nav-item">
        <a href="{{ route('posts.index') }}" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>Posts</p>
        </a>
    </li>
    @endhasanyrole

    {{-- Visible to members --}}
    @role('member')
    <li class="nav-item">
        <a href="{{ route('profile') }}" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>My Profile</p>
        </a>
    </li>
    @endrole

</ul>
