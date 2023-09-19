@extends('layouts.app')

@section('content')

<div class="container">
    <div class="crumbs">
        <ul id="breadcrumbs" class="breadcrumb">
            <li><i class="icon-home"></i><a href="#!">Dashboard</a></li>
        </ul>
    </div>

    <div class="page-header"></div>

    <div class="row">
        <div class="col-md-12">
            @include('layouts/includes/message')
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 col-md-3">
            <div class="statbox widget box box-shadow">
                <div class="widget-content">
                    <div class="d-flex justify-content-between">
                        <div class="title">Total Users</div>
                    </div>
                    <div class="value" style="margin-top: 5px;">{{ $totalUsers }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="statbox widget box box-shadow">
                <div class="widget-content">
                    <div class="d-flex justify-content-between">
                        <div class="title">Total Students</div>
                    </div>
                    <div class="value" style="margin-top: 5px;">{{ $totalStudents }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="statbox widget box box-shadow">
                <div class="widget-content">
                    <div class="d-flex justify-content-between">
                        <div class="title">Total Employees</div>
                    </div>
                    <div class="value" style="margin-top: 5px;">{{ $totalEmployees }}</div>
                </div>
            </div>
        </div>
    </div>

</div>



@stop