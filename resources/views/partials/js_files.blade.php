
{{-- in webpack --}}
<script src="{{ asset('template/assets/js/libs/jquery-1.10.2.min.js') }}"></script>
<script src="{{ asset('js/all.js') }}"></script>
{{-- <script src="{{ asset('template/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js') }}"></script>
<script src="{{ asset('template/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('template/assets/js/libs/lodash.compat.min.js') }}"></script>
<script src="{{ asset('template/plugins/touchpunch/jquery.ui.touch-punch.min.js') }}"></script>

<script src="{{ asset('template/plugins/event.swipe/jquery.event.move.js') }}"></script>
<script src="{{ asset('template/plugins/event.swipe/jquery.event.swipe.js') }}"></script>

<script src="{{ asset('template/assets/js/libs/breakpoints.js') }}"></script>
<script src="{{ asset('template/plugins/respond/respond.min.js') }}"></script>
<script src="{{ asset('template/plugins/cookie/jquery.cookie.min.js') }}"></script>

<script src="{{ asset('template/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('template/plugins/slimscroll/jquery.slimscroll.horizontal.min.js') }}"></script> --}}

{{-- <script src="{{ asset('template/plugins/sparkline/jquery.sparkline.min.js') }}"></script> --}}
{{-- <script src="{{ asset('template/plugins/flot/jquery.flot.min.js') }}"></script>
<script src="{{ asset('template/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
<script src="{{ asset('template/plugins/flot/jquery.flot.resize.min.js') }}"></script>
<script src="{{ asset('template/plugins/flot/jquery.flot.time.min.js') }}"></script>
<script src="{{ asset('template/plugins/flot/jquery.flot.growraf.min.js') }}"></script>
<script src="{{ asset('template/plugins/easy-pie-chart/jquery.easy-pie-chart.min.js') }}"></script>
--}}

{{-- <script src="{{ asset('template/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('template/plugins/blockui/jquery.blockUI.min.js') }}"></script> --}}
{{-- <script src="{{ asset('template/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
<script src="{{ asset('template/plugins/noty/jquery.noty.js') }}"></script>
<script src="{{ asset('template/plugins/noty/layouts/top.js') }}"></script>
<script src="{{ asset('template/plugins/noty/themes/default.js') }}"></script>
<script src="{{ asset('template/plugins/uniform/jquery.uniform.min.js') }}"></script>
<script src="{{ asset('template/assets/js/app.js') }}"></script>
<script src="{{ asset('template/assets/js/plugins.js') }}"></script>
<script src="{{ asset('template/assets/js/plugins.form-components.js') }}"></script>
<script src="{{ asset('template/plugins/fileinput/fileinput.js') }}"></script> --}}
{{-- <script src="{{ asset('addons/bootstrap-tour/build/js/bootstrap-tour-standalone.min.js') }}"></script> --}}
{{-- <script src="{{ asset('template/assets/js/custom.js') }}"></script> --}}
{{-- <script src="{{ asset('template/assets/js/demo/pages_calendar.js') }}"></script> --}}
{{-- <script src="{{ asset('template/assets/js/demo/charts/chart_filled_blue.js') }}"></script>
<script src="{{ asset('template/assets/js/demo/charts/chart_simple.js') }}"></script> --}}
{{-- <script src="{{ asset('template/js/sweetalert.min.js') }}"></script> --}}
{{-- <script src="{{ asset('addons/air-datepicker/dist/js/datepicker.min.js') }}"></script>
<script src="{{ asset('addons/air-datepicker/dist/js/i18n/datepicker.en.js') }}"></script> --}}
{{-- <script src="{{ asset('template/js/bootstrap-select.min.js') }}"></script> --}}
{{-- <script src="{{ asset('') }}"></script>
<script src="{{ asset('') }}"></script> --}}


<!-- Demo JS -->
<script>
$(document).ready(function(){
    "use strict";
    App.init(); // Init layout and core plugins
    Plugins.init(); // Init all plugins
    FormComponents.init(); // Init all form-specific plugins
});
</script>

{{-- <script src="{{asset('js/all1.js')}}"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
@include('partials.datatables')

<script type="text/javascript" src="{{asset('template/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.js')}}"></script>

{{-- base url for laravel app --}}
<script type="text/javascript">
    var APP_URL = {!! json_encode(url('/')) !!}
</script>

{{-- air-datepicker js --}}
<script src="{{ asset('packages/air-datepicker-master/dist/js/datepicker.min.js') }}"></script>

<!-- Include English language -->
<script src="{{ asset('packages/air-datepicker-master/dist/js/i18n/datepicker.en.js') }}"></script>

{{-- air-datepicker functions --}}
<script src="{{ asset('js/air-datepicker/index.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="{{ asset('js/select2.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
{{-- 02/21/2022 --}}

<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    $('[data-toggle="popover"]').popover({
        container: 'body'
    });
});
</script>