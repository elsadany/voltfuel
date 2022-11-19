    <!-- <?php
        echo "<pre>"; print_r($listoutlets); echo "</pre>";
    ?> -->
	<div id='msg'>
    </div>
    <div class="row">
        <div class="col-md-12">
			<div class="table-responsive" id="tbl_outlets">
			</div>
        </div>
    </div>
    <!--div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table datatable">
                    <thead>
                        <tr>
                            <th>Outlet Name</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Operation Mode</th>
                            <th>Support</th>
                            <th>Images</th>
                            <th>Status</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($listoutlets))
                            {
                                foreach($listoutlets as $item)
                                {

                        ?>
                            <tr>
                                <td>
                                    <a href=""><?= $item['outlet_name'] ?></a>
                                </td>
                                <td><?= $item['address'] ?></td>
                                <td><?= $item['city'] ?></td>
                                <td>
                                    <?= $item['operation_mode']."<br>". $item['operation_time'] ?>
                                     <ul class="team-members text-nowrap">
                                        <li>
                                            <a href="#" title="John Doe" data-bs-toggle="tooltip"><img alt="" src="assets/img/profiles/avatar-02.jpg"></a>
                                        </li>
                                        <li>
                                            <a href="#" title="Richard Miles" data-bs-toggle="tooltip"><img alt="" src="assets/img/profiles/avatar-09.jpg"></a>
                                        </li>
                                        <li>
                                            <a href="#" title="John Smith" data-bs-toggle="tooltip"><img alt="" src="assets/img/profiles/avatar-10.jpg"></a>
                                        </li>
                                        <li>
                                            <a href="#" title="Mike Litorus" data-bs-toggle="tooltip"><img alt="" src="assets/img/profiles/avatar-05.jpg"></a>
                                        </li>
                                        <li class="dropdown avatar-dropdown">
                                            <a href="#" class="all-users dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">+15</a>
                                        </li>
                                    </ul>
                                </td>
                                <td><?= $item['support'] ?></td>
                                <td>
                                    <ul class="team-members text-nowrap">
                                        <li>
                                            <a href="#" title="John Doe" data-bs-toggle="tooltip"><img alt="" src="<?php echo base_url();?>/uploads/outlets/images/<?= $item['id'] ?>/<?= $item['image1'] ?>"></a>
                                        </li>
                                        <li>
                                            <a href="#" title="Richard Miles" data-bs-toggle="tooltip"><img alt="" src="<?php echo base_url();?>/uploads/outlets/images/<?= $item['id'] ?>/<?= $item['image2'] ?>"></a>
                                        </li>
                                        <li>
                                            <a href="#" title="John Smith" data-bs-toggle="tooltip"><img alt="" src="<?php echo base_url();?>/uploads/outlets/images/<?= $item['id'] ?>/<?= $item['image3'] ?>"></a>
                                        </li>
                                        <li>
                                            <a href="#" title="Mike Litorus" data-bs-toggle="tooltip"><img alt="" src="<?php echo base_url();?>/uploads/outlets/images/<?= $item['id'] ?>/<?= $item['image4'] ?>"></a>
                                        </li>
                                        <li class="dropdown avatar-dropdown">
                                            <a href="#" class="all-users dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">+15</a>
                                        </li>
                                    </ul>                           
                                </td>
                                <td>
                                    <div class="dropdown action-label">
                                        <a href="" class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-danger"></i> High </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-danger"></i> High</a>
                                            <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-warning"></i> Medium</a>
                                            <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-success"></i> Low</a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown action-label" id="outletsactive<?= $item['id'] ?>">
                                        <?php if ($item['is_active'] == 'yes'){;?>
                                            <a href="" class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-success"></i> Active </a>
                                        <?php }else{?>
                                            <a href="" class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-danger"></i> Inactive </a>
                                        <?php }?>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" onclick=makeoutletactive(<?= $item['id'] ?>)><i class="fa fa-dot-circle-o text-success"></i> Active</a>
                                            <a class="dropdown-item" onclick=makeoutletinactive(<?= $item['id'] ?>)><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>
                                        </div>
                                    </div>
                                </td>

                                <td class="text-end">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="<?php echo base_url();?>admin/outlets/edit/<?php echo $this->enc_lib->encrypt($item['id']);?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a class="dropdown-item" href="<?php echo base_url();?>admin/outlets/delete/<?php echo $this->enc_lib->encrypt($item['id']);?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
								        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div-->
<!-- /Page Content -->
<script>
function makeoutletactive(id) {
    //Ajax Load data from ajax
    console.log(id);
    url = 'admin/outlets/makeoutletactive/';
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
                $('#outletsactive' + id).empty();
                var html = '<a href="" class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-success"></i> Active </a>';
                html += '<div class="dropdown-menu">';
                html += '<a class="dropdown-item" onclick=makeoutletactive('+id+')><i class="fa fa-dot-circle-o text-success"></i> Active</a>';
                html += '<a class="dropdown-item" onclick=makeoutletinactive('+id+')><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>';
                html += '</div>';

                console.log(html);
                $('#outletsactive' + id).html(html);
                
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

function makeoutletinactive(id) {
    //Ajax Load data from ajax
    url = 'admin/outlets/makeoutletinactive/';
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
                $('#outletsactive' + id).empty();
                var html = '<a href="" class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-danger"></i> Inactive </a>';
                html += '<div class="dropdown-menu">';
                html += '<a class="dropdown-item" onclick=makeoutletactive('+id+')><i class="fa fa-dot-circle-o text-success"></i> Active</a>';
                html += '<a class="dropdown-item" onclick=makeoutletinactive('+id+')><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>';
                html += '</div>';

                console.log(html);
                $('#outletsactive' + id).html(html);
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
