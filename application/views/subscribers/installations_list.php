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
						<h3 class="page-title">Installations</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="">Subscribers</a></li>
							<li class="breadcrumb-item active">Installations</li>
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
            <div class="table-responsive" id="installations">
            <table class="table table-striped custom-table datatable">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Device ID</th>
                            <th>OS</th>
                            <th>Mobile Make</th>
                            <th>Mobile Model</th>
                            <th>isActive</th>
                            <th>Location</th>
                            <th>Date of Installation</th>
                            <th>Last Seen Date</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($installationslist) {
                            $i=1;
                            foreach($installationslist as $install){?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $install['device_id'];?></td>
                                <td><?php echo $install['os_platform'].' '.$install['os_version'];?></td>
                                <td><?php echo $install['mobile_make'];?></td>
                                <td><?php echo $install['mobile_model'];?></td>
                                <td><?php echo $install['is_active'];?></td>
                                <td><?php echo $install['device_lat'].', '.$install['device_long'];?></td>
                                <td><?php echo $install['ipaddress'];?></td>
                                <td><?php echo $install['created_on'];?></td>
                                <td><?php echo $install['lastseen_at'];?></td>
                                <td><?php ?></td>

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