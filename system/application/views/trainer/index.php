
<div class="page-header"><h3>Availability</h3></div>
    
<p>Select services and areas where you are available.</p>

<?php echo form_open($this->uri->uri_string(), array('class' => "form-horizontal", 'autocomplete' => 'off')); ?>

    <?php echo form_dropdown('my_services[]', $services, set_value('my_services', $my_services), 'Services', 'multiple class="chosen-select" data-placeholder="" style="width:350px;"'); ?>    
    
    <?php echo form_dropdown('my_areas[]', $areas, set_value('my_areas', $my_areas), 'Area post codes', 'multiple class="chosen-select" data-placeholder="" style="width:350px;"'); ?>
    <br/>
    <button class="btn btn-default" type="submit" name="submit" value="1">Save</button>
<?php echo form_close(); ?>
