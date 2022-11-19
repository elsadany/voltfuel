let marker1,marker2;
let map;
let issued_lati = $('#issued_lati').val();
let issuedlati  = parseFloat(issued_lati);
let issued_lang = $('#issued_lang').val()
let issuedlang  = parseFloat(issued_lang);
let returned_lati = $('#returned_lati').val()
let returnedlati = parseFloat(returned_lati);
let returned_lang = $('#returned_lang').val();
var returnedlang = parseFloat(returned_lang);
var issuedtitle = $('#issued_title').val();
var returntedtitle = $('#returned_title').val();
lati = parseFloat(23.614328);
lngi = parseFloat(58.545284);
console.log(lati+ "" +lngi);

function initMap() {     
    map = new google.maps.Map(document.getElementById("order_map"), {
        zoom: 15,
        center:  new google.maps.LatLng(lati, lngi),
    });

    if(issuedlati != '' && issuedlang !='' && returnedlati =='' && returnedlang =='')
    {
        const issuedlatLng = new google.maps.LatLng(issuedlati, issuedlang);
        marker1 = new google.maps.Marker({
        position: issuedlatLng,                
        icon: {
        scaledSize: new google.maps.Size(50, 50),
        url: "http://maps.google.com/mapfiles/ms/icons/yellow-dot.png",
        scale: 10,
        },
        map: map,
        title: issuedtitle,
        });
    }
    else
    {
        const issuedlatLng = new google.maps.LatLng(issuedlati, issuedlang);
        marker1 = new google.maps.Marker({
        position: issuedlatLng,                
        icon: {
        scaledSize: new google.maps.Size(50, 50),
        url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
        scale: 10,
        },
        map: map,
        title: issuedtitle,
        });

        const returntedlatLng = new google.maps.LatLng(returnedlati, returnedlang);
        marker2 = new google.maps.Marker({
        position: returntedlatLng,
        icon: {
        scaledSize: new google.maps.Size(50, 50),
        url: "http://maps.google.com/mapfiles/ms/icons/yellow-dot.png",
        scale: 10,
        },
        map: map,
        title: returntedtitle,
        });
    }
}


$(document).ready(function(e) {

    
    $('#orderstatus').change(function(){
        var orderstatus= $(this).val();
       console.log(orderstatus);
        var filter = orderstatus;
        console.log(filter);
        getorders(filter);
    });

    $('#orderstatus').val('all').trigger('change');

    $('#pagePrint').on('click',function()
    {
        console.log(1);
        var divContent = $('#printbody').html();
        var printwindow = window.open('','','height=400,width=800');
        printwindow.document.write(divContent);
        printwindow.document.close();
        printwindow.print();
        printwindow.onafterprint=function(){
            window.location.reload();
        }
    });

});

function getorders(orderstatus) {
    console.log("TEst");
    console.log(baseurl);
    $.ajax({
        url: baseurl + 'admin/orders/getorders',
        type: "POST",
        data: { "orderstatus": orderstatus },
        success: function(response) {
           console.log(response); // server response
            //var response = $.parseJSON(response);
            $('#tbl_orders').html(response);
        }

    });
}


function printOrder(orderid)
{
    console.log(orderid);
    $.ajax({
        url:baseurl+'admin/orders/print',
        type:"POST",
        data:{ "orderid" : orderid },
        success:function(response){
            console.log(response);
            var divContent = $('#printbody').html();
            var printwindow = window.open('','','height=400,width=800');
            printwindow.document.write(divContent);
            printwindow.document.close();
            printwindow.print();
            printwindow.onafterprint=function(){
                window.location.reload();
            }
        }
    })
}






