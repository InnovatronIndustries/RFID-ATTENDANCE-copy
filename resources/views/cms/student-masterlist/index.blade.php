@extends('layouts.app')

@section('content')

<div class="container">

    <div class="crumbs">
        <ul id="breadcrumbs" class="breadcrumb">
            <li><i class="icon-user"></i><a href="#!">Student Masterlist</a></li>
        </ul>
        <ul class="crumb-buttons">
            <li>
                <a href="{{ route('student-masterlist.create') }}">
                    <i class="icol-application-add"></i> <span>Enlistment</span>
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
                    <h4>Student Masterlist</h4>
                </div>

                <div class="widget-content">
                    <table class="table table-condensed table-striped table-bordered table-hover table-responsive" id="studentMasterlistTbl" width="100%">
                        <thead class="bg-blue">
                            <tr>
                                <th width="5%" class="exclude-export">Avatar</th>
                                <th class="exclude-export"></th>
                                <th>Student Name</th>
                                <th>RFID</th>
                                <th>Level / Section</th>
                                <th>Email</th>
                                <th>Contact No.</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyData"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<script>

    let tbl = $('#studentMasterlistTbl').DataTable({
        pagingType: "full_numbers",
        autoWidth: false,
        processing: false,
        serverSide: false,
        ajax: '{{ route('student-masterlist-dt.index') }}',
        language: { processing: " "},
        columns: [
            {
                data: 'avatar',
                render: function (data, type, row, meta) {
                    let avatar = '';
                    if (data) {
                        avatar = `
                        <p class="text-center">
                            <img src="${data}" width="40vh" />
                        </p>`;
                    }
                    return avatar;
                }
            },
            { data: 'fullname', name: 'fullname'},
            {
                data: 'student_links',
                name: 'student_links',
                render: function(data, type, row) {
                    return `<a href="${data.edit_link}">${data.fullname}</a>`;
                }
            },
            { data: 'user.uid', name: 'user.uid'},
            { data: 'level_section', name: 'level_section'},
            { data: 'user.email', name: 'user.email'},
            { data: 'user.contact_no', name: 'user.contact_no'},
            { data: 'formatted_created_at', name: 'formatted_created_at'},
        ],
        // order: [[7, 'desc']],
        columnDefs: [
            {
                targets: '_all',
                defaultContent: "" // set default content to catch null values
            },
            {
                "targets": [ 1 ],
                "visible": false
            }
        ],
        dom: 'B<"d-flex w-100 pt-5"<l><"#mydiv.d-flex ml-auto text-right"f>>rtip',
        buttons: [
            {
                extend: 'copy',
                text: '<i class="icon-copy"></i> Copy',
                className: 'btn btn-default btn-sm',
                messageTop: 'Academe Access - Student Masterlist',
                title: '',
                filename: 'studentMasterlist_' + new Date().getTime(),
                exportOptions: {
                    columns: ':not(.exclude-export)'
                }
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                className: 'btn btn-default btn-sm',
                messageTop: 'Academe Access - Student Masterlist',
                title: '',
                filename: 'studentMasterlist_' + new Date().getTime(),
                exportOptions: {
                    columns: ':not(.exclude-export)'
                }
            },
            {
                extend: 'excel',
                text: '<i class="far fa-file-excel"></i> Excel',
                className: 'btn btn-default btn-sm',
                messageTop: 'Academe Access - Student Masterlist',
                title: '',
                filename: 'studentMasterlist_' + new Date().getTime(),
                exportOptions: {
                    columns: ':not(.exclude-export)'
                }
            }
        ]
    });
</script>

@stop
