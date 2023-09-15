<ul id="nav">
    <li class="{{ Request::is('/') ? 'current' : '' }}">
        <a href="{{ route('dashboard') }}">
            <i class="icon-home"></i>
            Dashboard
        </a>
    </li>
    <li class="{{ Request::is('super-admin/roles*') ? 'current' : '' }}">
        <a href="{{ route('roles.index') }}">
            <i class="icon-group"></i>
            Roles
        </a>
    </li>
    <li class="{{ Request::is('admin/users*') ? 'current' : '' }}">
        <a href="#!">
            <i class="icon-user"></i>
            System Users*
        </a>
    </li>
    <li class="{{ Request::is('admin/schools*') ? 'current' : '' }}">
        <a href="#!">
            <i class="icon-sitemap"></i>
            Manage Schools*
        </a>
    </li>
</ul>
