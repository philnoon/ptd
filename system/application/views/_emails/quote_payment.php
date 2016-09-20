<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
            <b>Hi <?php echo $trainer_name; ?></b>
        </td>
    </tr>
    <tr>
        <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
            <p>Your quote for '<?php echo $service_name . ' (' . get_service_type($req_service_type) . ')'; ?>' has been accepted by <?php echo $member_name; ?>.</p>
            <br/>
            
            <h4>Quote Detail</h4>
            <p>Message: <?php echo $quote_message; ?></p>
            <p>Quote Price: <?php echo $quote_price; ?></p>
            <p>Quote Date: <?php echo $quote_created_at; ?></p>
            <br/>
            
            <h4>Request Detail</h4>
            <p>Area: <?php echo $req_suburb_name.' (' . $req_area_code . ')'; ?></p>
            <p>Preferred Date: <?php echo $req_require_date; ?></p>
            <p>Preferred Time: <?php echo get_service_time($req_require_time); ?></p>
            <p>For: <?php echo $service_name . ' (' . get_service_type($req_service_type) . ')'; ?> Training</p>
            <br/>
            
            <p><a href="<?php echo site_url('trainer/request/'.md5($req_id)); ?>">View Quote</a></p>
        </td>
    </tr>
</table>