<script src="{{ url('public/adminlte') }}/bower_components/jquery/dist/jquery.min.js"></script>
<script src="{{ url('public/adminlte') }}/bower_components/jquery-ui/jquery-ui.min.js"></script>
<script src="{{ url('public/adminlte') }}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js">
</script>
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="{{ url('public/adminlte') }}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="{{ url('public/adminlte') }}/bower_components/raphael/raphael.min.js"></script>
<script src="{{ url('public/adminlte') }}/bower_components/morris.js/morris.min.js"></script>
<script src="{{ url('public/adminlte') }}/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="{{ url('public/adminlte') }}/dist/js/adminlte.min.js"></script>

<script src="{{ url('public/adminlte') }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ url('public/adminlte') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js">

<script src="{{ asset('adminlte') }}/plugins/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="{{ url('public/adminlte') }}/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
