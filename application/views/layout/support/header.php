<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>

		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="Voltafuel - Support" name="description">
		<meta content="ASHR DATATECH Private Limited" name="author">
		<meta name="keywords" content="admin dashboard, admin panel template, html admin template, dashboard html template, bootstrap 4 dashboard, template admin bootstrap 4, simple admin panel template, simple dashboard html template,  bootstrap admin panel, task dashboard, job dashboard, bootstrap admin panel, dashboards html, panel in html, bootstrap 4 dashboard, bootstrap 5 dashboard, bootstrap5 dashboard"/>

        <title><?php echo $this->customlib->getAppName(); ?></title>
		<link href="<?php echo base_url(); ?>uploads/business_content/admin_small_logo/<?php $this->setting_model->getAdminsmalllogo(); ?>" rel="shortcut icon" type="image/x-icon">

		<!-- Bootstrap css -->
		<link href="<?php echo base_url();?>backend/support/assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" />

		<!-- Style css -->
		<link href="<?php echo base_url();?>backend/support/assets/css/style.css" rel="stylesheet" />
		<link href="<?php echo base_url();?>backend/support/assets/css/boxed.css" rel="stylesheet" />
		<link href="<?php echo base_url();?>backend/support/assets/css/dark.css" rel="stylesheet" />
		<link href="<?php echo base_url();?>backend/support/assets/css/skin-modes.css" rel="stylesheet" />

		<!-- Animate css -->
		<link href="<?php echo base_url();?>backend/support/assets/css/animated.css" rel="stylesheet" />

		<!-- P-scroll bar css-->
		<link href="<?php echo base_url();?>backend/support/assets/plugins/p-scrollbar/p-scrollbar.css" rel="stylesheet" />

		<!---Icons css-->
		<link href="<?php echo base_url();?>backend/support/assets/css/icons.css" rel="stylesheet" />

		<!-- Select2 css -->
		<link href="<?php echo base_url();?>backend/support/assets/plugins/select2/select2.min.css" rel="stylesheet" />

		<!-- INTERNAL owl-carousel css-->
		<link href="<?php echo base_url();?>backend/support/assets/plugins/owl-carousel/owl-carousel.css" rel="stylesheet" />

		<!-- INTERNAL jquery.autocomplete css-->
		<link href="<?php echo base_url();?>backend/support/assets/plugins/jquery.autocomplete/jquery.autocomplete.css" rel="stylesheet" />

		<!-- INTERNAL Ratings css -->
		<link rel="stylesheet" href="<?php echo base_url();?>backend/support/assets/plugins/rating/css/ratings.css">
		<link rel="stylesheet" href="<?php echo base_url();?>backend/support/assets/plugins/rating/css/rating-themes.css">

	</head>

	<body class="">

		<!---Global-loader-->
		<div id="global-loader" >
			<img src="<?php echo base_url();?>backend/support/assets/images/svgs/loader.svg" alt="loader">
		</div>



		<!-- Mobile Header -->
				<div class="support-mobile-header clearfix">
					<div class="container">
						<div class="d-flex">
							<a class="animated-arrow horizontal-navtoggle"><span></span></a>
							<span class="smallogo">
								<a class="header-brand" href="index.html">
                                    <img src="<?php echo base_url(); ?>uploads/business_content/admin_small_logo/<?php $this->setting_model->getAdminlogo(); ?>" class="header-brand-img desktop-lgo" alt="VoltaFuel" width=50>
									<img src="<?php echo base_url();?>uploads/business_content/admin_small_logo/<?php $this->setting_model->getAdminlogo(); ?>" class="header-brand-img light-logo" alt="VoltaFuel" width=50>
									<img src="<?php echo base_url();?>uploads/business_content/admin_small_logo/<?php $this->setting_model->getAdminlogo(); ?>" class="header-brand-img mobile-logo" alt="VoltaFuel" width=50>
									<img src="<?php echo base_url();?>uploads/business_content/admin_small_logo/<?php $this->setting_model->getAdminlogo(); ?>" class="header-brand-img darkmobile-logo" alt="VoltaFuel" width=50>
								</a>
							</span>
							<div class="dropdown profile-dropdown ms-auto">
								<a href="#" class="nav-link pe-1 ps-0 leading-none" data-bs-toggle="dropdown">
									<span>
										<img src="<?php echo base_url();?>backend/support/assets/images/users/16.jpg" alt="img" class="avatar avatar-md bradius">
									</span>
								</a>
								<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
									<div class="p-3 text-center border-bottom">
										<a href="profile-1.html" class="text-center user pb-0 font-weight-bold">John Thomson</a>
										<p class="text-center user-semi-title">App Developer</p>
									</div>
									<a class="dropdown-item d-flex" href="profile-1.html">
										<i class="feather feather-user me-3 fs-16 my-auto"></i>
										<div class="mt-1">Profile</div>
									</a>
									<a class="dropdown-item d-flex" href="support-adminticketlist.html">
										<i class="ri-ticket-2-line me-3 fs-16 my-auto"></i>
										<div class="mt-1">Tickets</div>
									</a>
									<a class="dropdown-item d-flex" href="chat.html">
										<i class="feather feather-mail me-3 fs-16 my-auto"></i>
										<div class="mt-1">Messages</div>
									</a>
									<a class="dropdown-item d-flex" href="support-admineditprofile.html">
										<i class="feather feather-settings me-3 fs-16 my-auto"></i>
										<div class="mt-1">Settings</div>
									</a>
									<a class="dropdown-item d-flex" href="#" data-bs-toggle="modal" data-bs-target="#changepasswordnmodal">
										<i class="feather feather-edit-2 me-3 fs-16 my-auto"></i>
										<div class="mt-1">Change Password</div>
									</a>
									<a class="dropdown-item d-flex" href="login-1.html">
										<i class="feather feather-power me-3 fs-16 my-auto"></i>
										<div class="mt-1">Log Out</div>
									</a>
								</div>
							</div>
							<li>
						</div>
					</div>
				</div>
				<!-- /Mobile Header -->

				<!-- Header-->
				<div class="landingmain-header header">
					<div class="horizontal-main landing-header clearfix">
						<div class="horizontal-mainwrapper container clearfix">
							<div class="d-flex">
								<div class="headerlanding-logo">
									<a class="header-brand" href="index.html">
                                    <img src="<?php echo base_url(); ?>uploads/business_content/admin_small_logo/<?php $this->setting_model->getAdminlogo(); ?>" class="header-brand-img desktop-lgo" alt="VoltaFuel" width=50;>
									<img src="<?php echo base_url();?>uploads/business_content/admin_small_logo/<?php $this->setting_model->getAdminlogo(); ?>" class="header-brand-img light-logo" alt="VoltaFuel" width=50>
									<img src="<?php echo base_url();?>uploads/business_content/admin_small_logo/<?php $this->setting_model->getAdminsmalllogo(); ?>" class="header-brand-img mobile-logo" alt="VoltaFuel" width=50>
									<img src="<?php echo base_url();?>uploads/business_content/admin_small_logo/<?php $this->setting_model->getAdminsmalllogo(); ?>" class="header-brand-img darkmobile-logo" alt="VoltaFuel" width=50>
									</a>
								</div>
								<nav class="horizontalMenu clearfix order-lg-2 my-auto ms-auto">
									<ul class="horizontalMenu-list">
										<li>
											<a href="support-landing.html">Home</a>
										</li>
										<li>
											<a href="#" class="sub-icon">Knowledge <span class="fe fe-chevron-down m-0"></span></a>
											<ul class="sub-menu">
												<li><a href="support-knowledge.html">Knowledge</a></li>
												<li><a href="support-knowledgeview.html">KnowledgeView</a></li>
											</ul>
										</li>
										<li>
											<a href="<?php echo base_url();?>support/openticket">Open Ticket</a>
										</li>
										<!-- <li>
											<a href="support-contact.html">Contact Us</a>
										</li> -->
										<!-- <li>
											<a href="#" class="sub-icon">Pages<span class="fe fe-chevron-down m-0"></span></a>
											<div class="horizontal-megamenu clearfix">
												<div class="container">
													<div class="mega-menubg">
														<div class="row">
															<div class="col-lg-2 col-md-12 col-xs-12 link-list">
																<ul class="sub-menu">
																	<li><h3 class="mega-subtitle">User Pages</h3></li>
																	<li><a href="support-userdash.html">Dashboard</a></li>
																	<li><a href="support-editprofile.html">Edit Profile</a></li>
																	<li><a href="support-ticketlist.html">Ticket Lists</a></li>
																	<li><a href="support-ticketactive.html">Active Tickets</a></li>
																	<li><a href="support-ticketclosed.html">Closed Tickets</a></li>
																	<li><a href="support-ticketview.html">View Ticket</a></li>
																	<li><a href="support-ticketcreate.html">Create Ticket</a></li>
																</ul>
															</div>
															<div class="col-lg-2 col-md-12 col-xs-12 link-list">
																<ul class="sub-menu">
																	<li><h3 class="mega-subtitle">Admin Pages</h3></li>
																	<li><a href="support-admindash.html">Dashboard</a></li>
																	<li><a href="support-admineditprofile.html">Edit Profile</a></li>
																	<li><a href="support-adminticketlist.html">Ticket Lists</a></li>
																	<li><a href="support-adminticketactive.html">Active Tickets</a></li>
																	<li><a href="support-adminticketclosed.html">Closed Tickets</a></li>
																	<li><a href="support-adminticketview.html">View Ticket</a></li>
																	<li><a href="support-adminticketnew.html">New Ticket</a></li>
																</ul>
															</div>
															<div class="col-lg-2 col-md-12 col-xs-12 link-list">
																<ul class="sub-menu mt-lg-7">
																	<li><a href="support-admincustomer.html">Customers</a></li>
																	<li><a href="support-admincustomerview.html">CustomersView</a></li>
																	<li><a href="support-admincategories.html">Categories</a></li>
																	<li><a href="support-adminarticles.html">Articles</a></li>
																</ul>
															</div>
															<div class="col-lg-2 col-md-12 col-xs-12 link-list">
																<ul class="sub-menu">
																	<li><h3 class="mega-subtitle">Agent Pages</h3></li>
																	<li><a href="support-agentdash.html">Dashboard</a></li>
																	<li><a href="support-agenteditprofile.html">Edit Profile</a></li>
																	<li><a href="support-agentticketlist.html">Ticket List</a></li>
																	<li><a href="support-agentticketactive.html">Active Tickets</a></li>
																	<li><a href="support-agentticketclosed.html">Closed Tickets</a></li>
																	<li><a href="support-agentticketview.html">View Ticket</a></li>
																	<li><a href="support-agentassign.html">Assigned Categories</a></li>
																</ul>
															</div>
															<div class="col-lg-2 col-md-12 col-xs-12 link-list">
																<ul class="sub-menu">
																	<li><h3 class="mega-subtitle">Other Pages</h3></li>
																	<li><a href="#" data-bs-toggle="modal" data-bs-target="#loginmodal">Login</a></li>
																	<li><a href="#" data-bs-toggle="modal" data-bs-target="#registermodal">Register</a></li>
																</ul>
															</div>
														</div>
													</div>
												</div>
											</div>
										</li> -->
										<li>
											<a href="#" class="sub-icon">My Dashboard <span class="fe fe-chevron-down m-0"></span></a>
											<ul class="sub-menu">
												<li><a href="support-landing.html">My Dashboard</a></li>
												<li><a href="support-admineditprofile.html">Edit Profile</a></li>
												<li><a href="support-adminticketlist.html">My Tickets</a></li>
												<li><a href="login-1.html">Logout</a></li>
											</ul>
										</li>
										<li>
											<span class="menu-btn">
												<a class="btn btn-success" href="#"><i class="fa fa-paper-plane-o "></i> Submit Request</a>
											</span>
										</li>
									</ul>
								</nav>
							</div>
						</div>
					</div>
				</div>
		<!--Header-->