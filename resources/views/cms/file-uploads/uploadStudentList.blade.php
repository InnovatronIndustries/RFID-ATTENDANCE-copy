@extends('layouts.app')

@section('content')

<div class="container">

    <div class="crumbs">
        <ul id="breadcrumbs" class="breadcrumb">
            <li><i class="icon-user"></i><a href="#!">File Uploads</a></li>
            <li class="current"><a href="#!">Students</a></li>
        </ul>
    </div>

    <div class="page-header"></div>

    <div class="row">
        <div class="col-md-12">
            @include('layouts/includes/message')
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="widget">
                <div class="widget-header">
                    <h4>Import File</h4>
                </div>
                <div class="widget-content">
                    <form class="form-horizontal" action="{{route('uploadStudentList.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="alert alert-info fade in">
                                    <strong>Note:</strong>
                                    <li style="display: inline;">File must contain only 1 worksheet (Current Limitation)</li><br>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input type="file" name="file" id="file" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-5">
                                        <button class="btn btn-sm btn-success btn-block" id="submitBtn"
                                        onclick="return confirm('Are you sure you want to import this excel file?');"
                                        {{ count($data) ? 'disabled' : ''}}>
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@stop