<div class="page-header"><h4>Request Detail</h4></div>

<div class="form-group">
    <label class="control-label col-xs-4">Client Name</label>
    <div class="col-xs-8">
        <label class="control-label"><?php echo $request->full_name; ?></label>
    </div>
</div>
 
<div class="form-group">
    <label class="control-label col-xs-4">No Quotes</label>
    <div class="col-xs-8">
        <label class="control-label"><?php echo $quote_nums; ?></label>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-xs-4">Training Type</label>
    <div class="col-xs-8">
        <label class="control-label"><?php echo $request->service_name; ?></label>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-xs-4"></label>
    <div class="col-xs-8">
        <label class="control-label"><?php echo get_service_type($request->req_service_type); ?></label>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-xs-4">Area</label>
    <div class="col-xs-8">
        <label class="control-label"><?php echo $area->area_code; ?></label>
    </div>
</div>


<div class="form-group">
    <label class="control-label col-xs-4">Suburb</label>
    <div class="col-xs-8">
        <label class="control-label"><?php echo $request->req_suburb_name; ?></label>
    </div>
</div>


<div class="form-group">
    <label class="control-label col-xs-4">Request Date</label>
    <div class="col-xs-8">
        <label class="control-label"><?php echo $request->req_require_date; ?></label>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-xs-4">Request Time</label>
    <div class="col-xs-8">
        <label class="control-label"><?php echo get_service_time($request->req_require_time); ?></label>
    </div>
</div>