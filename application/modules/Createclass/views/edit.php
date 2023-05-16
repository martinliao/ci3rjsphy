<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<?=$_LOCATION['function']['name'] ;?>
				<!-- test button -->
				<button type="button" class="btn btn-success btn-sm" id="tambah" data-seq_no=<?= $form['seq_no']?> >
					<i class="fas fa-plus"></i>
					Test預約教室鈕
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
<?php include('core/modal.inc.php');?>

<script type="text/javascript">
	function getFormObj($form) {
		var formObj = {};
		var inputs = $form.serializeArray();
		inputs = inputs.concat(
			$form.find('input[type=checkbox]').map(
							function () {
								return { "name": this.name, "value": this.value }
							}).get());

		$.each(inputs, function (i, input) {
			formObj[input.name] = input.value;
		});
		return formObj;
	}
    document.addEventListener("DOMContentLoaded", () => {
		//const form = $('.modal-body').html();
		/*$('#tambah').click(function() {
			var seqNo = $(this).data('seq_no');
			$("#booking_room").modal("show");
			$('#show_data').load('<?= site_url('Room/add') ?>/' + seqNo);
        });/** */
		require(['mod_Createclass/init'], function(init) {
			debugger;
			init.init();
		});
	});
</script>