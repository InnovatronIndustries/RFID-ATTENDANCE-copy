@extends('layouts.app')

@section('content')
<div class="container">

    <div class="crumbs">
        <ul id="breadcrumbs" class="breadcrumb">
            <li><i class="icon-sitemap"></i><a href="#!">Manage Schools</a></li>
        </ul>
        <ul class="crumb-buttons">
            <li>
                <a href="{{ route('manage-schools.index') }}">
                    <i class="icol-arrow-undo"></i> <span>Back</span>
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('manage-schools.destroy', ['manage_school' => $school->id]) }}">
                    <input type="hidden" name="_method" value="DELETE" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    @if($school->is_active)
                        <button type="submit" class="btn" style="margin-top: 3px;" onclick="return confirm('Deactivate this school?');">
                            <i class="icol-application-delete"></i> <span>Deactivate</span>
                        </button>
                    @else
                        <button type="submit" class="btn" style="margin-top: 3px;" onclick="return confirm('Activate this school?');">
                            <i class="icol-application-add"></i> <span>Activate</span>
                        </button>
                    @endif
                </form>
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
        <div class="col-md-12">
            <div class="widget box">
                <div class="widget-header">
                    <h4>Edit School Information</h4>
                </div>
                <div class="widget-content">
                    <form method="POST" action="{{ route('manage-schools.update', ['manage_school' => $school->id]) }}" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="school_id" value="{{ $school->id }}">
                        @csrf

                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <div class="text-center" style="margin-top: 25px;">
                                    <a href="{{ $school->logo }}" target="_blank">
                                        <img
                                            src="{{ $school->logo }}"
                                            alt="school-logo"
                                            style="max-width: 15vh;"
                                        />
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <table class="table table-condensed table-striped">
                                    <tbody>
                                        <tr>
                                            <td class="text-bold">School Name:</td>
                                            <td>{{ $school->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold">School Address:</td>
                                            <td>{{ $school->address }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold">School Banner:</td>
                                            <td>
                                                @if($school->banner)
                                                    <a href="{{ $school->banner }}" target="_blank">
                                                        <img src="{{ $school->banner }}" width="300" height="300" alt="school-banner" />
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr />

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>School Logo:</label>
                                    <input type="file" name="logo" data-style="fileinput" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        School Banner (Background Image):
                                        <span>
                                            <i class="icon-question-sign"
                                                data-trigger="hover"
                                                data-placement="top"
                                                data-html="true"
                                                data-toggle="popover"
                                                title=''
                                                data-content="School Banner will be displayed on the rfid attendance form. <br /> Recommended resolution: (1298x393)"
                                            ></i>
                                        </span>
                                    </label>
                                    <input type="file" name="banner" data-style="fileinput" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required">School Name</label>
                                    <input 
                                        type="text" 
                                        class="form-control"
                                        name="name"
                                        value="{{ $school->name }}"
                                        placeholder="Enter School Name"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required">RFID Subdomain</label>
                                    <input
                                        type="text"
                                        name="rfid_subdomain"
                                        value="{{ $school->rfid_subdomain }}"
                                        class="form-control"
                                        placeholder="Enter RFID Subdomain ex. sjcnihs-aa"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required">School Address</label>
                                    <textarea
                                        name="address"
                                        id="address"
                                        class="form-control"
                                        style="resize: vertical;"
                                        cols="30"
                                        rows="2"
                                    >{{ $school->address }}</textarea>
                                </div>
                            </div>
                        </div>

                        <br />

                        <div class="form-actions">
                            <button type="submit" class="btn btn-md btn-success pull-right" id="submitBtn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>

@stop
