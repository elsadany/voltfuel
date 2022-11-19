<style>
/* Set the size of the div element that contains the map */
#map_db {
    /* position: absolute!important; */
    height: 600px;
    width:100%;
}
</style>

   <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">
        
            <!-- Page Header -->
            <div class="page-header">
                    <div class="row align-items-center">
					<div class="col">
						<h3 class="page-title"><?php echo $title;?></h3>
						<!-- <ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="">Outlets</a></li>
							<li class="breadcrumb-item active"><?php echo $title;?></li>
						</ul> -->
					</div>
					<!-- <div class="col-auto float-end ms-auto">
						<a href="<?php echo base_url(); ?>admin/outlets" class="btn add-btn"><i class="fa fa-arrow-left"></i> Outlets</a>
					</div> -->
				</div>
            </div>
            <!-- /Page Header -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-0">

                        <div class="card-body">
                            <h3 class="card-title">Stations Distribution</h3>
                            <div id="map_db"></div>
                        </div>
                            <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
                            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCvwJJct9nAQ90KFN3WmTQ1yLp5RG8JcUQ&callback=initMap&v=weekly" async></script>
                            <!--Google Maps-->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-0 mt-3 ml-2 mr-3">
                        <div class="card-body">
                        <h3 class="card-title">Stations Distribution</h3>
                            <div class="row">
                                <div class="col-md-6 ">
                                    <div class="card dash-widget">
                                        <div class="card-body">
                                            <span class="dash-widget-icon"><i class="fa fa-cubes"></i></span>
                                            <div class="dash-widget-info">
                                                <h3><?= $getactiveoutlets.'/'.$getnooutlets ?></h3>
                                                <span>Active Outlets</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card dash-widget">
                                        <div class="card-body">
                                            <span class="dash-widget-icon"><i class="fa fa-usd"></i></span>
                                            <div class="dash-widget-info">
                                                <h3><?= $getactivestations .'/' . $getnostations; ?></h3>
                                                <span>Active Stations</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card dash-widget">
                                        <div class="card-body">
                                            <span class="dash-widget-icon"><i class="fa fa-diamond"></i></span>
                                            <div class="dash-widget-info">
                                                <h3><?= $getonlinestations .'/' . $getnostations; ?></h3>
                                                <span>Online Stations</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card dash-widget">
                                        <div class="card-body">
                                            <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                                            <div class="dash-widget-info">
                                                <h3><?= $getavaliablebatteries.'/'.$getnobatteries; ?></h3>
                                                <span>Batteries</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-0 mt-3 ml-2 mr-3">
                        <div class="card-body">
                        <h3 class="card-title">Today's Activities</h3>
                            <div class="row">
                                <div class="col-md-6 ">
                                    <div class="card dash-widget">
                                        <div class="card-body">
                                            <span class="dash-widget-icon"><i class="fa fa-cubes"></i></span>
                                            <div class="dash-widget-info">
                                                <h3><?= $gettodaycollections ?></h3>
                                                <span>Today's Collections</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card dash-widget">
                                        <div class="card-body">
                                            <span class="dash-widget-icon"><i class="fa fa-usd"></i></span>
                                            <div class="dash-widget-info">
                                                <h3><?= $getactivestations .'/' . $getnostations; ?></h3>
                                                <span>In Rent Orders</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Total Revenue</h3>
                                    <div id="bar-charts"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Sales Overview</h3>
                                    <div id="line-charts"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
            <!-- Row -->  
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Issued and Returned Batteries</h3>
                                    <div id="bar-charts-battries"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">User Trends</h3>
                                    <div id="line-charts-usertrends"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>     
                        <!-- Row   -->
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">OS Platforms</h3>
                                    <div id="bar-charts-osplatforms"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Mobile Make</h3>
                                    <div id="line-charts-mobilemake"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                    
        </div>			
    </div>
    <!-- /Page Wrapper -->