define(['jquery','datatables', 'daterangepicker'], function($) {
    $('#tambah').click(function() {
        var seqNo = $(this).data('seq_no');
        $("#booking_room").modal("show");
        $('#show_data').load(M.cfg.wwwroot + '/Room/add/' + seqNo);
    });
});