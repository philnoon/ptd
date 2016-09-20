<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<title><?php echo isset($toolbar_title)?$toolbar_title.'-':''; e($this->settings_lib->item('site.title')); ?></title>

<?php echo Assets::css(); ?>

<script type="text/javascript" src="<?php echo site_url('assets/plugins/jquery.min.js'); ?>"></script>

<link rel="shortcut icon" href="<?php echo site_url('favicon.ico'); ?>"/>