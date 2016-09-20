<div class="form-horizontal">

<div class="row">

	<div class="col-xs-12 col-sm-12 col-md-12 col-sm-12">
    
    <div class="page-header"><h4>You requested this training on <?php echo $record->req_created_at; ?></h4></div>	
	
    <div class="form-group">
        <label class="control-label col-xs-2">Training Name</label>
        <div class="col-xs-10">
            <label class="control-label"><?php echo $record->service_name; ?></label>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-2">Area</label>
        <div class="col-xs-10">
            <label class="control-label"><?php echo $area->area_code; ?></label>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-2">Training Type</label>
        <div class="col-xs-10">
            <label class="control-label"><?php echo get_service_type($record->req_service_type); ?></label>
        </div>
    </div>    

    <div class="form-group">
        <label class="control-label col-xs-2">Closing Date</label>
        <div class="col-xs-10">
            <label class="control-label"><?php echo date('Y-m-d H:i:s', $record->req_expiration_date); ?></label>
        </div>
    </div>
    
    </div>
		
	</div>

<br/>
    
<div class="row">    
    
	<div class="col-xs-12 col-sm-6 col-md-6 col-sm-6">
		
		<div class="page-header"><h4>Quote Details</h4></div>
		
	    <div class="form-group">
	        <label class="control-label col-xs-2">Message</label>
	        <div class="col-xs-10">
	            <label class="control-label" style="text-align: left;"><?php echo $record->quote_message; ?></label>
	        </div>
	    </div>
	
	
	    <div class="form-group">
	        <label class="control-label col-xs-2">location</label>
	        <div class="col-xs-10">
	            <label class="control-label"><?php echo $record->quote_address; ?></label>
	        </div>
	    </div>
	    
	    <div class="form-group">
	        <label class="control-label col-xs-2">Price</label>
	        <div class="col-xs-10">
	            <label class="control-label">$<?php echo $record->quote_price; ?></label>
	        </div>
	    </div>
	    
	    
	    <div class="form-group">
	        <label class="control-label col-xs-2"></label>
	        <div class="col-xs-10">	        	
        	<?php       	
        	if($hidebtn == 'hide') {
        	echo '';
        	} else {
        	echo'<button class="btn btn-default" type="button" name="submit" id="btn_accept" value="1" data-toggle="modal" data-target="#confirmmodal">Accept</button>';	       
        	} ?>
        	<a href="<?php echo site_url('member/request/'.md5($record->req_id)); ?>" class="btn btn-default">Back</a>
        	              
	        </div>
	    </div>
	</div>	
	
	<div class="col-xs-12 col-sm-6 col-md-6 col-sm-6">	    
		    
		    <div class="page-header"><h4><?php echo $record->full_name; ?>'s Profile</h4></div>
		    
		    <div class="form-group">
		         <img src="<?php echo user_photo($record->avt); ?>" width="100" height="100"/>
		    </div>
		    
		
		    <div class="form-group" style="max-height: 250px; overflow-y: scroll;">		        
		        <p><?php echo $record->about_me; ?></p>		            
		    </div>
		    <hr />
		    
		    <div class="form-group">
		        <label class="control-label col-xs-2">Social </label>		        
		        <div class="col-xs-1">		        
		        <?php 
		        if( $record->facebook_page == ''){
		        echo '<i class="fa fa-facebook-square fa-2x" style="color:#ccc;"></i>';
		        }else{
		        echo '<a href="'.$record->facebook_page.'" target="_blank"><i class="fa fa-facebook-square fa-2x"></i></a>';
		        }		        
		        ?>
		        </div>		        
		        <div class="col-xs-1">		        
		        <?php 
		        if( $record->twitter_page == ''){
		        echo '<i class="fa fa-twitter-square fa-2x" style="color:#ccc;"></i>';
		        }else{
		        echo '<a href="'.$record->twitter_page.'" target="_blank"><i class="fa fa-twitter-square fa-2x"></i></a>';
		        }		        
		        ?>
		        </div>		        
		        <div class="col-xs-1">		        
		        <?php 
		        if( $record->googleplus_page == ''){
		        echo '<i class="fa fa-google-plus-square fa-2x" style="color:#ccc;"></i>';
		        }else{
		        echo '<a href="'.$record->googleplus_page.'" target="_blank"><i class="fa fa-google-plus-square fa-2x"></i></a>';
		        }		        
		        ?>
		        </div>		        
		        <div class="col-xs-1">		        
		        <?php 
		        if( $record->youtube_page == ''){
		        echo '<i class="fa fa-youtube-square fa-2x" style="color:#ccc;"></i>';
		        }else{
		        echo '<a href="'.$record->youtube_page.'" target="_blank"><i class="fa fa-youtube-square fa-2x"></i></a>';
		        }		        
		        ?>
		        </div>
		    </div>		    
		    
		    <div class="form-group">
		        <label class="control-label col-xs-2">Web site</label>
		        <div class="col-xs-10">
		            <a href="<?php echo $record->website_page; ?>" target="_blank"><?php echo $record->website_page; ?></a>
		        </div>
		    </div>		    
		   
		    <div class="form-group">
		        <label class="control-label col-xs-2">Reward Points</label>
		        <div class="col-xs-10">
		            <label class="control-label"><?php echo $record->reward_points; ?></label>
		        </div>
		    </div>
		   
		    <div class="form-group">
            <label class="control-label col-sm-2" for="rating_time">Punctuality Rating</label>
            <div class="col-sm-10">
                <?php echo set_value('rating_time', $record->rating_time);?>   
	            </div>
	        </div>           
	
	        <div class="form-group">
	            <label class="control-label col-sm-2" for="rating_prof">Professional Rating</label>
	            <div class="col-sm-10">
	                <?php echo set_value('rating_prof', $record->rating_prof);?>   
	            </div>
	        </div>            
	
	        <div class="form-group">
	            <label class="control-label col-sm-2" for="rating_consult">Consultation Rating</label>
	            <div class="col-sm-10">
	                <?php echo set_value('rating_consult', $record->rating_consult);?>   
	            </div>
	        </div>            
	
	        <div class="form-group">
	            <label class="control-label col-sm-2" for="rating_all">Overall Rating</label>
	            <div class="col-sm-10">
	                <?php echo set_value('rating_all', $record->rating_all);?>   
	            </div>
	        </div>
	
	</div>

</div>	
</div>


<div class="row">
<div class="col-xs-12 col-md-4 col-sm-4">
	<div class="page-header"><h4>Terms and Conditions</h4></div>
	<p>Please read the terms and conditions prior to payment for training</p>
	<a href="javascript:void(0)" data-toggle="modal" data-target="#privacypolicymodal">Terms and Conditions</a>
</div>

<div class="col-xs-12 col-md-4 col-sm-4">

    <div class="page-header"><h4>Training Cancellation</h4></div>
    <p>You must give cancellation notice to the trainer 24 hours prior to the training date to retain your training fees. If you cancel your training session you will not be refunded your deposit.</p>
</div>


<div class="col-xs-12 col-md-4 col-sm-4">
    <div class="page-header"><h4>Training Rescheduling</h4></div>
    <p>You must give reschedule notice to the trainer 24 hours prior to the training date to retain your training fees. If you miss your training session you will not be refunded your deposit.</p>
</div>
</div>

<!--Confirm Modal-->
<div class="modal fade" id="confirmmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <?php echo form_open('payment/checkout/'.$quote_code); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="myModalLabel">Confirm payment</h3>
                
            </div>
            <div class="modal-body">
                <p>I have read the <a href="javascript:void(0)" data-toggle="modal" data-target="#privacypolicymodal">Terms and Conditions</a>.</p>
                <a href="https://ptondemand.com.au/uploads/Terms-and-Conditions.pdf"><i class="fa fa-file-pdf-o"></i> Download Terms and Conditions as PDF document</a>
            </div>
            <div class="modal-footer">
            	<button type="submit" class="btn btn-default">Accept</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<!--Help Modal-->
<div class="modal fade" id="privacypolicymodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Terms and Conditions</h4>
                <a href="https://ptondemand.com.au/uploads/Terms-and-Conditions.pdf"><i class="fa fa-file-pdf-o"></i> Download Terms and Conditions as PDF document</a>
            </div>
            <div class="modal-body">
                <h3>Terms and Conditions ("Terms")</h3>
                <p>Last updated: October 06, 2015</p>
                
                <p>Please read these Terms and Conditions ("Terms", "Terms and Conditions") carefully before using the https://ptondemand.com.au website (the "Service") operated by PT On Demand ("us", "we", or "our").</p>
                
                <p>Your access to and use of the Service is conditioned on your acceptance of and compliance with these Terms. These Terms apply to all visitors, users and others who access or use the Service.</p>
                
                <p>By accessing or using the Service you agree to be bound by these Terms. If you disagree with any part of the terms then you may not access the Service.</p>
                
                <p><strong>Accounts</strong></p>
                
                <p>When you create an account with us, you must provide us information that is accurate, complete, and current at all times. Failure to do so constitutes a breach of the Terms, which may result in immediate termination of your account on our Service.</p>
                
                <p>You are responsible for safeguarding the password that you use to access the Service and for any activities or actions under your password, whether your password is with our Service or a third-party service.</p>
                
                <p>You agree not to disclose your password to any third party. You must notify us immediately upon becoming aware of any breach of security or unauthorised use of your account.</p>    
                
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
           
        </div>
    </div>
</div>