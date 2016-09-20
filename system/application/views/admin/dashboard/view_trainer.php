<div class="container-fluid wrapper">
    <form class="form-horizontal" id="form" method="post" enctype="multipart/form-data">
        <fieldset>
         
        <div class="row">   
        <div class="col-xs-12 col-sm-6 col-md-6 col-sm-6">
            
            <legend>Personal Info</legend>
            <input type="hidden" name="id_post" id="id_post" value="<?php echo $user->id;?>">

            <div class="form-group">
                <label class="control-label col-xs-2" for="txtName"><?php echo lang('msg_full_name'); ?></label>
                <div class="col-xs-10">
                    <label class="control-label"><?php echo $user->full_name;?></label>
                </div>
            </div>


            <div class="form-group">
                <label class="control-label col-xs-2" for="txtName"><?php echo lang('msg_email'); ?></label>
                <div class="col-xs-10">
                    <label class="control-label"><?php echo $user->email;?></label>
                </div>
            </div>


            <div class="form-group">
                <label class="control-label col-xs-2" for="txtName"><?php echo lang('msg_phone');?></label>
                <div class="col-xs-10">
                    <label class="control-label"><?php echo $user->phone;?></label>                    
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-xs-2" for="txtName"><?php echo lang('msg_address'); ?></label>
                <div class="col-xs-10">
                    <label class="control-label"><?php echo $user->address;?></label>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-2" for="txtName"><?php echo lang('msg_perm');?></label>
                <div class="col-xs-10">
                    <label class="control-label"><?php echo get_user_type_name($user->user_type); ?></label>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-10 col-xs-offset-2">
                    <a href="<?php echo admin_url('/'); ?>" class="btn btn-primary">Back</a>
                </div>
            </div>
       </div>
       
       
       <div class="col-xs-12 col-sm-6 col-md-6 col-sm-6">
           
           <legend>Trainer Profile</legend>
           		
           	<div class="form-group">
           	    <label class="control-label col-xs-2">Profile photo </label>
           	    <div class="col-xs-10">
           	        <img src="<?php echo user_photo($user->avt); ?>" width="100" height="100"/>
           	    </div>
           	</div>	
           	
           	<div class="form-group">
           		    <label class="control-label col-xs-2">About Me </label>
           		    <div class="col-xs-10">
           		        <p><?php echo $user->about_me; ?></p>	
           		    </div>
           		</div>	             
                            
              <div class="form-group">
                  <label class="control-label col-xs-2">Social </label>		        
                  <div class="col-xs-1">		        
                  <?php 
                  if( $user->facebook_page == ''){
                  echo '<i class="fa fa-facebook-square fa-2x" style="color:#ccc;"></i>';
                  }else{
                  echo '<a href="'.$user->facebook_page.'" target="_blank"><i class="fa fa-facebook-square fa-2x"></i></a>';
                  }		        
                  ?>
                  </div>		        
                  <div class="col-xs-1">		        
                  <?php 
                  if( $user->twitter_page == ''){
                  echo '<i class="fa fa-twitter-square fa-2x" style="color:#ccc;"></i>';
                  }else{
                  echo '<a href="'.$user->twitter_page.'" target="_blank"><i class="fa fa-twitter-square fa-2x"></i></a>';
                  }		        
                  ?>
                  </div>		        
                  <div class="col-xs-1">		        
                  <?php 
                  if( $user->googleplus_page == ''){
                  echo '<i class="fa fa-google-plus-square fa-2x" style="color:#ccc;"></i>';
                  }else{
                  echo '<a href="'.$user->googleplus_page.'" target="_blank"><i class="fa fa-google-plus-square fa-2x"></i></a>';
                  }		        
                  ?>
                  </div>		        
                  <div class="col-xs-1">		        
                  <?php 
                  if( $user->youtube_page == ''){
                  echo '<i class="fa fa-youtube-square fa-2x" style="color:#ccc;"></i>';
                  }else{
                  echo '<a href="'.$user->youtube_page.'" target="_blank"><i class="fa fa-youtube-square fa-2x"></i></a>';
                  }		        
                  ?>
                  </div>
              </div>		    
              <div class="form-group">
                  <label class="control-label col-xs-2">Web site </label>
                  <div class="col-xs-10">
                      <a href="http://<?php echo $user->website_page; ?>" target="_blank"><?php echo $user->website_page; ?></a>
                  </div>
              </div>	
           
       </div>
       
       </div>
       <div class="row">  
            
            
            <?php $certs = $this->config->item('certification'); ?>
            <legend>Certification</legend>
            
            <?php foreach($certs as $key => $value) { ?>
            <div class="form-group">
                <label class="control-label col-xs-2"><?php echo $value;?></label>
                <div class="col-xs-10">
                    <label class="control-label">
                        <?php if($user->$key != null) { ?>
                        <a href="<?php echo certification_img($user->$key); ?>" target="_blank">View Certification</a>
                        <?php } ?>
                    </label>
                </div>
            </div>
            <?php } ?>
            
            <div class="form-group">
                <label class="control-label col-xs-2"></label>
                <div class="col-xs-10">
                    <button type="submit" class="btn btn-primary" name="submit" value="1">Approve</button>                 
                    <a href="<?php echo admin_url('/'); ?>" class="btn btn-warning">Back</a>
                </div>
            </div>
        </div>
        </fieldset>
    </form>
</div>
    