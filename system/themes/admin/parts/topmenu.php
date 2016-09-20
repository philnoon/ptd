<nav class="navbar navbar-inverse navbar-default" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header active">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo site_url('admin'); ?>"><?php e($this->settings_lib->item('site.title')); ?></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">                
                
                <li class="<?php echo $top_menu_item=='users'?'active':'';?>">
                    <a href="<?php echo base_url('admin/users'); ?>">Users</a>
                </li>
				
				 <li class="<?php echo $top_menu_item=='contact'?'active':'';?>">
                    <a href="<?php echo base_url('admin/contact'); ?>">Contact</a>
                </li>
                
				<li class="<?php echo $top_menu_item=='pages'?'active':'';?>">
                    <a href="<?php echo base_url('admin/pages'); ?>">Pages</a>
                </li>
                
                <li class="<?php echo $top_menu_item=='media'?'active':'';?>">
                    <a href="<?php echo base_url('admin/media'); ?>">Media</a>
                </li>
				
                <li class="dropdown <?php echo $top_menu_item=='settings'?'active':'';?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class="<?php echo $sub_menu_item=='general_setting'?'active':'';?>"><a href="<?php echo admin_url('settings/general'); ?>" class="red">General</a></li>
                        <li class="<?php echo $sub_menu_item=='email_setting'?'active':'';?>"><a href="<?php echo admin_url('settings/email'); ?>" class="red">Email</a></li>
                        <li class="<?php echo $sub_menu_item=='paypal_setting'?'active':'';?>"><a href="<?php echo admin_url('settings/paypal'); ?>" class="red">Paypal</a></li>
                    </ul>
                </li>
            </ul>
            
             <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    Hello <?php if($current_user->id) { echo $current_user->full_name; } ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo admin_url('profile'); ?>" class="red">Profile</a></li>
                        <li><a href="<?php echo site_url('logout'); ?>">Logout</a></li>
                    </ul>
                </li>
             </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>