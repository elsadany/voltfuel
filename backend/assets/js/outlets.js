$(document).ready(function(){

    $('#outletstatus').change(function(){
        var outletstatus= $(this).val();
        var filter = outletstatus;
        getoutlets(filter);
    });

    $('#outletstatus').val('all').trigger('change');
});

function getoutlets(outletstatus) {
    console.log("TEst");
    $.ajax({
        url: baseurl + 'admin/outlets/getoutlets',
        type: "POST",
        data: { "outletstatus": outletstatus },
        success: function(response) {
           console.log(response); // server response
            //var response = $.parseJSON(response);
            $('#tbl_outlets').html(response);
        }

    });
}