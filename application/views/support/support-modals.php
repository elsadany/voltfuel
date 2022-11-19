

<!--Login Modal-->
<div class="modal fade"  id="loginmodal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Login</h5>
                <button  class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="single-page customerpage">
                    <div class="wrapper wrapper2 box-shadow-0 border-0">
                        <div class="card-body pb-4">
                            <div class="btn-list d-flex">
                                <a class="btn btn-google btn-block" href="https://www.google.com/gmail/"><i class="fa fa-google fa-1x me-2"></i> Google</a>
                                    <a class="btn btn-twitter" href="https://twitter.com/"><i class="fa fa-twitter fa-1x"></i></a>
                                    <a class="btn btn-facebook" href="https://www.facebook.com/"><i class="fa fa-facebook fa-1x"></i></a>
                            </div>
                        </div>
                        <hr class="divider">
                        <form class="card-body pt-3" id="login" name="login">
                            <div class="form-group">
                                <label class="form-label">Mail or Username</label>
                                <input class="form-control" placeholder="Email" type="email">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Password</label>
                                <input class="form-control" placeholder="password" type="password">
                            </div>
                            <div class="submit">
                                <a class="btn btn-primary btn-block" href="index.html">Login</a>
                            </div>
                            <div class="text-center mt-3">
                                <p class="mb-2"><a href="#">Forgot Password</a></p>
                                <p class="text-dark mb-0">Don't have account?<a class="text-primary ms-1" href="#" data-bs-toggle="modal" data-bs-target="#registermodal" data-bs-dismiss="modal">Register</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Login Modal  -->

<!--Register Modal-->
<div class="modal fade"  id="registermodal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Register</h5>
                <button  class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="single-page customerpage">
                    <div class="wrapper wrapper2 box-shadow-0 border-0">
                        <div class="card-body pb-4">
                            <div class="btn-list d-flex">
                                <a class="btn btn-google btn-block" href="https://www.google.com/gmail/"><i class="fa fa-google fa-1x me-2"></i> Google</a>
                                    <a class="btn btn-twitter" href="https://twitter.com/"><i class="fa fa-twitter fa-1x"></i></a>
                                    <a class="btn btn-facebook" href="https://www.facebook.com/"><i class="fa fa-facebook fa-1x"></i></a>
                            </div>
                        </div>
                        <hr class="divider">
                        <form class="card-body pt-3" id="register" name="register">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">First Name</label>
                                        <input class="form-control" placeholder="First Name" type="text">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Last Name</label>
                                        <input class="form-control" placeholder="Last Name" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Mail or Username</label>
                                <input class="form-control" placeholder="Email" type="email">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Password</label>
                                <input class="form-control" placeholder="password" type="password">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Captcha</label>
                                <input class="form-control" placeholder="captch" type="text">
                                <div class="captch-body">
                                    <img src="<?php echo base_url();?>backend/support/assets/images/png/captcha.png" alt="img">
                                </div>
                            </div>
                            <div class="submit">
                                <a class="btn btn-primary btn-block" href="index.html">Submit</a>
                            </div>
                            <div class="text-center mt-3">
                                <p class="text-dark mb-0">Already have an account?<a class="text-primary ms-1" href="#" data-bs-toggle="modal" data-bs-target="#loginmodal" data-bs-dismiss="modal">Login</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Register Modal  -->

<!--Chat Popup-->
<div class="chat-message-popup card mb-4 animated">
    <div class="popup-head">
        <div class="row">
            <div class="message-popup-left">
                <div class="dropdown">
                    <a class="" href="" data-bs-toggle="dropdown"><i class="fe fe-more-horizontal text-white"></i></a>
                    <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow">
                        <a href="#" class="dropdown-item" >
                            <i class="fe fe-mail text-primary me-1"></i> Send Mail
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fe fe-thumbs-up text-primary me-1"></i> Rate as Good
                        </a>
                        <a href="#" class="dropdown-item" >
                            <i class="fe fe-thumbs-down text-primary me-1"></i> Rate as Bad
                        </a>
                        <a href="#" class="dropdown-item" >
                            <i class="fe fe-settings text-primary me-1"></i> Settings
                        </a>
                    </div>
                </div>
            </div>
            <div class="text-center font-weight-bold col-12 text-center">
                Chat With Us
            </div>
            <div class="message-popup-right text-end">
                <a class="card-options-fullscreen me-2" href="#" data-bs-toggle="card-fullscreen"><i class="fe fe-maximize text-white"></i></a>
                <a class="popup-minimize-normal" href="#"><i class="fe fe-x text-white"></i></a>
                <a class="popup-minimize" href="#"><i class="fe fe-x text-white"></i></a>
                <a class="popup-minimize-fullscreen" href="#"><i class="fe fe-x text-white"></i></a>
            </div>
        </div>
    </div>
    <div class="popup-chat-main-body">
        <div class="user-header p-3 border-top border-bottom">
            <div class="d-flex">
                <div class="d-flex">
                    <img class="avatar avatar-md brround me-2" src="<?php echo base_url();?>backend/support/assets/images/users/16.jpg" alt="message user image">
                    <div>
                        <h6 class="mb-0 font-weight-bold">Abigali kelly</h6>
                        <span class="w-2 h-2 brround bg-success d-inline-block me-1"></span> <small>active</small>
                    </div>
                </div>
                <div class="ms-auto">
                    <div class="chat-message-header-icons mt-1 fs-20">
                        <a class="me-2" href=""><i class="fe fe-volume-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="popup-messages pt-0">
            <div class="direct-chat-messages">
                <div class="chat-box-single-line">
                    <abbr class="timestamp">March 15th, 2021</abbr>
                </div>
                <div class="direct-chat-msg">
                    <div class="direct-chat-text">Hello. How are you today?<small class="time-text">10.00am</small></div>
                    <img class="direct-chat-img me-2" src="<?php echo base_url();?>backend/support/assets/images/users/16.jpg" alt="message user image">
                </div>
                <div class="direct-chat-msg right">
                    <div class="direct-chat-text">
                        Yes
                        <small class="time-text">10.00am</small>
                    </div>
                    <div class="direct-chat-text">
                        I'm fine. Thanks for asking fine. Thanks for asking!
                        <small class="time-text">10.00am</small>
                    </div>
                    <img class="direct-chat-img" src="<?php echo base_url();?>backend/support/assets/images/users/1.jpg" alt="message user image">
                </div>
                <div class="chat-box-single-line mt-5">
                    <abbr class="timestamp">March 16th, 2021</abbr>
                </div>
                <div class="direct-chat-msg">
                    <div class="direct-chat-text">Various versions have evolved over the years, sometimes<small class="time-text">10.00am</small></div>
                    <img class="direct-chat-img me-2" src="<?php echo base_url();?>backend/support/assets/images/users/16.jpg" alt="message user image">
                </div>
                <div class="direct-chat-msg right">
                    <div class="direct-chat-text">
                        If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.
                        <small class="time-text">10.00am</small>
                    </div>
                    <img class="direct-chat-img" src="<?php echo base_url();?>backend/support/assets/images/users/1.jpg" alt="message user image">
                </div>
                <div class="direct-chat-msg">
                    <div class="direct-chat-text">All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary<small class="time-text">10.00am</small></div>
                    <div class="direct-chat-text">making this the first true generator on the Internet<small class="time-text">10.00am</small></div>
                    <img class="direct-chat-img me-2" src="<?php echo base_url();?>backend/support/assets/images/users/16.jpg" alt="message user image">
                </div>
                <div class="direct-chat-msg right">
                    <div class="direct-chat-text">
                        <img src="<?php echo base_url();?>backend/support/assets/images/photos/1.jpg" class="d-block" alt="img">
                        <small class="time-text">10.00am</small>
                    </div>
                    <img class="direct-chat-img" src="<?php echo base_url();?>backend/support/assets/images/users/1.jpg" alt="message user image">
                </div>
                <div class="chat-box-single-line mt-5">
                    <abbr class="timestamp">March 16th, 2021</abbr>
                </div>
                <div class="direct-chat-msg">
                    <div class="direct-chat-text">Various versions have evolved over the years, sometimes<small class="time-text">10.00am</small></div>
                    <img class="direct-chat-img me-2" src="<?php echo base_url();?>backend/support/assets/images/users/16.jpg" alt="message user image">
                </div>
                <div class="direct-chat-msg right">
                    <div class="direct-chat-text">
                        If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.
                        <small class="time-text">10.00am</small>
                    </div>
                    <img class="direct-chat-img" src="<?php echo base_url();?>backend/support/assets/images/users/1.jpg" alt="message user image">
                </div>
                <div class="direct-chat-msg">
                    <div class="direct-chat-text"><iframe width="100" height="250" src="https://www.youtube.com/embed/kFjETSa9N7A"  allow="accelerometer; autoplay;" allowfullscreen></iframe><small class="time-text">10.00am</small></div>
                    <div class="direct-chat-text">All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary<small class="time-text">10.00am</small></div>
                    <img class="direct-chat-img me-2" src="<?php echo base_url();?>backend/support/assets/images/users/16.jpg" alt="message user image">
                </div>
                <div class="direct-chat-msg right">
                    <div class="direct-chat-text">
                        <img src="<?php echo base_url();?>backend/support/assets/images/photos/2.jpg" class="d-block" alt="img">
                        <small class="time-text">10.00am</small>
                    </div>
                    <div class="direct-chat-text">All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary<small class="time-text">10.00am</small></div>
                    <img class="direct-chat-img me-2" src="<?php echo base_url();?>backend/support/assets/images/users/16.jpg" alt="message user image">
                </div>
                <div class="direct-chat-msg">
                    <div class="direct-chat-text">making this the first true generator on the Internet<small class="time-text">10.00am</small></div>
                    <img class="direct-chat-img me-2" src="<?php echo base_url();?>backend/support/assets/images/users/16.jpg" alt="message user image">
                </div>
                <div class="direct-chat-msg right">
                    <div class="direct-chat-text">
                        <div class="d-flex">
                            <i class="fe fe-file-text fs-40 op-2 text-muted d-block me-2"></i>
                            <div>
                                <div class="font-weight-bold fs-12">sampledemo.txt</div>
                                <span class="fs-12">4.5 kb</span>
                            </div>
                        </div>
                        <small class="time-text">10.00am</small>
                    </div>
                    <div class="direct-chat-text pb-6">
                        <div class="d-flex">
                            <div><img src="<?php echo base_url();?>backend/support/assets/images/photos/thumb1.jpg" class="m-1 w-8 h-8 br-2" alt="img"></div>
                            <div><img src="<?php echo base_url();?>backend/support/assets/images/photos/thumb2.jpg" class="m-1 w-8 h-8 br-2" alt="img"></div>
                        </div>
                        <div class="d-flex">
                            <div><img src="<?php echo base_url();?>backend/support/assets/images/photos/thumb3.jpg" class="m-1 w-8 h-8 br-2" alt="img"></div>
                            <div class="relative"><img src="<?php echo base_url();?>backend/support/assets/images/photos/thumb4.jpg" class="m-1 w-8 h-8 br-2" alt="img">
                                <div class="more-images">+10</div>
                            </div>
                        </div>
                        <small class="time-text">10.00am</small>
                    </div>
                    <img class="direct-chat-img" src="<?php echo base_url();?>backend/support/assets/images/users/1.jpg" alt="message user image">
                </div>
            </div>
        </div>
        <div class="popup-messages-footer card-footer p-0">
            <textarea id="status_message" placeholder="Type a message..." rows="10" cols="40" name="message" class="form-control"></textarea>
            <div class="chat-footer-icons">
                <a class="" href="#"><i class="fe fe-paperclip text-muted"></i></a>
                <a class="" href="#"><i class="fe fe-send text-muted"></i></a>
            </div>
        </div>
    </div>
    <div class="popup-end-chat-main-body">
        <div class="p-6">
            <div class="section-end-chat text-center chat-content">
                <h2 class="font-weight-bold">End Chat?</h2>
                <p>All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary</p>
                <div class="mt-6">
                    <a class="btn btn-primary end-chat-button px-5" href="#">Conform End Chat</a>
                </div>
                <div class="mt-3">
                    <a class="btn btn-link text-primary goback-chat btn-sm" href="#"><i class="fe fe-arrow-left"></i> Go Back</a>
                </div>
            </div>
        </div>
    </div>
    <div class="rating-chat-main-body">
        <div class="p-6">
            <div class="text-start">
                <h3 class="font-weight-bold fs-20">Thank you for Contacting Us</h3>
                <h6>Please rate our supportive team in the following areas </h6>
                <form class="mt-5">
                    <div class="mt-0">
                        <label>What is your best reason for your score</label>
                        <div class="star-ratings start-ratings-main mb-3 clearfix">
                            <div class="stars stars-example-fontawesome star-sm">
                                <select class="rating-fontawesome" name="rating">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4" selected>4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label>What is your best reason for your score</label>
                        <textarea class="form-control" rows="5" cols="50"></textarea>
                    </div>
                    <a class="btn btn-success px-5 mt-4 btn-chat-close" href="#">Submit your Review</a>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Chat Popup-->