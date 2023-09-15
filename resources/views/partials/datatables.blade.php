<script src="{{ asset('datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('datatables/handlebars.min.js') }}"></script>

<script type="text/javascript">
    $('#demo').DataTable( {
        "pageLength": 10,
        "aLengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        "order": [[ 0, "desc" ]]
    });
</script>