<ul id="nav">
    <li class="{{ Request::is('/') ? 'current' : '' }}">
        <a href="{{ route('dashboard') }}">
            <i class="icon-home"></i>
            Dashboard
        </a>
    </li>
    <li class="{{ Request::is('manage-schools*') ? 'current' : '' }}">
        <a href="{{ route('manage-schools.index') }}">
            <i class="icon-sitemap"></i>
            Manage Schools
        </a>
    </li>
    <li class="{{ Request::is('access-management/roles*') ? 'current' : '' }}">
        <a href="{{ route('roles.index') }}">
            <i class="icon-group"></i>
            Roles
        </a>
    </li>
    <li class="{{ Request::is('access-management/users*') ? 'current' : '' }}">
        <a href="{{ route('users.index') }}">
            <i class="icon-user"></i>
            System Users
        </a>
    </li>
</ul>
