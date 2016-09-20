<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
            <p>New contact form submission</p>
            <?php if(isset($name)) {?>
			<p>Name: <?php echo $name; ?></p><?php } ?>			
			<?php if(isset($emailaddress)) {?>
			<p>Email: <?php echo $emailaddress; ?></p><?php } ?>			
			<?php if(isset($message)) {?>
			<p>Message: <?php echo $message; ?></p><?php } ?>            
        </td>
    </tr>
</table>
