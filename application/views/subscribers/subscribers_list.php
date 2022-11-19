<?php
$currency_symbol = $this->customlib->getCurrencyFormat();
?>

    <!-- Page Wrapper -->
	<div class="page-wrapper">
	
		<!-- Page Content -->
		<div class="content container-fluid">
		
			<!-- Page Header -->
			<div class="page-header">
				<div class="row align-items-center">
					<div class="col">
						<h3 class="page-title">Manage Subscribers</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="">Subscribers</a></li>
							<li class="breadcrumb-item active">Subscribers List</li>
						</ul>
					</div>
				</div>
                <?php if ($this->session->flashdata('msg')) { ?>
                                <?php echo $this->session->flashdata('msg') ?>
                <?php } ?>
			</div>
			<!-- /Page Header -->
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive" id="subscribers">
            <table class="table table-striped custom-table datatable">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Active Rents</th>
                            <th>Total Rents</th>
                            <th>Rents Paid</th>
                            <th>is Active</th>
                            <!-- <th>Last Seen Date</th> -->
                            <!-- <th class="text-end">Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($subscriberslist) {
                            $i=1;
                            foreach($subscriberslist as $subscriber){?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td>
                                <h2 class="table-avatar">
                                    <a href="" class="avatar"><?php if($subscriber['imagefile']!=null){echo '<img alt="" src="data:image/jpg;base64,'.$subscriber['imagefile'].'"/>';}?></a>
                                    <a href=""><?php echo $subscriber['firstname'];?> <span><?php echo $subscriber['mobileno'];?></span></a>
                                </h2>
                                </td>
                                <td><?php echo $subscriber['email'];?></td>
                                <td><?php echo $subscriber['active_rent'] ?></td>
                                <td><?php echo $subscriber['total_rent'] ?></td>
                                <td><?php echo $subscriber['total_amount'] ?></td>
                                <td>
                                    <div class="dropdown action-label" id="subscribersactive<?= $subscriber['id'] ?>">
                                        <?php if ($subscriber['is_active'] == 'yes'){;?>
                                            <a href="" class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-success"></i> Active </a>
                                        <?php }else{?>
                                            <a href="" class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-danger"></i> Inactive </a>
                                        <?php }?>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" onclick=makesubscriberactive(<?= $subscriber['id'] ?>)><i class="fa fa-dot-circle-o text-success"></i> Active</a>
                                            <a class="dropdown-item" onclick=makesubscriberinactive(<?= $subscriber['id'] ?>)><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>
                                        </div>
                                    </div>                                  
                                </td>
                                <!-- <td></td>
                                <td></td> -->

                            </tr>
                        <?php 
                            $i++;
                            }
                        }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
function makesubscriberactive(id) {
    //Ajax Load data from ajax
    console.log(id);
    url = 'subscribers/makesubscriberactive/';
    $.ajax({
        url: getBaseURL() + url,
        type: "POST",
        data: {
            'csrf_test_name': getCookie('csrf_cookie_name'),
            'id':id
        },
        dataType: "JSON",
        success: function(data) {
            console.log(data);
            if (data.success) //if success close modal and reload ajax table
            {
                alert('success', 'Status Changed Successfully');
                $('#subscribersactive' + id).empty();
                var html = '<a href="" class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-success"></i> Active </a>';
                html += '<div class="dropdown-menu">';
                html += '<a class="dropdown-item" onclick=makesubscriberactive('+id+')><i class="fa fa-dot-circle-o text-success"></i> Active</a>';
                html += '<a class="dropdown-item" onclick=makesubscriberinactive('+id+')><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>';
                html += '</div>';

                console.log(html);
                $('#subscribersactive' + id).html(html);
                
            } else {
                alert('danger', data.error_string);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
            alert('danger', 'Error get data from ajax');
        }
    });
}

function makesubscriberinactive(id) {
    //Ajax Load data from ajax
    url = 'subscribers/makesubscriberinactive/';
    $.ajax({
        url: getBaseURL() + url,
        type: "POST",
        data: {
            'csrf_test_name': getCookie('csrf_cookie_name'),
            'id':id
        },
        dataType: "JSON",
        success: function(data) {
            console.log(data);
            if (data.success) //if success close modal and reload ajax table
            {
                alert('success', 'Status Changed Successfully');
                $('#subscribersactive' + id).empty();
                var html = '<a href="" class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-danger"></i> Inactive </a>';
                html += '<div class="dropdown-menu">';
                html += '<a class="dropdown-item" onclick=makesubscriberactive('+id+')><i class="fa fa-dot-circle-o text-success"></i> Active</a>';
                html += '<a class="dropdown-item" onclick=makesubscriberinactive('+id+')><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>';
                html += '</div>';

                console.log(html);
                $('#subscribersactive' + id).html(html);
            } else {
                alert('danger', data.error_string);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
            alert('danger', 'Error get data from ajax');
        }
    });
}

</script>