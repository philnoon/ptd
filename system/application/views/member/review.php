<form class="form-horizontal" id="form" method="post" enctype="multipart/form-data">	
	<div class="row">	
    <div class="page-header"><h4>Training Review</h4></div>
        		
		<p>Please complete a post-training review</p>	
		
		<div class="form-group <?php echo form_error('req_rating_time')?'has-error':''; ?>">
		     <div class="col-sm-3 col-xs-6" style="text-align: right;">
		     	<label class="control-label" for="fitness_rating">Punctuality</label>				
		 	</div>
		 	 <div class="col-sm-9 col-xs-6">
		 		<input class="col-sm-6" type="number" id="req_rating_time" name="req_rating_time" class="form-control" min="1" max="5"		 		
		 		value="<?php echo set_value('req_rating_time', $request->req_rating_time);?>" placeholder="1-5">		 		 
		 		</select>
		 		 <?php echo form_error('req_rating_time'); ?>  
		     </div>
		</div>
		
		<div class="form-group <?php echo form_error('req_rating_professional')?'has-error':''; ?>">
		     <div class="col-sm-3 col-xs-6" style="text-align: right;">
		     	<label class="control-label" for="fitness_rating">Professionalism</label>				
		 	</div>
		 	 <div class="col-sm-9 col-xs-6">
		 		<input class="col-sm-6" type="number" id="req_rating_professional" name="req_rating_professional" class="form-control" min="1" max="5" 
		 		value="<?php echo set_value('req_rating_professional', $request->req_rating_professional);?>" placeholder="1-5">
		 		</select>
		 		 <?php echo form_error('req_rating_professional'); ?>  
		     </div>
		</div>
		
		<div class="form-group <?php echo form_error('req_rating_consult')?'has-error':''; ?>">
		     <div class="col-sm-3 col-xs-6" style="text-align: right;">
		     	<label class="control-label" for="fitness_rating">Health consultation</label>				
		 	</div>
		 	 <div class="col-sm-9 col-xs-6">
		 		<input class="col-sm-6" type="number" id="req_rating_consult" name="req_rating_consult" class="form-control" min="1" max="5" 
		 		value="<?php echo set_value('req_rating_consult', $request->req_rating_consult);?>" placeholder="1-5">
		 		</select>
		 		 <?php echo form_error('req_rating_consult'); ?>  
		     </div>
		</div>
		
		<div class="form-group <?php echo form_error('req_rating_all')?'has-error':''; ?>">
		     <div class="col-sm-3 col-xs-6" style="text-align: right;">
		     	<label class="control-label" for="fitness_rating">Overall experience</label>				
		 	</div>
		 	 <div class="col-sm-9 col-xs-6">
		 		<input class="col-sm-6" type="number" id="req_rating_all" name="req_rating_all" class="form-control" min="1" max="5" 
		 		value="<?php echo set_value('req_rating_all', $request->req_rating_all);?>" placeholder="1-5">
		 		</select>
		 		 <?php echo form_error('req_rating_all'); ?>  
		     </div>
		</div> 
		
		<div class="form-group <?php echo form_error('btn_accept')?'has-error':''; ?>">
		     <div class="col-sm-3 col-xs-6" style="text-align: right;">
		     	<label class="control-label" for="btn_accept"></label>				
		 	</div>
		 	 <div class="col-sm-9 col-xs-6">		 		
		 		<button type="submit" class="btn btn-default" name="submit" value="1">Submit</button>
		 		<a href="<?php echo site_url('member/requests')?>" class="btn btn-default">Back</a>
		     </div>
		</div>
		
	</div> 
</form>
