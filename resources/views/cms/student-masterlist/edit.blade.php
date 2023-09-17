@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/custom/enlistment.css') }}" />
<link rel="stylesheet" href="{{ asset('template/plugins/jquery-steps/jquery.steps.css') }}" />
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>

<div class="container">

    <div class="crumbs">
        <ul id="breadcrumbs" class="breadcrumb">
            <li><i class="icon-user"></i><a href="#!">Student Masterlist</a></li>
        </ul>
        <ul class="crumb-buttons">
            <li>
                <a href="{{ route('student-masterlist.index') }}">
                    <i class="icol-arrow-undo"></i> <span>Back</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student-masterlist.create') }}">
                    <i class="icol-application-add"></i> <span>Enlistment</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="page-header"></div>
    <div class="row">
        <div class="col-lg-12">
            <div class="widget">
                <div class="widget-content">
                    <div class="container">
                        <h2 class="centered-text"><span>Edit Student Information</span></h2> <br />
                        <div class="row">
                            <div class="col-md-12">
                                @include('layouts/includes/message')
                            </div>
                        </div>
                    </div>

                    <form id="enlistmentForm" class="form-wizard1" action="#" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="{{$student->user_id}}" />

                        <div class="alert alert-sm alert-success fade in" id="successDiv" style="display: none;">
                            <i class="icon-remove close" data-dismiss="alert"></i>
                            <strong id="displaySuccessMsg"></strong>
                        </div>

                        <div class="alert alert-sm alert-danger fade in" id="errorDiv" style="display: none;">
                            <i class="icon-remove close" data-dismiss="alert"></i>
                            <ul id="errorUL" style="list-style-type: none;"></ul>
                        </div>

                        <!-- Student Information -->
                        <h3>Student Information</h3>
                        <fieldset>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="text-muted">
                                        Student Information (Put N/A if not applicable)
                                    </label>
                                </div>
                            </div>

                            <hr />

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="text-center" style="margin-top: 20px; margin-bottom: 10px;">
                                        <img src="{{$student->avatar}}" width="150" alt="student-avatar" />
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="lrn">Card ID (For RFID)</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="uid"
                                                    placeholder="Ex. 0295745843"
                                                    value="{{ $student->user->uid }}"
                                                />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="lrn">Learner's Reference No (LRN)</label>
                                                <input id="lrn" name="lrn" type="text" class="form-control" value="{{ $student->lrn }}" />
                                                <small>*Type N/A if not applicable</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="lrn">Student No.</label>
                                                <input id="student_no" name="student_no" type="text" class="form-control" value="{{ $student->student_no }}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="firstName" class="required">First Name</label>
                                                <input id="firstName" name="firstname" type="text" class="form-control" value="{{ $student->user->firstname }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="middleName">Middle Name</label>
                                                <input id="middleName" name="middlename" type="text" class="form-control"  value="{{ $student->user->middlename }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="lastName" class="required">Last Name</label>
                                                <input id="lastName" name="lastname" type="text" class="form-control"  value="{{ $student->user->lastname }}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="gender" class="required">Gender</label>
                                                <select name="gender" id="gender" class="form-control">
                                                    <option value="Male" {{ $student->user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                    <option value="Female" {{ $student->user->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="avatar">Avatar / Image</label>
                                                <input type="file" name="avatar" data-style="fileinput" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="birthdate">Date of Birth</label>
                                        <input id="birthdate" name="birthdate" type="date" class="form-control" max="{{ date('Y-m-d') }}" value="{{ $student->user->birthdate }}" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="emailAddress">Email Address (Optional)</label>
                                        <input id="emailAddress" name="email" type="email" class="form-control" value="{{ $student->user->email }}" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contactPerson">Contact Person</label>
                                        <input id="contactPerson" name="contact_person" type="text" class="form-control" value="{{ $student->user->contact_person }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contactNo">Contact No.</label>
                                        <input id="contactNo" name="contact_no" type="text" class="form-control" value="{{ $student->user->contact_no }}"  />
                                        <small>*Number used to receive SMS</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="level" class="required">Grave Level</label>
                                        <input id="level" name="level" type="text" class="form-control" value="{{ $student->level }}" required />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="section" class="required">Section</label>
                                        <input id="section" name="section" type="text" class="form-control" value="{{ $student->section }}" required />
                                    </div>
                                </div>
                            </div>

                            <hr />
                            <p>(*) Mandatory</p>
                        </fieldset>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ asset('template/plugins/validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('template/plugins/validation/additional-methods.min.js') }}"></script>
<script src="{{ asset('template/plugins/jquery-steps/jquery.steps.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

let form = $("#enlistmentForm").show();

form.steps({
    headerTag: "h3",
    bodyTag: "fieldset",
    transitionEffect: "fade",
    labels: {
        finish: "Save",
    },
    onStepChanging: function (event, currentIndex, newIndex) {
        // Allways allow previous action even if the current form is not valid!
        if (currentIndex > newIndex) {
            return true;
        }

        // Needed in some cases if the user went back (clean up)
        if (currentIndex < newIndex) {
            // To remove error styles
            form.find(".body:eq(" + newIndex + ") label.error").remove();
            form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
        }

        form.validate().settings.ignore = ":disabled,:hidden";
        return form.valid();
    },
    onStepChanged: function (event, currentIndex, priorIndex) {},
    onFinishing: function (event, currentIndex) {
        form.validate().settings.ignore = ":disabled";
        return form.valid();
    },
    onFinished: function (event, currentIndex) {

        let formData = new FormData($('#enlistmentForm')[0]);
        formData.append('_method', 'PATCH');

        // submit form
        event.preventDefault();
        if (confirm('Please verify the details before submitting the form. Are you sure you want to submit this form?')) {

            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

            $.ajax({
                type: 'POST',
                url: '{{ URL("student-masterlist/" . $student->id) }}',
                contentType: false,
                processData: false,
                data: formData,
                success: function (res) {
                    console.log(res);
                    $('#enlistmentForm').steps("reset");
                    window.location.reload();
                },
                error: function (err) {
                    if (err.status === 422) {
                        const errors = $.parseJSON(err.responseText);
                        $('#errorDiv').css('display', 'block');
                        $('#errorDiv').find('ul').empty();
                        $.each(errors.errors, function (key, value) {
                            $('#errorDiv').find('ul').append(`<li>${value[0]}</li>`);
                        });
                    } else {
                        const error = $.parseJSON(err.responseText);
                        console.log(error);
                        $('#successDiv').css('display', 'none');
                        $('#errorDiv').css('display', 'block');
                        $('#errorDiv').find('ul').empty();
                        $('#errorDiv').find('ul').append(`${error.message}`);
                    }
                }
            });
        }
    }
}).validate({
    errorPlacement: function errorPlacement(error, element) { element.before(error); },
    rules: {
        "firstname": "required",
        "lastname": "required",
        "gender": "required",
        "level": "required",
        "section": "required"
    }
});

</script>

@stop
