<ul id="nav">
    <!-- display modules -->
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
                <a href="#!">
                    <i class="icon-angle-right"></i>
                    Users*
                </a>
            </li>
        </ul>
    </li>

    <li class="{{ Request::is('grading*') ? 'current' : '' }}">
        <a href="#!">
            <i class="icon-user"></i>
            Manage Students
        </a>
    </li>

    {{-- <li class="{{ Request::is('grading*') ? 'current' : '' }}">
        <a href="#!">
            <i class="icon-file-text"></i>
            Grading
        </a>

        <ul class="sub-menu">
            <li class="{{ Request::is('grading/character-trait*') ? 'current' : '' }}">
                <a href="{{ route('character-trait.index') }}">
                    <i class="icon-angle-right"></i>
                    Character Traits
                </a>
            </li>
            <li class="{{ Request::is('grading/grading-scale*') ? 'current' : '' }}">
                <a href="{{ route('grading-scale.index') }}">
                    <i class="icon-angle-right"></i>
                    Grading Scale
                </a>
            </li>
            <li class="{{ Request::is('grading/encodeSubjectGrade*') ? 'current' : '' }}">
                <a href="{{ route('encodeSubjectGrade.index') }}">
                    <i class="icon-angle-right"></i>
                    Encode Subject Grades
                </a>
            </li>
        </ul>
    </li>
    --}}

</ul>
