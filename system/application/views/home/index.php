<div id="content">
    <div class="container content-wrapper">    
        <div class="col-xs-12 col-md-6 col-sm-6 left-content">
            <?php if(!isset($current_user->id) || $current_user->user_type == USER_MEMBER) { ?>
            <?php echo Template::block('request_form', 'home/request_form'); ?>
            <?php } ?>
        </div>        
        <?php if(!empty($pagecontents1)) { ?>
        	<?php foreach($pagecontents1 as $r) { ?>
        	<?php echo $r->pagecontent; ?>
        	<?php } ?>
        <?php } ?> 
     </div>        
</div>
<div id="content">
<div class="container content-wrapper">
    <div class="col-xs-12 col-md-4 col-sm-4 left-content">    	
    	<?php if(!empty($pagecontents2)) { ?>
    		<?php foreach($pagecontents2 as $p) { ?>
    		<?php echo $p->pagecontent; ?>
    		<?php } ?>
    	<?php } ?> 
    </div>
    <div class="col-xs-12 col-md-4 col-sm-4 left-content">
        <?php if(!empty($pagecontents3)) { ?>
        	<?php foreach($pagecontents3 as $t) { ?>
        	<?php echo $t->pagecontent; ?>
        	<?php } ?>
        <?php } ?> 
    </div>
    <div class="col-xs-12 col-md-4 col-sm-4 left-content">
        <?php if(!empty($pagecontents4)) { ?>
        	<?php foreach($pagecontents4 as $d) { ?>
        	<?php echo $d->pagecontent; ?>
        	<?php } ?>
        <?php } ?> 
    </div>
</div>
</div>