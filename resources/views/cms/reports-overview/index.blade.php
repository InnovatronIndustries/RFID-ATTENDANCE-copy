@extends('layouts.app')

@section('content')

<div class="container">

    <div class="crumbs">
        <ul id="breadcrumbs" class="breadcrumb">
            <li><i class="icon-list"></i><a href="#!">Reports</a></li>
            <li class="current"><a href="#">Reports Overview</a></li>
        </ul>
    </div>

    <div class="page-header"></div>

    @if(Auth::user()->role_id !== 4)
    <div class="alert alert-info fade in">
        <strong>Some reports are currently under maintenance. <br /> Once available, other report modules will be displayed here.</strong>
    </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <h3>Admin</h3> <hr />
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
            <div class="statbox widget box box-shadow">
                <div class="widget-content">
                    <div class="title">Attendance Report</div>
                    <a href="{{ route('attendance-report.index') }}" class="more">
                        View <i class="pull-right icon-angle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
