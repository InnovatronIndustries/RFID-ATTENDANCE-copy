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

    <li class="{{ Request::is('student-masterlist*') ? 'current' : '' }}">
        <a href="{{ route('student-masterlist.index') }}">
            <i class="icon-user"></i>
            Student Masterlist
        </a>
    </li>

    <li class="{{ Request::is('file-uploads*') ? 'current' : '' }}">
        <a href="#!">
            <i class="icon-file-text"></i>
            File Uploads
        </a>
        <ul class="sub-menu">
            <li class="{{ Request::is('file-uploads/uploadStudentList*') ? 'current' : '' }}">
                <a href="{{ route('uploadStudentList.index') }}">
                    <i class="icon-angle-right"></i>
                    Students
                </a>
            </li>
            <li class="{{ Request::is('file-uploads/uploadEmployeeList*') ? 'current' : '' }}">
                <a href="{{ route('uploadEmployeeList.index') }}">
                    <i class="icon-angle-right"></i>
                    Employees
                </a>
            </li>
            <li class="{{ Request::is('file-uploads/uploadAvatarImages*') ? 'current' : '' }}">
                <a href="{{ route('uploadAvatarImages.index') }}">
                    <i class="icon-angle-right"></i>
                    Avatar / Images
                </a>
            </li>
        </ul>
    </li>
</ul>
