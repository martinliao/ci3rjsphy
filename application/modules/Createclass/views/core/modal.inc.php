<style type="text/css">
    .modal-header .close {
        margin-top: -17px !important;
        font-size: 36px;
        outline: none;
    }
    .modal-dialog80 {
        width: 70% !important;
    }
    .pointer {
        cursor: pointer;
    }
</style>
<!-- modal -->
<div class="modal fade" id="booking_room" tabindex="-1" role="dialog" aria-labelledby="myBookRoomLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog80 modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">預約教室</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="show_data">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary" id="btn">開始預約教室</button>
                <!--button type="button" class="btn btn-success btn-sm" id="tambah2">開始預約教室</button-->
            </div>
        </div>
    </div>
</div>
