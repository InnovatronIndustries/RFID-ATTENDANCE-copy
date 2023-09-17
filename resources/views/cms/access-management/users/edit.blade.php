@extends('layouts.app')

@section('content')
<div class="container">

    <div class="crumbs">
        <ul id="breadcrumbs" class="breadcrumb">
            <li><i class="icon-list"></i><a href="#!">Access Management</a></li>
            <li><a href="{{ route('users.index') }}">Users</a></li>
        </ul>
        <ul class="crumb-buttons">
            <li>
                <a href="{{ route('users.index') }}">
                    <i class="icol-arrow-undo"></i> <span>Back</span>
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('users.destroy', ['user' => $user->id]) }}">
                    <input type="hidden" name="_method" value="DELETE" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <button type="submit" class="btn" style="margin-top: 3px;" onclick="return confirm('Deactivate this user?');">
                        <i class="icol-application-delete"></i> <span>Deactivate</span>
                    </button>
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
        <div class="col-md-8">
            <div class="widget box">
                <div class="widget-header">
                    <h4>Edit User</h4>
                </div>
                <div class="widget-content">
                    <form method="POST" action="{{ route('users.update', ['user' => $user->id]) }}" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Card ID (For RFID)</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                name="uid"
                                                value="{{ $user->uid }}"
                                                placeholder="Ex. 0295745843"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="avatar">Avatar</label>
                                            <input type="file" name="avatar" data-style="fileinput" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required">Role</label>
                                    <select name="role_id" id="role_id" class="form-control select2-general" required>
                                        <option value="">-Select Role-</option>
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}"
                                                {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required">First Name</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="firstname"
                                        value="{{ $user->firstname }}"
                                        placeholder="First Name"
                                        required
                                    />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Middle Name</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="middlename"
                                        value="{{ $user->middlename }}"
                                        placeholder="Middle Name (Optional)"
                                    />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required">Last Name</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="lastname"
                                        value="{{ $user->lastname }}"
                                        placeholder="Last Name"
                                        required
                                    />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input
                                        type="email"
                                        class="form-control"
                                        name="email"
                                        value="{{ $user->email }}"
                                        placeholder="Enter Email Address"
                                    />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea
                                        name="address"
                                        id="address"
                                        class="form-control"
                                        cols="30"
                                        rows="5"
                                        style="resize: vertical;"
                                    >{{ $user->address }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Position</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="position"
                                        value="{{ $user->position }}"
                                        placeholder="Ex. Admin / Coordinator"
                                    />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Employee Code</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="employee_code"
                                        value="{{ $user->employee_code }}"
                                    />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Contact Person</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="contact_person"
                                        value="{{ $user->contact_person }}"
                                    />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Contact No.</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="contact_no"
                                        value="{{ $user->contact_no }}"
                                    />
                                </div>
                            </div>
                        </div>

                        <hr />

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
