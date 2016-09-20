<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <!--<tr>
        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
            <b>Hi <?php //echo $user_full_name; ?>!</b>
        </td>
    </tr>-->
    <tr>
        <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
            <p>Forgot your <?php e($this->settings_lib->item('site.title')) ?> password? No worries.</p>
            <p>Below you will find a link that you can use to reset your password for <?php e($this->settings_lib->item('site.title')) ?>. Then, you can change your password to something different.</p>
            <p>This link is only valid for 24 hours.</p>
            <p><a href="<?php echo $link ?>">Go to reset your password</a></p>
        </td>
    </tr>
</table>