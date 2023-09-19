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
                    <h4>New School</h4>
                </div>
                <div class="widget-content">
                    <form action="{{ route('manage-schools.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

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
                                        value="{{ old('name') }}"
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
                                        value="{{ old('rfid_subdomain') }}"
                                        class="form-control"
                                        placeholder="Enter RFID Subdomain ex. sjcnihs-aa"
                                    />
                                </div>
                            </div>
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
                                    >{{ old('address') }}</textarea>
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
