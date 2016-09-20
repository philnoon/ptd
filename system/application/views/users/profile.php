<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
tinymce.init({
selector: 'textarea',
theme: 'modern',
menubar: false,
plugins: ['autolink link image lists charmap print preview hr anchor',
'wordcount visualchars code fullscreen insertdatetime media nonbreaking',
'save table paste textcolor'],
toolbar: 'bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image | forecolor'}); 
</script>

<?php
//set a cookie to remember modal- if cookie is set dont show again
if (!isset($_COOKIE['ptd-welcome-screen'])){
setcookie("ptd-welcome-screen", "true", time()+86400, "/");
$this->load->view('welcome-screen-js');
}?>


<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
    <li class="active"><a href="<?php echo site_url('profile'); ?>">Profile</a></li>    
   
   <!-- if the user type is a member show the questionnaire -->
    <?php if($current_user->user_type === USER_MEMBER) { ?>
    <li><a href="<?php echo site_url('users/questionnaire'); ?>">Health Screen Questionnaire</a></li>    
    <?php } ?>
    
    <!--show the account tab to trainers to pay -->
    <!--show the account tab to members to see how much they have paid -->    
    <!--show the account tab to trainers -->
    <?php if($current_user->user_type === USER_TRAINER) { ?>
    <li class="active"><a href="<?php echo site_url('users/account'); ?>">Account</a></li>
    <?php } ?>    
    </ul>
    
    
<div id="my-tab-content" class="tab-content">
    <div class="tab-pane active">		
		
		<?php echo form_open_multipart($this->uri->uri_string(), array('class' => "form-horizontal", 'autocomplete' => 'off')); ?>
		                
        <div class="row">        
        <div class="col-xs-12 col-sm-6 col-md-6 col-sm-6">        
        
        <div class="page-header"><h3>Personal Info</h3></div>
        
            <div class="form-group">
                <label class="control-label col-xs-3">Photo</label>
                <div class="col-xs-9">
                    <img src="<?php echo user_photo($user->avt); ?>" width="100" height="100">
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-xs-3" for="txtName">Upload new photo</label>
                <div class="col-xs-9">
                    <input type="file" id="avt" class="" name="avt">
                    <span style="margin-top:5px;display:block">JPEG|JPN|PNG 5MB</span>
                    
                    <?php if($user->avt!=null) { ?>
                    <input type="submit" name="delete_photo" class="btn btn-danger" value="Remove"/>
                    <?php } ?>
                </div>
            </div>
            
            <div class="form-group <?php echo form_error('full_name')?'has-error':''; ?>">
                <label class="control-label col-sm-3" for="full_name">Full Name</label>
                <div class="col-sm-9">
                    <input type="text" id="full_name" name="full_name" class="form-control" value="<?php echo set_value('full_name', $user->full_name);?>" placeholder="Full Name">
                    <?php echo form_error('full_name'); ?>       
                </div>
            </div>
            
            <div class="form-group <?php echo form_error('email')?'has-error':''; ?>">
                <label class="control-label col-sm-3" for="email">Email</label>
                <div class="col-sm-9">
                    <input type="text" id="email" name="email" class="form-control" value="<?php echo set_value('email', $user->email);?>" placeholder="Email">
                    <?php echo form_error('email'); ?>       
                </div>
            </div>
            
            <div class="form-group <?php echo form_error('phone')?'has-error':''; ?>">
                <label class="control-label col-sm-3" for="phone">Phone</label>
                <div class="col-sm-9">
                    <input type="text" id="phone" name="phone" class="form-control" value="<?php echo set_value('phone', $user->phone);?>" placeholder="Phone">
                    <?php echo form_error('phone'); ?>       
                </div>
            </div>
            
            <div class="form-group <?php echo form_error('address')?'has-error':''; ?>">
                <label class="control-label col-sm-3" for="address">Address</label>
                <div class="col-sm-9">
                    <input type="text" id="address" name="address" class="form-control" value="<?php echo set_value('address', $user->address);?>" placeholder="Address">
                    <?php echo form_error('address'); ?>       
                </div>
            </div>
            
            <div class="form-group <?php echo form_error('abn')?'has-error':''; ?>">
                <label class="control-label col-sm-3" for="abn">Abn</label>
                <div class="col-sm-9">
                    <input type="text" id="abn" name="abn" class="form-control" value="<?php echo set_value('abn', $user->abn);?>" placeholder="Abn">
                    <?php echo form_error('abn'); ?>
                    <p>ABN is not required but go to <a href="http://www.business.gov.au/registration-and-licences/Pages/register-for-an-australian-business-number-abn.aspx" target="_blank">business.gov.au</a> to find out if you need to apply for your ABN for tax purposes.</p>                        
                </div>
            </div>
            
            <?php if($current_user->user_type == USER_TRAINER) { ?>
            <div class="form-group <?php echo form_error('paypal_email')?'has-error':''; ?>">
                <label class="control-label col-sm-3" for="paypal_email">Paypal Email</label>
                <div class="col-sm-9">
                    <input type="text" id="paypal_email" name="paypal_email" class="form-control" value="<?php echo set_value('paypal_email', $user->paypal_email);?>" placeholder="Paypal Email">
                    <?php echo form_error('paypal_email'); ?>
                    <p>You need to have a <a href="https://www.paypal.com/au/webapps/mpp/home" target="_blank">Paypal account</a> to receive payments for training. PT On Demand only supports Paypal at this time.</p>
                </div>
            </div>
            <?php } ?>
                        
            
            <div class="form-group">
                <label class="control-label col-sm-3"></label>
                <div class="col-sm-9">
                    <button class="btn btn-default" type="submit" name="submit" value="1">Update</button>

                </div>
            </div>           
            
            
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-sm-6">        
            
            <?php if($current_user->user_type == USER_TRAINER) { ?>
            <div class="page-header"><h3>Profile</h3></div>
            <?php } ?>
            
            
            <?php if($current_user->user_type == USER_TRAINER) { ?>
            <div class="form-group <?php echo form_error('about_me')?'has-error':''; ?>">
                <label class="control-label col-sm-3" for="paypal_email">About Me</label>
                <div class="col-sm-9">
                    <textarea rows="8" cols="50" id="about_me" name="about_me" class="form-control tinymce" placeholder="About Me" wrap="hard"><?=set_value('about_me', $user->about_me)?></textarea>
                    <?php echo form_error('about_me'); ?>
                     <p style="text-align:right;">Word limit is 400</p>
                </div>
            </div>
            <?php } ?>            
            
            
            <?php if($current_user->user_type == USER_TRAINER) { ?>
            <div class="form-group <?php echo form_error('facebook_page')?'has-error':''; ?>">
                <label class="control-label col-sm-3" for="facebook_page">Facebook Page</label>
                <div class="col-sm-9">
                    <input type="text" id="facebook_page" name="facebook_page" class="form-control" value="<?php echo set_value('facebook_page', $user->facebook_page);?>" placeholder="e.g: https://www.facebook.com/www.ptondemand.com.au/">
                    <?php echo form_error('facebook_page'); ?>     
                </div>
            </div>
            <?php } ?>
            
            <?php if($current_user->user_type == USER_TRAINER) { ?>
            <div class="form-group <?php echo form_error('twitter_page')?'has-error':''; ?>">
                <label class="control-label col-sm-3" for="facebook_page">Twitter Profile</label>
                <div class="col-sm-9">
                    <input type="text" id="twitter_page" name="twitter_page" class="form-control" value="<?php echo set_value('twitter_page', $user->twitter_page);?>" placeholder="e.g: https://twitter.com/ptondemandau">
                    <?php echo form_error('twitter_page'); ?>     
                </div>
            </div>
            <?php } ?>
            
            <?php if($current_user->user_type == USER_TRAINER) { ?>
            <div class="form-group <?php echo form_error('youtube_page')?'has-error':''; ?>">
                <label class="control-label col-sm-3" for="youtube_page">Youtube Channel</label>
                <div class="col-sm-9">
                    <input type="text" id="youtube_page" name="youtube_page" class="form-control" value="<?php echo set_value('youtube_page', $user->youtube_page);?>" placeholder="Youtube url">
                    <?php echo form_error('youtube_page'); ?>     
                </div>
            </div>
            <?php } ?>
            
            <?php if($current_user->user_type == USER_TRAINER) { ?>
            <div class="form-group <?php echo form_error('googleplus_page')?'has-error':''; ?>">
                <label class="control-label col-sm-3" for="youtube_page">Google + Page</label>
                <div class="col-sm-9">
                    <input type="text" id="googleplus_page" name="googleplus_page" class="form-control" value="<?php echo set_value('googleplus_page', $user->googleplus_page);?>" placeholder="e.g: https://plus.google.com/115358269785210064627">
                    <?php echo form_error('googleplus_page'); ?>     
                </div>
            </div>
            <?php } ?>
            
            
            <?php if($current_user->user_type == USER_TRAINER) { ?>
            <div class="form-group <?php echo form_error('website_page')?'has-error':''; ?>">
                <label class="control-label col-sm-3" for="website_page">Website</label>
                <div class="col-sm-9">
                    <input type="text" id="website_page" name="website_page" class="form-control" value="<?php echo set_value('website_page', $user->website_page);?>" placeholder="e.g: https://ptondemand.com.au">
                    <?php echo form_error('website_page'); ?>     
                </div>
            </div>
            <?php } ?>            
            </div>
            </div>
            
            
            <div class="row">
            
            <div class="col-xs-12 col-sm-6 col-md-6 col-sm-6"> 
	            
	            <div class="page-header"><h3>Reward Points</h3></div>
	            <p>Points are gained by doing training requests and can be exchanged for PT On Demand merchandise.</p>
	            <p>More information will be provided about what can be exchanged.</p>            
	            
	            <div class="col-xs-12 col-sm-6 col-md-6 col-sm-6"> 
	            	<div class="form-group">
	                <label class="control-label col-sm-3" for="website_page">Reward Points</label>
	                <div class="col-sm-9">
	                    <?php echo set_value('website_page', $user->reward_points);?>   
	                </div>
	          	 	</div>
	        	</div>
			</div>            
            
            <div class="col-xs-12 col-sm-6 col-md-6 col-sm-6"> 
            <div class="page-header"><h3>Rating</h3></div>
            
            <p>Members are encouraged to complete a rating of your training session. Your rating figures are averaged across all the sessions you do.</p>
            

            <div class="form-group">
                <label class="control-label col-sm-3" for="website_page">Punctuality</label>
                <div class="col-sm-9">
                    <?php echo set_value('rating_time', $user->rating_time);?>   
                </div>
            </div>           

            <div class="form-group">
                <label class="control-label col-sm-3" for="website_page">Professionalism</label>
                <div class="col-sm-9">
                    <?php echo set_value('rating_prof', $user->rating_prof);?>   
                </div>
            </div>            

            <div class="form-group">
                <label class="control-label col-sm-3" for="website_page">Consultation</label>
                <div class="col-sm-9">
                    <?php echo set_value('rating_consult', $user->rating_consult);?>   
                </div>
            </div>            

            <div class="form-group">
                <label class="control-label col-sm-3" for="website_page">Overall</label>
                <div class="col-sm-9">
                    <?php echo set_value('rating_all', $user->rating_all);?>   
                </div>
            </div>
            
            </div>
            </div>
            
            <a href="javascript:showscreen();">Show welcome screen</a>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>


<script type="text/javascript">
function showscreen() {
$("#myModal").modal("show");
}
</script>
<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" id="myModalLabel">Welcome to PT On Demand</h3>
      </div>
      <div class="modal-body">      
      <?php if(!empty($pagecontents)) {
      	foreach($pagecontents as $r) {
      	 echo $r->pagecontent; 
      	 }
      }
      ?>      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Got it</button>
      </div>
    </div>
  </div>
</div>