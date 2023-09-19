@extends('layouts.app')

@section('content')

<div class="container">

    <div class="crumbs">
        <ul id="breadcrumbs" class="breadcrumb">
            <li><i class="icon-sitemap"></i><a href="#!">Manage Schools</a></li>
        </ul>
        <ul class="crumb-buttons">
            <li>
                <a href="{{ route('manage-schools.create') }}">
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
                    <h4>List of Schools</h4>
                </div>
                <div class="widget-content">
                    <div class="row col-lg-12" style="overflow-x: auto;">
                        <table class="table table-condensed table-striped table-bordered table-hover table-responsive" id="schoolTbl" width="100%">
                            <thead class="bg-blue">
                                <tr>
                                    <th>Name</th>
                                    <th>Logo</th>
                                    <th>Banner (Background Image)</th>
                                    <th>RFID Subdomain</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($schools as $school)
                                <tr>
                                    <td>
                                        <a href="{{ route('manage-schools.edit', ['manage_school' => $school->id]) }}">
                                            {{ $school->name }}
                                        </a>
                                    </td>
                                    <td>
                                        @if($school->logo)
                                            <p class="text-center">
                                                <img src="{{ $school->logo }}" alt="school-logo" width="50vh" />
                                            </p>
                                        @endif
                                    </td>
                                    <td>
                                        @if($school->banner)
                                            <p class="text-center">
                                                <img src="{{ $school->banner }}" alt="school-banner" width="200" />
                                            </p>
                                        @endif
                                    </td>
                                    <td>
                                        @if($school->rfid_subdomain)
                                            <a href="{{ 'http://'.$school->rfid_subdomain.'.academeportal.com' }}" target="_blank">{{ $school->rfid_subdomain }}</a>
                                        @endif
                                    </td>
                                    <td>{{ $school->address }}</td>
                                    <td>{{ $school->is_active ? 'Active' : 'Inactive' }}</td>
                                    <td>{{ $school->created_at }}</td>
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
    $('#schoolTbl').DataTable({
        language: {
            emptyTable: 'No data to display.'
        },
        pageLength: 10,
        aLengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        // order: [[ 5, "desc" ]]
    });
</script>

@stop
