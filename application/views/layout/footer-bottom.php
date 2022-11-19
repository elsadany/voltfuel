		<!-- <script type="text/javascript">
			$(function () {
				$('.languageselectpicker').selectpicker();
			});
		</script> -->
	<script type="text/javascript">

		$(document).ready(function () {

		<?php
		if ($this->session->flashdata('success_msg')) {
		?>
				successMsg("<?php echo $this->session->flashdata('success_msg'); ?>");
		<?php
		} else if ($this->session->flashdata('error_msg')) {
		?>
				errorMsg("<?php echo $this->session->flashdata('error_msg'); ?>");
		<?php
		} else if ($this->session->flashdata('warning_msg')) {
		?>
				infoMsg("<?php echo $this->session->flashdata('warning_msg'); ?>");
		<?php
		} else if ($this->session->flashdata('info_msg')) {
		?>
				warningMsg("<?php echo $this->session->flashdata('info_msg'); ?>");
		<?php
		}
		?>
		});

 

function getplandetails(plan_id){
	var link = '<?= base_url()?>'+'admin/pricings/getplan/'+plan_id;
	console.log(link);
	$.ajax({
		type: "POST",
		url: link,
		data: {},
		cache: false,
		dataType: "JSON",
		success: function(result) {
			console.log(result);
			$('#plan_id').val(result.id);
			$('#edit_planname').val(result.plan_name);
			$('#edit_plantype').val(result.plan_type);
			$('#edit_planamount').val(result.plan_amount);
			$('#edit_plancategory').val(result.plan_categoryid);
			$('#edit_plandescription').val(result.plan_description);
			//$('#edit_plancategory').val(result.is_active);
			$('#edit_paymentmode').val(result.payment_mode_id);
			$('#edit_maxrental').val(result.max_rental_period);
			$('#edit_holdamount').val(result.max_charges);
			$('#edit_planswaps').val(result.no_of_swaps);
			//$('#edit_plancategory').val(result.is_recommended);
			$('#edit_validmonths').val(result.validity_months);
		}
	});
}

</script>

</body>
</html>