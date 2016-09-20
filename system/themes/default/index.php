<?php echo theme_view('parts/header'); ?>

<div id="wrap">
    <?php echo theme_view('parts/topmenu'); ?>
    
    <div id="content"><div class="container content-wrapper">
        <?php echo Template::message(); ?>
        
        <?php echo Template::draw(); ?>
    </div></div>
</div>

<?php echo theme_view('parts/footer'); ?>