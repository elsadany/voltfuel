<footer class="main-footer">
    &copy;  <?php echo date('Y'); ?>
    <?php echo $this->customlib->getAppName(); ?>
</footer>
<div class="control-sidebar-bg"></div>
</div>
<!-- <script>
    $.widget.bridge('uibutton', $.ui.button);
</script> -->
<?php
	$language      = $this->customlib->getLanguage();
	$language_name = $language["short_code"];
?>		

				<!-- jQuery -->
		<script src="<?php echo base_url(); ?>backend/assets/js/jquery-3.6.0.min.js"></script>

		<!-- Bootstrap Core JS -->
		<script src="<?php echo base_url(); ?>backend/assets/js/bootstrap.bundle.min.js"></script>

		<!-- Slimscroll JS -->
		<script src="<?php echo base_url(); ?>backend/assets/js/jquery.slimscroll.min.js"></script>

		<!-- Select2 JS -->
		<script src="<?php echo base_url(); ?>backend/assets/js/select2.min.js"></script>

		<!-- Datetimepicker JS -->
		<script src="<?php echo base_url(); ?>backend/assets/js/moment.min.js"></script>
		<script src="<?php echo base_url(); ?>backend/assets/js/bootstrap-datetimepicker.min.js"></script>
	
		<!-- Datatable JS -->
		<script src="<?php echo base_url(); ?>backend/assets/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url(); ?>backend/assets/js/dataTables.bootstrap4.min.js"></script>

		<!-- Summernote JS -->
		<script src="<?php echo base_url(); ?>backend/assets/plugins/summernote/dist/summernote-bs4.min.js"></script>
		
		<!-- Chart JS -->
		<script src="<?php echo base_url(); ?>backend/assets/plugins/morris/morris.min.js"></script>
		<script src="<?php echo base_url(); ?>backend/assets/plugins/raphael/raphael.min.js"></script>
		<script src="<?php echo base_url(); ?>backend/assets/js/chart.js"></script>


		<!-- Custom JS -->
		<script src="<?php echo base_url(); ?>backend/assets/js/app.js"></script>

		<!-- Map JS -->
		<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

				
