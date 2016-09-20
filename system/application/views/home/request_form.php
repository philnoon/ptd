<?php 
    $this->load->model('service_model');
    
    //get all services
    $services = $this->service_model
        ->find_all();
    Template::set('services', $services);
?>
<?php echo form_open('', array('id' => 'request-form', 'autocomplete' => 'off')); ?>
    <div class="row">
        <h2 style="text-align: center; color: #1D99D8;">Request a Trainer</h2>
    </div>
        
    <div class="row">                
        <input type="radio" name="service_type" class="serviceType" value="<?php echo SERVICE_TYPE_SINGLE; ?>" id="over1a" checked>
        <label for="over1a" class="col-xs-6 col-sm-6 col-lg-6 col-xl-6">
            <i class="fa fa-user fa-2x"></i>
            <span class="singlegroupsessionselect">1-on-1 Training</span>
        </label>
        
        <input type="radio" name="service_type" class="serviceType" value="<?php echo SERVICE_TYPE_GROUP; ?>" id="over1b">
        <label for="over1b" class="col-xs-6 col-sm-6 col-lg-6 col-xl-6">
            <i class="fa fa-users fa-2x"></i>
            <span class="singlegroupsessionselect">Group Training</span>
        </label>
    </div>
            
    <div class="row">
        <h3 style="text-align: center; color: #1D99D8;">Choose a training type</h3>
    </div>
        
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-lg-12 col-xl-12">
            <?php $ind = 0; foreach($services as $s) { $ind++; ?>
                <div class="col-xs-12 col-sm-12 col-lg-6 col-xl-6">
                    <input type="radio" id="trainingtype_<?php echo $s->service_id; ?>" name="training_type" class="trainingtype" value="<?php echo $s->service_id; ?>" <?php echo $ind==1?'checked="true"':''; ?> autocomplete="off">
                    <label for="trainingtype_<?php echo $s->service_id; ?>"><?php echo $s->service_name; ?></label>
                </div>
            <?php } ?>
        </div>                             
    </div>
    
    <div class="row">
        <h3 style="text-align: center; color: #1D99D8;">Whats the best time?</h3>
    </div>
    
    <div class="row">                
        <div class="col-xs-12 col-sm-4 col-lg-4 col-xl-4">                    
            <input name="training_time" class="trainingtype" id="morningtraning" type="radio" value="<?php echo TRAIN_TIME_MORNING; ?>" autocomplete="off" checked="true">
            <label for="morningtraning">Morning</label>
        </div>
        <div class="col-xs-12 col-sm-4 col-lg-4 col-xl-4">
            <input name="training_time" class="trainingtype" id="middaytraining" type="radio" value="<?php echo TRAIN_TIME_MID; ?>" autocomplete="off">
            <label for="middaytraining">Mid Day</label>
        </div>
        <div class="col-xs-12 col-sm-4 col-lg-4 col-xl-4">
            <input name="training_time" class="trainingtype" id="eveningtraining" type="radio" value="<?php echo TRAIN_TIME_EVENING; ?>" autocomplete="off">
            <label for="eveningtraining">Evening</label>                    
        </div>            
    </div>
    
    <div class="row">
        <h3 style="text-align: center; color: #1D99D8;">A few more details...</h3>
    </div>
       
        
    <div class="row">                                
        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-6">
            <div class="col-xs-12 marker">
                <span class="fa fa-map-marker"></span>    
                <div id="the-basics">
                <input id="area_code" name="area_code" type="text" placeholder="Training Area" class="typeahead requestfields" maxlength="15" required>
                </div> 
            </div>                
        </div>        
        
        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-6">
            <div class="col-xs-12 marker">
                <span class="fa fa-calendar"></span>    
                <input id="training_date" name="training_date" type="text" placeholder="Pick a Date" class="requestfields datepicker1" maxlength="8" required data-start-date="<?php echo date('Y-m-d', strtotime('+2 days')); ?>" data-date-format="yyyy-mm-dd" readonly="readonly">
            </div>                
        </div>
    </div>                
    
    <?php if(!isset($current_user->id)) { ?>    
    <div class="row">                                
        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-6">
            <div class="col-xs-12 marker">
                <span class="fa fa-smile-o"></span>    
                <input id="requestor_name" name="requestor_name" type="text" placeholder="Your Name" class="requestfields" maxlength="24" required>
            </div>                
        </div>
        
        
        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-6">
            <div class="col-xs-12 marker">
                <span class="fa fa-envelope"></span>    
                <input id="requestor_email" name="requestor_email" type="email" placeholder="Your Email" class="requestfields" maxlength="50" required>
            </div>                
        </div>
    </div>
    
    <?php } ?> 
        
    <div class="row">
        <div class="col-sm-12">
            <input type="submit" value="Submit Request" class="btn btn-default" id="submit_request" name="submit"/>
            <span class="privacypolicy">By submitting this form you have read and agreed to our <a href="#" title="Privacy Policy" data-toggle="modal" data-target="#privacypolicymodal"> Privacy Policy</a>.</span>    
        </div>
    </div>

<?php echo form_close(); ?>

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
            <?php if(!empty($pagecontents5)) { ?>
            	<?php foreach($pagecontents5 as $t) { ?>
            	<?php echo $t->pagecontent; ?>
            	<?php } ?>
            <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>