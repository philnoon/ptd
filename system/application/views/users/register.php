<div id="content">
        <?php echo Template::block('left_block'); ?>

        <div class="col-xs-12 col-md-4 col-sm-4">
            <?php echo form_open($this->uri->uri_string(), array('class' => "form-login", 'autocomplete' => 'off')); ?>
            <div class="properties row">
                
                
                <!--
                <div class="page-header"><h3><i class="fa fa-facebook-official"></i> Sign up with Facebook</h3></div>

                <fb:login-button scope="public_profile,email" data-size="large" data-max-rows="1" data-auto-logout-link="true" onlogin="checkLoginState();">
                </fb:login-button>
                 
                 <div id="status">
                 </div>
                 
                
                <?php if(isset($fuser) && !empty($fuser)) { ?>
                               
                <div class="fb-like" data-href="<?php echo site_url(); ?>" data-layout="button_count" data-share="true">                
                <div class="form-group <?php echo form_error('email')?'has-error':''; ?>">
                    <label>Email (for signing in)</label>
                    <input type="text" id="email" name="email" class="form-control" value="<?php echo set_value('email', $fuser['email']);?>" placeholder="Email">
                    <?php echo form_error('email');?>
                </div>

                <div class="form-group <?php echo form_error('password')?'has-error':''; ?>">
                    <label>Password</label>
                    <input name="password" id="password" type="password" class="form-control" value="<?php echo set_value('password');?>" placeholder="Password" autofocus>
                    <?php echo form_error('password')?>
                </div>

                <div class="form-group <?php echo form_error('pass_confirm')?'has-error':''; ?>">
                    <label>Password Confirm</label>
                    <input name="pass_confirm" id="pass_confirm" type="password" class="form-control" value="<?php echo set_value('pass_confirm');?>" placeholder="Password Confirm">
                    <?php echo form_error('pass_confirm')?>
                </div>

                <div class="form-group <?php echo form_error('full_name')?'has-error':''; ?>">
                    <label>Full Name</label>
                    <input type="text" id="full_name" name="full_name" class="form-control" value="<?php echo set_value('full_name', $fuser['name']);?>" placeholder="Full Name">
                    <?php echo form_error('full_name');?>
                </div>

                <div class="form-group <?php echo form_error('accept')?'has-error':''; ?>">
                    <p><a href="#" title="Terms and conditions" data-toggle="modal" data-target="#pageModal"><i class="fa fa-file-text"></i> Terms and conditions</a></p>
                    <label>
                        <input type="checkbox" name="accept" id="accept" value="1" <?php echo $this->input->post('accept') ? "checked='checked'" : ''; ?>><span> I have read and accept the terms and conditions</span>
                    </label>
                    <?php echo form_error('accept')?>
                </div>
                <button class="btn btn-default" type="submit" name="submit" value="1">Register</button>
                <?php } else { ?>
                <a href="<?php echo $loginUrl; ?>">
                    <img src="<?php echo site_url('assets/images/facebook_login.png'); ?>" alt="Login with Facebook" title="Login with Facebook" border="0" align="middle"/>
                </a>
                
                -->
                
                <div class="page-header"><h3><i class="fa fa-envelope"></i> Sign up with Email</h3></div>

                <p>You can automatically create your membership account by submitting a <a href="/">training request</a>.</p>
                
                <div class="form-group <?php echo form_error('email')?'has-error':''; ?>">
                    <label>Email (for signing in)</label>
                    <input type="text" id="email" name="email" class="form-control" value="<?php echo set_value('email');?>" placeholder="Email">
                    <?php echo form_error('email');?>
                </div>

                <div class="form-group <?php echo form_error('password')?'has-error':''; ?>">
                    <label>Password</label>
                    <input name="password" id="password" type="password" class="form-control" value="<?php echo set_value('password');?>" placeholder="Password">
                    <?php echo form_error('password')?>
                </div>

                <div class="form-group <?php echo form_error('pass_confirm')?'has-error':''; ?>">
                    <label>Password Confirm</label>
                    <input name="pass_confirm" id="pass_confirm" type="password" class="form-control" value="<?php echo set_value('pass_confirm');?>" placeholder="Password Confirm">
                    <?php echo form_error('pass_confirm')?>
                </div>

                <div class="form-group <?php echo form_error('full_name')?'has-error':''; ?>">
                    <label>Name</label>
                    <input type="text" id="full_name" name="full_name" class="form-control" value="<?php echo set_value('full_name');?>" placeholder="Name">
                    <?php echo form_error('full_name');?>
                </div>

                <div class="form-group <?php echo form_error('accept')?'has-error':''; ?>">
                    <p><a href="#" title="Terms and conditions" data-toggle="modal" data-target="#pageModal"><i class="fa fa-file-text"></i> Terms and conditions</a></p>
                    <label>
                        <input type="checkbox" name="accept" id="accept" value="1" <?php echo $this->input->post('accept') ? "checked='checked'" : ''; ?>><span> I have read and accept the terms and conditions</span></label>
                    <?php echo form_error('accept')?>
                </div>
                <button class="btn btn-default" type="submit" name="submit" value="1">Register</button>
                <?php } ?>
            </div>
        </div>
</div>

<!--Help Modal-->
<div class="modal fade" id="pageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Terms and Conditions</h4>
                <a href="https://ptondemand.com.au/uploads/Terms-and-Conditions.pdf"><i class="fa fa-file-pdf-o"></i> Download Terms and Conditions as PDF document</a>
            </div>
            <div class="modal-body">
                <p>Last updated: October 06, 2015</p>
                
                <p>Please read these Terms and Conditions ("Terms", "Terms and Conditions") carefully before using the https://ptondemand.com.au website (the "Service") operated by PT On Demand ("us", "we", or "our").</p>
                
                <p>Your access to and use of the Service is conditioned on your acceptance of and compliance with these Terms. These Terms apply to all visitors, users and others who access or use the Service.</p>
                
                <p>By accessing or using the Service you agree to be bound by these Terms. If you disagree with any part of the terms then you may not access the Service.</p>
                
                <p><strong>Accounts</strong></p>
                
                <p>When you create an account with us, you must provide us information that is accurate, complete, and current at all times. Failure to do so constitutes a breach of the Terms, which may result in immediate termination of your account on our Service.</p>
                
                <p>You are responsible for safeguarding the password that you use to access the Service and for any activities or actions under your password, whether your password is with our Service or a third-party service.</p>
                
                <p>You agree not to disclose your password to any third party. You must notify us immediately upon becoming aware of any breach of security or unauthorized use of your account.</p>    
                
                <p><strong>Links To Other Web Sites</strong></p>
                
                <p>Our Service may contain links to third-party web sites or services that are not owned or controlled by PT On Demand.</p>
                
                <p>PT On Demand has no control over, and assumes no responsibility for, the content, privacy policies, or practices of any third party web sites or services. You further acknowledge and agree that PT On Demand shall not be responsible or liable, directly or indirectly, for any damage or loss caused or alleged to be caused by or in connection with use of or reliance on any such content, goods or services available on or through any such web sites or services.</p>
                
                <p>We strongly advise you to read the terms and conditions and privacy policies of any third-party web sites or services that you visit.</p>
                
                <p><strong>Termination</strong></p>
                
                <p>We may terminate or suspend access to our Service immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms.</p>
                
                <p>All provisions of the Terms which by their nature should survive termination shall survive termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity and limitations of liability.</p>
                
                <p>We may terminate or suspend your account immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms.</p>
                
                <p>Upon termination, your right to use the Service will immediately cease. If you wish to terminate your account, you may simply discontinue using the Service.</p>
                
                <p>All provisions of the Terms which by their nature should survive termination shall survive termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity and limitations of liability.</p>
                
                <p><strong>Governing Law</strong></p>
                
                <p>These Terms shall be governed and construed in accordance with the laws of Western Australia, Australia, without regard to its conflict of law provisions.</p>
                
                <p>Our failure to enforce any right or provision of these Terms will not be considered a waiver of those rights. If any provision of these Terms is held to be invalid or unenforceable by a court, the remaining provisions of these Terms will remain in effect. These Terms constitute the entire agreement between us regarding our Service, and supersede and replace any prior agreements we might have between us regarding the Service.</p>
                
                <p><strong>Changes</strong></p>
                
                <p>We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a revision is material we will try to provide at least 60 days notice prior to any new terms taking effect. What constitutes a material change will be determined at our sole discretion.</p>
                
                <p>By continuing to access or use our Service after those revisions become effective, you agree to be bound by the revised terms. If you do not agree to the new terms, please stop using the Service.</p>
                
                <p>Our Terms and Conditions agreement was created by TermsFeed.</p>
                
                <p><strong>Contact Us</strong></p>
                
                <p>If you have any questions about these Terms, please contact us.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>