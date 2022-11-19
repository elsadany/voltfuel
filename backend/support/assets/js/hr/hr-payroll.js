$(function(e){

	//________ Data Table
	$('#hr-payroll').DataTable({
		"order": [[ 0, "desc" ]],
		order: [],
		columnDefs: [ { orderable: false, targets: [7] } ],
		language: {
			searchPlaceholder: 'Search...',
			sSearch: '',
			
		}
	});

	//______Select2
	$('.select2').select2({
		minimumResultsForSearch: Infinity,
		width:'100%'
	});

	//______Input Filebrowaser
	$(document).on('change', ':file', function() {
		var input = $(this),
		numFiles = input.get(0).files ? input.get(0).files.length : 1,
		label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
	input.trigger('fileselect', [numFiles, label]);
	});// We can watch for our custom `fileselect` event like this
	$(document).ready( function() {
		$(':file').on('fileselect', function(event, numFiles, label) {
		var input = $(this).parents('.input-group').find(':text'),
		log = numFiles > 1 ? numFiles + ' files selected' : label;
		if( input.length ) {
			input.val(log);
		} else {
			if( log ) alert(log);
		}
	  });
	});

	//________ Datepicker
	$( '.fc-datepicker').datepicker({
		dateFormat: "dd MM yy",
		zIndex: 999998,
	});

 });
