<div class="page-header"><h3>Certifications</h3></div>

<?php $certs = $this->config->item('certification'); ?>

<?php foreach($certs as $key => $value) { ?>
<div class="row">
    <div class="col-xs-4 col-md-4 col-sm-4">
        <label><?php echo $value; ?></label>
    </div>
    <div class="col-xs-4 col-md-4 col-sm-4">
        <?php if ($current_user->$key != null) { ?>
        <a href="<?php echo base_url($current_user->qual34); ?>" target="_blank">View Document</a>
        <?php } ?>                    
    </div>
    <div class="col-xs-4 col-md-4 col-sm-4">
        <?php                
        $status_f = "{$key}_st";
        switch ($current_user->$status_f) {
            case "W":
                echo "Waiting approval";
                break;
            case "A":
                echo "Approved";
                break;
            default:
                  echo "Required";
        } ?>
    </div>
</div>
<?php } ?>

<br/>
<div class="col-xs-12 col-md-12 col-sm-12 btn-wrapper">
    <a href="<?php echo base_url('trainer/update_certification') ?>">Update Certification</a>
</div>
<br/><br/>