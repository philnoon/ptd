
<div class="col-xs-12 col-md-6 col-sm-6 left-content">
    <?php if($quote_nums >= 6 || $request->req_status == REQUEST_CLOSED) { ?>
        <p>This training request has closed.</p>
        <div class="form-group">
            <label class="control-label col-xs-3"></label>
            <div class="col-xs-9">
                <a href="<?php echo site_url('trainer/requests'); ?>" class="btn btn-default">Back</a>  
            </div>
        </div>
    <?php } else { ?>
        <?php if($request->req_expiration_date <= time()) { ?>
            <p>This training request has expired.</p>
            <div class="form-group">
                <label class="control-label col-xs-3"></label>
                <div class="col-xs-9">
                    <a href="<?php echo site_url('trainer/requests'); ?>" class="btn btn-default">Back</a>  
                </div>
            </div>
        <?php } else { ?>
            <div class="page-header"><h4>Quote for Request</h4></div>
            <?php if(empty($myquote)) { ?>
                <?php Template::block('quote_form', 'trainer/request/quote_form'); ?>                   
            <?php } else { ?>
                <?php if($current_user->id == $request->req_trainer_id_accepted) {?>
                <p>Your quote has been accepted by <?php echo $request->full_name; ?>.</p>
                <?php } ?>
                <div class="form-group">
                    <label class="control-label col-xs-3">Price</label>
                    <div class="col-xs-9">
                        <label class="control-label"><?php echo $myquote->quote_price; ?></label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-xs-3">Address</label>
                    <div class="col-xs-9">
                        <label class="control-label"><?php echo $myquote->quote_address; ?></label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-xs-3">Message</label>
                    <div class="col-xs-9">
                        <label class="control-label"><?php echo $myquote->quote_message; ?></label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-xs-3"></label>
                    <div class="col-xs-9">
                        <a href="<?php echo site_url('trainer/requests'); ?>" class="btn btn-default">Back</a>  
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    <?php } ?>
</div>

<div class="col-xs-12 col-md-6 col-sm-6">    
    <?php Template::block('request_detail', 'trainer/request/detail', array('request' => $request, 'quote_nums' => $quote_nums)); ?>
</div>