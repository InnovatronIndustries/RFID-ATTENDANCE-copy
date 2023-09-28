@extends('layouts.app')

@section('content')

    <link href="{{ asset('css/custom/printable/dailyCollectionReport.css') }}" rel="stylesheet" media="all" />

    <div class="container">
        <div class="crumbs">
            <ul id="breadcrumbs" class="breadcrumb">
                <li><i class="icon-list"></i><a href="#!">Reports</a></li>
                <li><a href="{{ route('reports-overview.index') }}">Reports Overview</a></li>
                <li class="current"><a href="#">Attendance Report</a></li>
            </ul>
            <ul class="crumb-buttons">
                <li>
                    <a href="javascript:void(0);" id="printMe">
                        <i class="icol-printer"></i> <span>Print</span>
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

        <div class="row no-gutter-sm no-print" style="margin-bottom: 5px;">
            <form id="filterForm" action="{{ route('attendance-report.index') }}" method="GET">
                <input type="hidden" name="dateFilter" value="true">
                
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="required">From:</label>
                            <input type="text" name="from" id="from" class="form-control from-date"
                                value="{{ $data['from'] ?? '' }}"
                                style="background-color:#FFFFFF; color:#565656; cursor:text;"
                                data-date-format="yyyy-mm-dd" readonly />
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="required">To:</label>
                            <input type="text" name="to" id="to" class="form-control to-date"
                            value="{{ $data['to'] ?? '' }}"
                                style="background-color:#FFFFFF; color:#565656; cursor:text;"
                                data-date-format="yyyy-mm-dd" readonly />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="required">Level</label>
                            <select name="level" id="level" class="form-control select2-general" required>
                                <option value="">-Select Level-</option>
                                <option value="0">N/A</option>
                                @foreach($data['levels'] as $level)
                                    <option value="{{ $level }}"
                                        {{ $data['selectedLevel'] == $level ? 'selected' : '' }}>
                                        {{ $level }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Section</label>
                            <select name="section" id="section" class="form-control select2-general">
                                <option value="">-Select Section-</option>
                                <option value="0">N/A</option>
                                @foreach($data['sections'] as $section)
                                    <option value="{{ $section }}"
                                        {{ $data['selectedSection'] == $section ? 'selected' : '' }}>
                                        {{ $section }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6 d-flex">
                        <div class="form-group pr-5">
                            <button type="button" class="btn btn-md btn-info btn-block" id="filterBtn" style="margin-top: 23px;">
                                <i class="icon-search"></i>
                                Filter Results
                            </button>
                        </div>
                        <div class="form-group pl-5">
                            <a href="{{ route('attendance-report.index') }}" class="btn btn-md btn-default btn-block" id="clearBtn" style="margin-top: 23px;">
                                <i class="icon-remove"></i>
                                Clear
                            </a>
                        </div>
                    </div>
                </div>
                
            </form>
        </div>

        <div class="row print-div">
            <div class="col-md-12">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:1px;padding:0px;">
                            <table width="100%">
                                <tr>
                                    <td>
                                        <img src="{{ $data['school_logo'] }}" alt="" height="40px" width="40px" style="vertical-align: middle;" />
                                        <h2 class="schoolTitle">{{ $school->name }}</h2>
                                    </td>
                                </tr>
                                <tr><td colspan="2">&nbsp;</td></tr>
                                <tr>
                                    <td>Report Type: Attendance Report</td>
                                    <td>Date Generated: <span id="time"></span></td>
                                </tr>
                                <tr>
                                    <td>Level / Section: <span class="level-section-span"></span></td>
                                </tr>
                            </table>
                            <br />
    
                            <table border="1" style="width:100%;height:100%;" class="attendanceReportTable">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="3%">#</th>
                                        <th class="text-center">Student Name</th>
                                        <th class="text-center">Level & Section</th>
                                        <th class="text-center">Log Type</th>
                                        <th class="text-center">Log Date/Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['logs'] as $key => $log)
                                    <tr>
                                        <td>{{ $key +1 }}</td>
                                        <td>{{ $log->user->fullname }}</td>
                                        <td>{{ $log->user->student->level.' - '.$log->user->student->section }}</td>
                                        <td class="text-center">{{ $log->type }}</td>
                                        <td class="text-center">{{ $log->log_date }}</td>
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

    $(() => {
        const selectedLevelSection = `{{ $data['selectedLevelSection'] }}`;
        if (selectedLevelSection) {
            $('.level-section-span').html(selectedLevelSection);
        }
    });

    $('.from-date').datepicker({
        language: 'en',
        position: "bottom left",
        autoClose: true
    });

    $('.to-date').datepicker({
        language: 'en',
        position: "bottom left",
        autoClose: true
    });

    $('#printMe').click(function() {
        let current_time = new Date().toLocaleTimeString();
        let timestamp = new Date().toJSON().slice(0, 10);
        window.print();
    });

    $('#filterBtn').click(function(e) {
        e.preventDefault();
        let from =  $('.from-date').val();
        let to =  $('.to-date').val();
        let level = $('#level').val();
        let section = $('#section').val();

        if (from != '' && to != '') {
            $("#filterForm").submit();
        }else {
            alert('Please complete field dates.')
        }
    });

    let timeDisplay = document.getElementById("time");

    function refreshTime() {
        let dateString = new Date().toLocaleString("en-US", { timeZone: "Asia/Manila" });
        let formattedString = dateString.replace(", ", " - ");
        timeDisplay.innerHTML = formattedString;
    }

    setInterval(refreshTime, 1000);
</script>

@stop