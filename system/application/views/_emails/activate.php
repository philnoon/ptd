<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
            <p>Thank you for registering with <?php e($title) ?>.</p>            
            
            <p>Below you will find a link to activate your membership.</p>
            
            <?php if(isset($temp_password)) { ?><p>Your temporary password: <?php echo $temp_password; ?></p><?php } ?>           
            
            <!--
            <p>Before you can start quoting for jobs you will need to upload copies of your qualification and insurance through your account.</p>
            -->
          
            <p><a href="<?php echo $link; ?>">Activate your account</a></p>
        </td>
    </tr>
</table>