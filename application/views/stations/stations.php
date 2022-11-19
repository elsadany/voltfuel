    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive" id="tbl_stations">
            </div>
        </div>
    </div>

    <!--div class="row" id="selectstatus" style="display:block">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table datatable">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Station Name</th>
                            <th>Outlet Name</th>
                            <th>Station ID</th>
                            <th>QR Code</th>
                            <th>No of Batteries</th>
                            <th>Manufacturer</th>
                            <th>Purchase Date</th>
                            <th>is Online</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php 
                        $i=0;
                        foreach($liststations as $station){
                            $i++;
                        ?>
                            <tr>
                            <td><?php echo $i;?>
                            <td>
                                <h2 clas="table-avatar">
                                    <a href="" class="avatar">
                                    <?php
                                        if($station['station_image']!=null)
                                        {
                                    ?>
                                            <img alt=""  class="inline-block" src="<?php echo base_url(); ?>uploads/stations/images/<?= $station["id"] ?>/<?= $station["station_image"]?>" />
                                    <?php
                                        }
                                    ?>
                                    </a>
                                    <a href="<?php echo base_url();?>admin/stations/view/<?php echo $station['station_id'];?>"><?php echo $station['station_name'];?> </a>
                                </h2>
                                <a href="<?php echo base_url();?>admin/stations/view/<?php echo $station['station_id'];?>"><?php echo $station['outlet_name'];?> </a> 
                            </td>
                            <td><?php echo $station['outlet_name'];?></td>
                            <td><?php echo substr($station['qr_code'],35,13);?></td>
                            
                            <td><?php echo $station['qr_code'];?></td> 
                            <td><?php echo $station['avl_batteries'].'/'.$station['batteries'];?></td>
                            <td><?php echo $station['manufacturer'];?></td>
                            <td><?php echo $station['purchasedate'];?></td>
                            <td><?php if ($station['is_online']=='yes'){
                                    echo '<a class="btn btn-white btn-sm btn-rounded"> <i class="fa fa-dot-circle-o text-success"></i> Online</a>';
                                 }else{
                                    echo '<a class="btn btn-white btn-sm btn-rounded"><i class="fa fa-dot-circle-o text-danger"></i> Offline</a>';
                                }
                            ?></td>
                            <td>
                                <div class="dropdown action-label" id="stationactive<?= $station['id'] ?>">
                                <?php if ($station['is_active'] == 'yes'){;?>
                                    <a href="" class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-success"></i> Active </a>
                                <?php }else{?>
                                    <a href="" class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-danger"></i> Inactive </a>
                                <?php }?>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"  onclick=makestationactive(<?= $station['id'] ?>)><i class="fa fa-dot-circle-o text-success"></i> Active</a>
                                        <a class="dropdown-item" onclick=makestationinactive(<?= $station['id'] ?>)><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="<?php echo base_url();?>admin/stations/edit/<?php echo $this->enc_lib->encrypt($station['id']);?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
									    <a class="dropdown-item" href="<?php echo base_url();?>admin/stations/delete/<?php echo $this->enc_lib->encrypt($station['id']);?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div-->
    <!-- Page Content -->
<script>

function makestationactive(id) {
    //Ajax Load data from ajax
    url = 'admin/stations/makestationactive/';
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
                $('#stationactive' + id).empty();
                var html = '<a href="" class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-success"></i> Active </a>';
                html += '<div class="dropdown-menu">';
                html += '<a class="dropdown-item" onclick=makestationactive('+id+')><i class="fa fa-dot-circle-o text-success"></i> Active</a>';
                html += '<a class="dropdown-item" onclick=makestationinactive('+id+')><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>';
                html += '</div>';

                console.log(html);
                $('#stationactive' + id).html(html);
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

function makestationinactive(id) {
    //Ajax Load data from ajax
    url = 'admin/stations/makestationinactive/';
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
                $('#stationactive' + id).empty();
                var html = ' <a href="" class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-danger"></i> Inactive </a>';
                html += '<div class="dropdown-menu">';
                html += '<a class="dropdown-item" onclick=makestationactive('+id+')><i class="fa fa-dot-circle-o text-success"></i> Active</a>';
                html += '<a class="dropdown-item" onclick=makestationinactive('+id+')><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>';
                html += '</div>';

                console.log(html);
                $('#stationactive' + id).html(html);
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


