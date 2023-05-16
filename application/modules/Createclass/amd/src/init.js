define(['jquery'], function($) {
debugger;
    $('#tambah').click(function() {
        var seqNo = $(this).data('seq_no');
        $("#booking_room").modal("show");
        $('#show_data').load('Room/add/' + seqNo);
    });
});