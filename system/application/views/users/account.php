<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
    <li><a href="<?php echo site_url('profile'); ?>">Profile</a></li>    
   
   <!-- if the user type is a member show the questionnaire -->
    <?php if($current_user->user_type === USER_MEMBER) { ?>
    <li><a href="<?php echo site_url('users/questionnaire'); ?>">Health Screen Questionnaire</a></li>    
    <?php } ?>
    
    <!--show the account tab to trainers -->
    <?php if($current_user->user_type === USER_TRAINER) { ?>
    <li class="active"><a href="<?php echo site_url('users/account'); ?>">Account</a></li>
    <?php } ?>
    
    </ul>
    
<div id="my-tab-content" class="tab-content">
    <div class="tab-pane active">
        <div class="page-header"><h3>Annual Fee</h3></div>
		
			<div class="row">
			<div class="col-xs-9">
			<p>PT On Demand really appreciate you paying an annual fee for the update and maintenance of this site.</p>		
           	<p>We are doing a special membership fee for just $1. With an active account you can quote on any number of training requests.</p>
           	</div>
           	
           	
           <div class="col-xs-9">
           <?php           	
           	if ($user->trainer_status_paid == 'Y'){           	
           	echo '<h4>Thanks for your support. Your account is good till '.$user->trainer_fee_exp.'.</h4>';
           			
			echo'
			<div class="form-group">
			    <label class="control-label col-xs-2">Balance </label>
			    <div class="col-xs-10">
			        <label class="control-label">'.$user->trainer_fee_paid.'</label>
			    </div>
			</div>			
			
			<div class="form-group">
			    <label class="control-label col-xs-2">Renewal date </label>
			    <div class="col-xs-10">
			        <label class="control-label">'.$user->trainer_fee_exp.'</label>
			    </div>
			</div>';			
			}           	
			?>	
			  
            <?php
            if ($user->trainer_status_paid != 'Y'){ 
            echo form_open('payment/annualfee/'.$user->id);
            echo '<button type="submit" class="btn btn-default">Accept</button>';
            echo form_close();
            }
            ?>
            </div>            
            </div>
                        
        </div>
    </div>
</div>