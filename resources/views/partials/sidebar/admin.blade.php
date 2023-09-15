<ul id="nav">
    <li class="{{ Request::is('dashboard') ? 'current' : '' }}">
        <a href="{{ route('dashboard') }}">
            <i class="icon-home"></i>
            Dashboard
        </a>
    </li>

    <li class="{{ Request::is('grading*') ? 'current' : '' }}">
        <a href="#!">
            <i class="icon-bar-chart"></i>
            Reports (Coming Soon)
        </a>
    </li>

    <li class="{{ Request::is('access-management*') ? 'current' : '' }}">
        <a href="#!">
            <i class="icon-user"></i>
            Access Management
        </a>
        <ul class="sub-menu">
            <li class="{{ Request::is('access-management/roles*') ? 'current' : '' }}">
                <a href="{{ route('roles.index') }}">
                    <i class="icon-angle-right"></i>
                    Roles
                </a>
            </li>
            <li class="{{ Request::is('access-management/users*') ? 'current' : '' }}">
                <a href="{{ route('users.index') }}">
                    <i class="icon-angle-right"></i>
                    Users
                </a>
            </li>
        </ul>
    </li>

    <li class="{{ Request::is('students*') ? 'current' : '' }}">
        <a href="#!">
            <i class="icon-user"></i>
            Manage Students*
        </a>
    </li>
</ul>
