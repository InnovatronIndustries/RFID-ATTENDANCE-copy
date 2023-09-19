@extends('layouts.app')

@section('content')

<div class="container">

    <div class="crumbs">
        <ul id="breadcrumbs" class="breadcrumb">
            <li><i class="icon-list"></i><a href="#!">Access Management</a></li>
            <li class="current"><a href="#">Users</a></li>
        </ul>
        <ul class="crumb-buttons">
            <li>
                <a href="{{ route('users.create') }}">
                    <i class="icol-application-add"></i> <span>New</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="page-header"></div>

    <div class="row">
        <div class="col-md-12">
            @include('layouts/includes/message')
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="widget">
                <div class="widget-header">
                    <h4>List of Users</h4>
                </div>
                <div class="widget-content">

                    <div class="row no-gutter">
                        <div class="col-md-12">
                            <h5>Filter by:</h5>
                        </div>

                        @if(Auth::user()->role_id == 1)
                        <div class="col-lg-2 col-md-3">
                            <div class="form-group">
                                <select id="tbFilterBySchool" class="form-control">
                                    <option value="">-Select School-</option>
                                    @foreach($schools as $school)
                                        <option value="{{$school->id}}">{{$school->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
        
                        <div class="col-lg-2 col-md-3">
                            <div class="form-group">
                                <select id="tbFilterByRole" class="form-control">
                                    <option value="">-Select Role-</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->name}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row col-lg-12" style="overflow-x: auto;">
                        <table class="table table-condensed table-striped table-bordered table-hover table-responsive" id="usersTbl" width="100%">
                            <thead class="bg-blue">
                                <tr>
                                    <th class="exclude-export">Avatar</th>
                                    <th>RFID</th>
                                    <th>Full Name</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th class="exclude-export">School ID</th>
                                    <th>School</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyData">
                                @foreach ($users as $key => $user)
                                <tr>
                                    <td>{{ $user->avatar }}</td>
                                    <td>{{ $user->uid }}</td>
                                    <td>
                                        @if($user->is_active)
                                            <a href="{{ route('users.edit', ['user' => $user->id]) }}">{{ $user->fullname }}</a>
                                        @else
                                            {{ $user->fullname }}
                                        @endif
                                    </td>
                                    <td>{{ $user->role->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->school_id }}</td>
                                    <td>{{ $user->school->name?? 'N/A' }}</td>
                                    <td>{{ $user->status }}</td>
                                    <td>{{ $user->formatted_created_at }}</td>
                                    <td>{{ $user->formatted_updated_at }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>

    let tbl = $('#usersTbl').DataTable({
        pagingType: "full_numbers",
        autoWidth: false,
        processing: false,
        language: { processing: " "},
        columns: [
            {
                data: 'avatar',
                render: function (data, type, row, meta) {
                    let avatar = '';
                    if (data) {
                        avatar = `
                        <p class="text-center">
                            <a href="${data}" target="_blank">
                                <img src="${data}" width="50vh" />
                            </a>
                        </p>`;
                    }
                    return avatar;
                }
            },
            { data: 'uid', name: 'uid' },
            { data: 'fullname', name: 'fullname' },
            { data: 'role', name: 'role' },
            { data: 'email', name: 'email' },
            { data: 'school_id', name: 'school_id' },
            { data: 'school_name', name: 'school_name' },
            { data: 'status', name: 'status' },
            { data: 'formatted_created_at', name: 'formatted_created_at' },
            { data: 'formatted_updated_at', name: 'formatted_updated_at' },
        ],
        columnDefs: [
            {
                targets: '_all',
                defaultContent: "" // set default content to catch null values
            },
            {
                "targets": [ 5 ],
                "visible": false
            }
        ],
        dom: 'B<"d-flex w-100 pt-5"<l><"#mydiv.d-flex ml-auto text-right"f>>rtip',
        buttons: [
            {
                extend: 'copy',
                text: '<i class="icon-copy"></i> Copy', 
                className: 'btn btn-default btn-sm',
                messageTop: 'Academe Access - Users',
                title: '',
                filename: 'users_' + new Date().getTime(),
                exportOptions: {
                    columns: ':not(.exclude-export)'
                }
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV', 
                className: 'btn btn-default btn-sm',
                messageTop: 'Academe Access - Users',
                title: '',
                filename: 'users_' + new Date().getTime(),
                exportOptions: {
                    columns: ':not(.exclude-export)'
                }
            },
            {
                extend: 'excel',
                text: '<i class="far fa-file-excel"></i> Excel', 
                className: 'btn btn-default btn-sm',
                messageTop: 'Academe Access - Users',
                title: '',
                filename: 'users_' + new Date().getTime(),
                exportOptions: {
                    columns: ':not(.exclude-export)'
                }
            }
        ]
    });

    $('#tbFilterBySchool').on('change', function() {
        tbl.columns(5).search(this.value).draw();
    });

    $('#tbFilterByRole').on('change', function() {
        tbl.columns(3).search(this.value).draw();
    });

</script>

@stop
