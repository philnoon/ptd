<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
            <b>Hi <?php echo $trainer_name; ?></b>
        </td>
    </tr>
    <tr>
        <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
            <p>You have a training request for '<?php echo $service_name; ?>'.</p>
            <p>From: <?php echo $request_name; ?></p>
            <!--<p>Email: <?php //echo $request_email; ?></p>-->
            <p>Area: <?php echo $request_area; ?></p>
            <p>Preferred Date: <?php echo $request_date; ?></p>
            <p>Preferred Time: <?php echo $request_time; ?></p>
            <p>For: <?php echo $request_service_type; ?> Training</p>
            <p>Expire Date: 5 days</p>
            <p><a href="<?php echo $quote_link; ?>">Quote Now</a></p>
        </td>
    </tr>
</table>