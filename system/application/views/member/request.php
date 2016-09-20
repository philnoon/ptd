<div class="form-horizontal">
	
	<div class="row">
	
    <div class="page-header"><h4>Request Details</h4></div>
    <div class="form-group">
        <label class="control-label col-xs-2">Training Name</label>
        <div class="col-xs-10">
            <label class="control-label"><?php echo $request->service_name; ?></label>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-2">Area</label>
        <div class="col-xs-10">
            <label class="control-label"><?php echo $request->req_suburb_name.' ('.$area->area_code.')'; ?></label>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-2">Training Type</label>
        <div class="col-xs-10">
            <label class="control-label"><?php echo get_service_type($request->req_service_type); ?></label>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-2">Closing Date</label>
        <div class="col-xs-10">
            <label class="control-label"><?php echo date('Y-m-d H:i:s', $request->req_expiration_date); ?></label>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-2"></label>
        <div class="col-xs-10">
            <a href="<?php echo site_url('member/requests'); ?>" class="btn btn-default">Back</a>
        </div>
    </div>   
    
    </div>    
    
    
    <div class="page-header"><h4>Quotes</h4></div>
    <div class="row wrapper"><div class="col-lg-12">
        <div class="table-responsive">
        <table class="table table-bordered">
        <thead>
            <tr>
                <th>Trainer</th>
                <th>Price</th>
                <th>Address</th>
                <th>Expiry Date</th>
                <th>Created</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($quotes)) { ?>
                <?php $i=0; foreach($quotes as $r) { $i++; ?>
                <tr>
                    <td><?php echo $r->full_name; ?></td>
                    <td><?php echo $r->quote_price; ?></td>
                    <td><?php echo $r->quote_address; ?></td>
                    <td><?php echo date('Y-m-d H:i:s', $r->quote_expiration_date); ?></td>
                    <td><?php echo $r->quote_created_at; ?></td>
                    <td><?php echo get_quote_status($r); ?></td>
                    <td><a href="<?php echo site_url('member/quote/'.md5($r->quote_id)); ?>">View</a></td>
                </tr>
                <?php } ?>
            <?php } else { ?>
                <tr><td colspan="20">There is no received requests.</td></tr>
            <?php } ?>
        </tbody>
        </table>
        </div>
        
    </div></div>
</div>