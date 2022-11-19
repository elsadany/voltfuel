<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="VoltaFuel - Charging Made Easy">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="VoltaFuel - Charging Made Easy">
        <meta name="robots" content="noindex, nofollow">
        <title>Login -<?php echo $name; ?></title>
		<link href="<?php echo base_url(); ?>uploads/business_content/admin_small_logo/<?php $this->setting_model->getAdminsmalllogo(); ?>" rel="shortcut icon" type="image/x-icon">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500">

        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/themes/t2_light/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/themes/t2_light/css/font-awesome.min.css">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/themes/t2_light/css/style.css">
		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="<?php echo base_url(); ?>backend/themes/t2_light/js/html5shiv.min.js"></script>
			<script src="<?php echo base_url(); ?>backend/themes/t2_light/js/respond.min.js"></script>
		<![endif]-->


        <style type="text/css">
            /*.col-md-offset-3 { margin-left: 29%;}*/
            .bgoffsetbgno{background: transparent; border-right:0 !important; box-shadow: 0px 0px 12px rgba(0, 0, 0, 0.29); border-radius: 4px;}
            .loginradius{border-radius: 4px;} 
            /* @media (max-width: 767px){.col-md-offset-3 {margin-left: 0;}}*/
            .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar {
                background: rgb(53, 170, 71);} 

        </style>
    </head>
    <body class="account-page">
	
		<!-- Main Wrapper -->
        <div class="main-wrapper">
			<div class="account-content">
				
				<div class="container">
				
					<!-- Account Logo -->
					<div class="account-logo">
						<a href=""><img src="<?php echo base_url(); ?>uploads/business_content/admin_small_logo/<?php $this->setting_model->getAdminlogo(); ?>" alt="VoltaFuel"></a>
					</div>
					<!-- /Account Logo -->
					
					<div class="account-box">
						<div class="account-wrapper">

							<h3 class="account-title"><?php echo $this->lang->line('admin_login'); ?></h3>
							<p class="account-subtitle">Access to Voltafuel dashboard</p>
                            <?php
                            if (isset($error_message)) {
                                echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                            }
                            ?>
                            <?php
                            if ($this->session->flashdata('message')) {
                                echo "<div class='alert alert-success'>" . $this->session->flashdata('message') . "</div>";
                            };
                            ?>
                            <?php
                            if ($this->session->flashdata('disable_message')) {
                                echo "<div class='alert alert-danger'>" . $this->session->flashdata('disable_message') . "</div>";
                            };
                            ?>
                                      
							<!-- Account Form -->
							<form action="<?php echo site_url('site/login') ?>" method="post">
                            <?php echo $this->customlib->getCSRF(); ?>
								<div class="form-group has-feedback">
                                    <input type="text" name="username" placeholder="<?php echo $this->lang->line('username'); ?>" value="<?php echo set_value('username') ?>" class="form-username form-control" id="form-username">
                                    <!-- <span class="fa fa-envelope form-control-feedback"></span> -->
                                    <span class="text-danger"><?php echo form_error('username'); ?></span>
								</div>
								<div class="form-group has-feedback">
									<div class="row">
										<div class="col">
											<label>Password</label>
                                            
										</div>
										<div class="col-auto">
                                        <a href="<?php echo site_url('site/forgotpassword') ?>" class="forgot text-muted"><i class="fa fa-key"></i> <?php echo $this->lang->line('forgot_password'); ?>?</a>
										</div>
									</div>
                                                                              
                                    <input type="password" value="<?php echo set_value('password') ?>" name="password" placeholder="<?php echo $this->lang->line('password'); ?>" class="form-password form-control" id="form-password">
                                    <!-- <span class="fa fa-lock form-control-feedback"></span> -->
                                    <span class="text-danger"><?php echo form_error('password'); ?></span>
                                           
								</div>
								<div class="form-group text-center">
									<button class="btn btn-primary account-btn" type="submit"><?php echo $this->lang->line('sign_in'); ?></button>
								</div>
                                <?php if($is_captcha){ ?>
                                    <div class="form-group has-feedback row"> 
                                        <div class='col-lg-7 col-md-12 col-sm-6'>
                                            <span id="captcha_image"><?php echo $captcha_image; ?></span>
                                            <span title='Refresh Catpcha' class="fa fa-refresh catpcha" onclick="refreshCaptcha()"></span>
                                        </div>
                                        <div class='col-lg-5 col-md-12 col-sm-6'>
                                            <input type="text" name="captcha" placeholder="<?php echo $this->lang->line('captcha'); ?>" class=" form-control" autocomplete="off" id="captcha"> 
                                            <span class="text-danger"><?php echo form_error('captcha'); ?></span>
                                        </div>
                                    </div>
                                <?php } ?>
								<div class="account-footer">
									 <p>Design & Deveolped by <a href="https://www.ashr.in">ASHR DATATECH Pvt Ltd</a></p>
								</div>
							</form>
							<!-- /Account Form -->
							
						</div>
					</div>
				</div>
			</div>
        </div>
		<!-- /Main Wrapper -->
		
		<!-- jQuery -->
        <script src="<?php echo base_url(); ?>backend/themes/t2_light/js/jquery-3.6.0.min.js"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="<?php echo base_url(); ?>backend/themes/t2_light/js/bootstrap.bundle.min.js"></script>
		
		<!-- Custom JS -->
		<script src="<?php echo base_url(); ?>backend/themes/t2_light/js/app.js"></script>

        <script src="<?php echo base_url(); ?>backend/usertemplate/<?php echo base_url(); ?>backend/themes/t2_light/js/jquery.backstretch.min.js"></script>
        <script src="<?php echo base_url(); ?>backend/usertemplate/<?php echo base_url(); ?>backend/themes/t2_light/js/jquery.mCustomScrollbar.min.js"></script>
        <script src="<?php echo base_url(); ?>backend/usertemplate/<?php echo base_url(); ?>backend/themes/t2_light/js/jquery.mousewheel.min.js"></script>

    </body>
</html>
<script type="text/javascript">
    $(document).ready(function () {
        $('.login-form input[type="text"], .login-form input[type="password"], .login-form textarea').on('focus', function () {
            $(this).removeClass('input-error');
        });
        $('.login-form').on('submit', function (e) {
            $(this).find('input[type="text"], input[type="password"], textarea').each(function () {
                if ($(this).val() == "") {
                    e.preventDefault();
                    $(this).addClass('input-error');
                } else {
                    $(this).removeClass('input-error');
                }
            });
        });
    });
</script>
<script type="text/javascript">
    function refreshCaptcha(){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('site/refreshCaptcha'); ?>",
            data: {},
            success: function(captcha){
                $("#captcha_image").html(captcha);
            }
        });
    }    
</script>