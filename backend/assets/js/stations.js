$(document).ready(function(e) {

    var device_id = $('#deviceid').val();
    console.log(device_id);
    checkbatteries1(device_id);

    var station_id = $('#id').val();
    console.log(station_id);
    var oldimgfile = $('#oldfile').val();
    console.log(oldimgfile);

    $('#stationstatus').change(function() {
        var stationstatus = $(this).val();
        console.log(stationstatus);
        var filter = stationstatus;
        getstations(filter);
    });

    $('#stationstatus').val('all').trigger('change');


    $("#upfile").on('change', function() {
        readURL(this);
        uploadstationimage(station_id, this.files, oldimgfile);
    });

    $("#upload-button").on('click', function() {
        $(".upload").click();
    });

    var readURL = function(input) {
        //console.log(input.files[0].name);
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#loadstationimage').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }


});

function getstations(stationstatus) {
    console.log("TEst");
    console.log(baseurl);
    $.ajax({
        url: baseurl + 'admin/stations/getstations',
        type: "POST",
        data: { "stationstatus": stationstatus },
        success: function(response) {
            console.log(response); // server response
            //var response = $.parseJSON(response);
            $('#tbl_stations').html(response);
            $('#selectstatus').hide();
        }

    });

}

function uploadstationimage(station_id, img, oldimg) {
    data = new FormData();
    data.append('file', $('#upfile')[0].files[0]);
    data.append('id', station_id);
    data.append('oldimg', oldimg);
    var url = 'admin/stations/checkuploadimage'
    $.ajax({
        url: getBaseURL() + url,
        type: "POST",
        data: data,
        enctype: 'multipart/form-data',
        processData: false, // tell jQuery not to process the data
        contentType: false, // tell jQuery not to set contentType
        success: function(response) {
            console.log(response);
            // if (data.success) //if success close modal and reload ajax table
            // {
            //     alert('success', 'Status Changed Successfully');
            // } else {
            //     alert('danger', data.error_string);
            // }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
            alert('danger', 'Error get data from ajax');
        }
    });
}


function checkbatteries1(device_id) {
    $('#batteries-status').html('');
    $.ajax({
        url: baseurl + 'admin/stations/checkbatteries/' + device_id,
        type: "POST",
        data: { "device_id": device_id },
        success: function(response) {
            //console.log(response);
            //console.log( response ); // server response
            //var response = $.parseJSON(response);
            $('#batteries-status').html(response);
        }

    });
}

function eject(order_id) {
    var device_id = $('#deviceid').val();
    var url = getBaseURL + 'admin/stations/ejectbattery/' + device_id + '/' + order_id;
    console.log(url);
    $.ajax({
        url: url,
        data: { "device_id": device_id, "order_id": order_id },
        success: function(response) {
            //console.log( response ); // server response
            //var response = $.parseJSON(response);
            $('#batteries-status').html('');
            checkbatteries1(device_id);
            //alert(response);
        }

    });

}