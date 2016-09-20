<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
            <b>Hi <?php echo $member_name; ?></b>
        </td>
    </tr>
    <tr>
        <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
            <p>You have a quote from your training request.</p>
            <p>Trainer Name: <?php echo $trainer_name; ?></p>
            <p>Message: <?php echo $message; ?></p>
            <p>Quote Price: <?php echo $price; ?></p>
            <p>Closing Date: <?php echo date('Y-m-d H:i:s', $closing_date); ?></p>
            <br/>
            
            <p><a href="<?php echo $accept_link; ?>">Accept this Quote</a></p>
        </td>
    </tr>
</table>