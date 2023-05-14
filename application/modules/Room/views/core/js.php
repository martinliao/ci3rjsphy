<script>
    //document.addEventListener("DOMContentLoaded", () => {
        $("input[name='room_type']").change(function() {
            $.each($("input[name='room_type']"), function() {
                this.setCustomValidity('');
            });
            var checked = $("input[name='room_type']:checked").length;
            if (checked == 0) {
                $("input[name='room_type']")[0].setCustomValidity('請至少選擇1種.');
            }
        });
        $("#query_room_form").submit(function(e) {
            e.preventDefault();
            console.log('submit!!');
            var checked = $("input[name='room_type']:checked").length;
            if (checked == 0) {
                $("input[name='room_type']")[0].setCustomValidity('請至少選擇1種.');
                $("input[name='room_type']")[0].reportValidity();
                return false;
            }
            getBookingLists(1,2,3);
            return false;
        });
    //});

    function getBookingLists() {
        console.log('getLists');
        var csrfObj = {
            "<?= $csrf['name']; ?>": "<?= $csrf['hash']; ?>"
        };
        //var tmp = $('#roomData');
        if (!$.fn.DataTable.isDataTable('#roomData')) {
            $('#roomData').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    "data": csrfObj,
                    "url": "<?php echo site_url('Room/getLists'); ?>",
                    "type": "POST"
                },
                "columnDefs": [{
                    "targets": [0],
                    "orderable": false
                }]
            });
            $('#roomData').DataTable().columns([2]).visible(false);
        } else {
            $('#roomData').DataTable().ajax.reload();
        }
    }

    const form = $('.modal-body').html();
    //$('#data').on('click', '.edit', function() {
    $('#classroom_data').on('click', '.edit', function() {
        //$('.modal-body').html(form);
debugger;
        catId = $(this).data('cat_id');
        seqNo = $(this).data('seq_no');
        $("#querybooking").modal("show");
        //$('#show_data').load('<?= site_url('Room') ?>');
    });
</script>
