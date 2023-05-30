<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<?=$_LOCATION['function']['name'] ;?>
				<!-- test button -->
				<button type="button" class="btn btn-success btn-sm" id="tambah" data-seq_no=<?= $form['seq_no']?> >
					預約教室Test鈕
				</button>
			</div>
			<div class="panel-body">
				<?php include('form.inc.php');?>
			</div>
		</div>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<!-- 擴充開始 -->
<?php include('core/modal.inc.php');?>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
		/** Call Createclass/init with bootstrap-modal-plugin */
		require(['jquery',"core/log","mod_Createclass/init",'mod_bootstrapbase/bootstrap'], function($, log, createclass) { 
			log.setConfig({"level":"trace"}); 
			createclass.init();
		});
	});
</script>