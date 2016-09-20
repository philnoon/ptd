<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
    <li><a href="<?php echo site_url('profile'); ?>">Profile</a></li>
    <li class="active"><a href="<?php echo site_url('users/questionnaire'); ?>">Health Screen Questionnaire</a></li>
</ul>
<div id="my-tab-content" class="tab-content">
    <div class="tab-pane active">
        <div class="page-header"><h3>Pre Fitness Questionnaire</h3></div>
		
        <?php echo form_open($this->uri->uri_string(), array('class' => "form-horizontal", 'autocomplete' => 'off')); ?>
		
			<div class="row">
			<div class="col-sm-9 col-xs-12">
			<p><strong>This fitness questionnaire needs to be completed before you can do training with PT On Demand.</strong></p>

			<p>This health screen questionnaire does not provide advice on a particular matter, nor does it substitute for advice from an appropriately qualified medical professional. No warranty of safety should result from its use. This health screen questionnaire in no way guarantees against injury or death. No responsibility or liability whatsoever can be accepted by PT on Demand for any loss, damage or injury that may arise from any person acting on any statement of information contained in this tool.</p>			
           </div>
           </div>
           
           <div class="row">       
           <div class="form-group <?php echo form_error('exc_freq')?'has-error':''; ?>">
                <div class="col-sm-3 col-xs-6" style="text-align: right;">
                	<label class="control-label" for="exc_freq">Exercise frequency</label>				
				</div>
				 <div class="col-sm-6 col-xs-6">
					<select id="exc_freq" name="exc_freq">
					<option value="L">Low</option>
					<option value="M">Medium</option>
					<option value="H">High</option>
					</select>
					See <a href="/uploads/media/07_2016/exercise-intensity-guidelines.pdf" target="_blank">exercise intensity guidelines</a>. 
                </div>
               
           </div>
           </div>
           
           <div class="row">
           <div class="form-group <?php echo form_error('fitness_rating')?'has-error':''; ?>">
                <div class="col-sm-3 col-xs-6" style="text-align: right;">
                	<label class="control-label" for="fitness_rating">Self assessed fitness rating<br>1=Sedentary - 5=Active</label>				
            	</div>
            	 <div class="col-sm-9 col-xs-6">
            		<input class="col-sm-6" type="number" id="fitness_rating" name="fitness_rating" class="form-control" min="1" max="5" value="<?php echo set_value('fitness_rating');?>" placeholder="1-5">
            		</select>
            		 <?php echo form_error('fitness_rating'); ?>  
                </div>
           </div>
           </div> 
            <!--
			**
			-->
			
			<div class="row">
			<div class="form-group <?php echo form_error('had_stroke')?'has-error':''; ?>">
			    <div class="col-sm-3 col-xs-6" style="text-align: right;">
			    	<label class="control-label" for="had_stroke">Has your doctor ever told you that you have a heart condition or have ever suffered a stroke?</label>				
				</div>
				 <div class="col-sm-9 col-xs-6">
					<input type="radio" name="had_stroke" value="no" checked> No
					<input type="radio" name="had_stroke" value="yes"> Yes	
			    </div>
			</div>
			</div>
			
			<div class="row">
			<div class="form-group <?php echo form_error('chest_pain')?'has-error':''; ?>">
			    <div class="col-sm-3 col-xs-6" style="text-align: right;">
			    	<label class="control-label" for="chest_pain">Do you ever experience unexplained pains in your chest at rest or during physical activity?</label>				
				</div>
				 <div class="col-sm-9 col-xs-6">
					<input type="radio" name="chest_pain" value="no" checked> No
					<input type="radio" name="chest_pain" value="yes"> Yes	
			    </div>
			</div>
			</div>
			
			<div class="row">
			<div class="form-group <?php echo form_error('dizziness')?'has-error':''; ?>">
			    <div class="col-sm-3 col-xs-6" style="text-align: right;">
			    	<label class="control-label" for="dizziness">Do you ever feel faint or have spells of dizziness during physical activity that causes you to lose balance?</label>				
				</div>
				 <div class="col-sm-9 col-xs-6">
					<input type="radio" name="dizziness" value="no" checked> No
					<input type="radio" name="dizziness" value="yes"> Yes	
			    </div>
			</div>
			</div>
			
			<div class="row">
			<div class="form-group <?php echo form_error('asthma')?'has-error':''; ?>">
			    <div class="col-sm-3 col-xs-6" style="text-align: right;">
			    	<label class="control-label" for="asthma">Have you had an asthma attack requiring medical attention at any time over the last 12 months?</label>				
				</div>
				 <div class="col-sm-9 col-xs-6">
					<input type="radio" name="asthma" value="no" checked> No
					<input type="radio" name="asthma" value="yes"> Yes	
			    </div>
			</div>
			</div>
			
			<div class="row">
			<div class="form-group <?php echo form_error('diabetes')?'has-error':''; ?>">
			    <div class="col-sm-3 col-xs-6" style="text-align: right;">
			    	<label class="control-label" for="diabetes">If you have diabetes (type 1 or type II) have you had trouble controlling your blood glucose in the last 3 months?</label>				
				</div>
				 <div class="col-sm-9 col-xs-6">
					<input type="radio" name="diabetes" value="no" checked> No
					<input type="radio" name="diabetes" value="yes"> Yes	
			    </div>
			</div>
			</div>
			
			<div class="row">
			<div class="form-group <?php echo form_error('bodyproblems')?'has-error':''; ?>">
			    <div class="col-sm-3 col-xs-6" style="text-align: right;">
			    	<label class="control-label" for="bodyproblems">Do you have any diagnosed muscle, bone or joint problems that you have been told could be made worse by participating in physical activity?</label>			
				</div>
				 <div class="col-sm-9 col-xs-6">
					<input type="radio" name="bodyproblems" value="no" checked> No
					<input type="radio" name="bodyproblems" value="yes"> Yes	
			    </div>
			</div>
			</div>
			
			<div class="row">
			<div class="form-group <?php echo form_error('dangerous')?'has-error':''; ?>">
			    <div class="col-sm-3 col-xs-6" style="text-align: right;">
			    	<label class="control-label" for="dangerous">Do you have any other medical condition(s) that may make it dangerous for you to participate in physical activity?</label>
			    </div>
			    <div class="col-sm-9 col-xs-6">
			    	<input type="radio" name="dangerous" value="no" checked> No
			    	<input type="radio" name="dangerous" value="yes"> Yes	
			    </div>			
			</div>
			</div>			
			
			<div class="row">
			<div class="col-sm-9 col-xs-12">
			<p>If you answered ‘YES’ to any of the questions, please seek guidance from your GP or appropriate allied health professional prior to undertaking physical activity.</p>
			<p>If you answered ‘NO’ to all of the questions, and you have no other concerns about your health, you may proceed to undertake light-moderate  intensity physical activity.</p>
			<p>I believe that to the best of my knowledge, all of the information I have supplied within this questionnaire is correct.</p>			
			</div>
			</div>		
						
            <div class="row">
            <div class="form-group">
                <label class="control-label col-sm-3"></label>
                <div class="col-sm-9">
                    <button class="btn btn-primary" type="submit" name="submit" value="1">Submit</button>
                </div>
            </div>
            </div>
            
        </div>
        <?php echo form_close(); ?>
    </div>
</div>