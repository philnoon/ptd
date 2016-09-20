<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url() ?>"><img src="/ptd-logo.svg" width="100" height="100"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo base_url(); ?>" class="btn btn-default btn-list">Home</a></li>
                
                <?php if(!isset($current_user->id)) { ?>
                <li><a href="<?php echo base_url('register-member'); ?>" class="btn btn-default btn-list">Membership</a></li>
                <li><a href="<?php echo base_url('register-trainer'); ?>" class="btn btn-default btn-list">Trainers</a></li>    
                <?php } else { ?>
                    <?php if($current_user->user_type === USER_TRAINER) { ?>                            
                        <li><a href="<?php echo base_url('trainer'); ?>" class="btn btn-default btn-list">My Services</a></li>    
                        <li><a href="<?php echo base_url('trainer/certification'); ?>" class="btn btn-default btn-list">My Certification</a></li>    
                        <li><a href="<?php echo base_url('trainer/requests'); ?>" class="btn btn-default btn-list">Requests</a></li>    
                    <?php } else if($current_user->user_type === USER_MEMBER) { ?>                            
                        <li><a href="<?php echo base_url('member/requests'); ?>" class="btn btn-default btn-list">Requests</a></li>    
                    <?php } ?>
                <?php } ?>            
            <?php if(isset($current_user->id)) { ?>
                <?php if($current_user->user_type === USER_ADMIN) { ?>                            
                <li><a href="<?php echo admin_url('/') ?>" class="btn btn-default btn-list">Admin Dashboard</a></li>
                <?php } else { ?>
                <li><a href="<?php echo site_url('profile') ?>" class="btn btn-default btn-list">Profile</a></li>
                <?php } ?>                
                <li><a href="<?php echo site_url('logout') ?>" class="btn btn-default btn-list">Logout</a></li>     
            <?php } else { ?>
                    <li><a href="<?php echo site_url('login'); ?>" class="btn btn-default btn-list">Login</a></li>
                </ul>
            <?php } ?>
        </div>
    </div>
</nav>