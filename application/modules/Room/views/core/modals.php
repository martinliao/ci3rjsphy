<style type="text/css">
    .modal-command {
        padding: 15px;
        text-align: right;
        border-top: 1px solid #e5e5e5;
    }
</style>
<!-- modal -->
<div class="modal fade" id="querybooking" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">XXX 第X期 訓練期程XX小時 預約教室</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
                    <input type="hidden" id="seq_no" name="seq_no" value="<?= set_value('seq_no', $form['seq_no']); ?>">
                    <div class="row">
                        <div class="form-group col-xs-6 required <?= form_error('range') ? 'has-error' : ''; ?>">
                            <label class="control-label">使用起日</label>
                            <input type="text" class="form-control <?=form_error('start_date')?'has-error':'';?> datepicker" id="set_start_date" name="start_date" value="<?=substr(set_value('start_date', $form['start_date']),0,10); ?>" onchange="check_year(this)"/>
                            <span class="input-group-addon" style="cursor: pointer;" id="datepicker2"><i class="fa fa-calendar"></i></span>
                        </div>
                        <div class="form-group col-xs-6 required <?= form_error('range') ? 'has-error' : ''; ?>">
                            <label class="control-label">使用迄日</label>
                            <input type="text" class="form-control <?=form_error('start_date')?'has-error':'';?> datepicker" id="set_start_date" name="start_date" value="<?=substr(set_value('start_date', $form['start_date']),0,10); ?>" onchange="check_year(this)"/>
                            <span class="input-group-addon" style="cursor: pointer;" id="datepicker2"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </form>
                <div class="modal-command">
                        <button type="submit" class="btn btn-success" id="btn">查詢</button>
                </div>
                <div class="card-body pad table-responsive">
                    <table class="table table-bordered table-sm" id="myData" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="data">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary" id="btn">開始預約教室</button>
            </div>
        </div>
    </div>
</div>