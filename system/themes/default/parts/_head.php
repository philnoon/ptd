<?php
    $settings = $this->settings_model->find_all_by('module', 'core');
    $site_title = $settings['site.title'];
    $description= $settings['site.description'];
    $keywords   = $settings['site.keywords'];
    $author     = $settings['site.author'];
?>
<meta charset="utf-8">
<title><?php echo isset($page_title)?$page_title.'-':''; e($site_title); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="description" content="<?php echo $description; ?>">
<meta name="keywords" content="<?php echo $keywords; ?>">
<meta name="author" content="<?php echo $author; ?>">

<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-title" content="PT On Demand">


<meta name="page-topic" content="PT On Demand offers a network of qualified personal trainers throughout Australia. Request a PT for solo personal training, group fitness or Mums with bubs fitness in your area at your favourite location">
<meta name="robots" content="index, follow" />
<meta name="coverage" content="australia" />
<meta name="Content-Language" content="english" />
<meta name="resource-type" content="document" />
<meta name="rating" content="general" />
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="website" />
<meta property="og:title" content="PT On Demand - Request a PT - Offer PT Services" />
<meta property="og:url" content="https://ptondemand.com.au" />
<meta property="og:site_name" content="PT On Demand" />
<meta property="og:image" content="https://ptondemand.com.au/ptd-logo.png" />

<meta name="google-site-verification" content="eLkh3VMuHB2uugPkQ0LT6LRLPyvKvWF643cHAbNtBEY" />
<link rel="canonical" href="https://ptondemand.com.au" />
<link rel="publisher" href="https://plus.google.com/115358269785210064627/about">
<meta name="twitter:card" content="summary">
<meta name="twitter:description" content="PT On Demand offers a network of qualified personal trainers throughout Australia. Request a PT for solo personal training, group fitness or Mums with bubs fitness in your area at your favourite location.">
<meta name="twitter:title" content="PT On Demand - Request a PT - Offer PT Services">
<meta name="twitter:domain" content="PT On Demand">
<meta name="twitter:image" content="https://ptondemand.com.au/ptd-logo.png">

<script type='application/ld+json'>{"@context":"http:\/\/schema.org","@type":"WebSite","url":"http:\/\/ptondemand.com.au\/","name":"PT On Demand","potentialAction":{"@type":"SearchAction","target":"http:\/\/ptondemand.com.au\/?s={search_term_string}","query-input":"required name=search_term_string"}}</script>
<script type='application/ld+json'>{"@context":"http:\/\/schema.org","@type":"Organization","url":"http:\/\/ptondemand.com.au\/","sameAs":["https:\/\/www.facebook.com\/www.ptondemand.com.au","https:\/\/plus.google.com\/115358269785210064627\/about"],"name":"PT On Demand","logo":"http:\/\/ptondemand.com.au\/ptd-logo-sq.png"}</script>


<link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">

<?php echo Assets::css(); ?>

<script type="text/javascript" src="<?php echo site_url('assets/plugins/jquery.min.js'); ?>"></script>

<link rel="stylesheet" type="text/css" href="/assets/plugins/addtohomescreen/addtohomescreen.css">
<script src="/assets/plugins/addtohomescreen/addtohomescreen.js" type="text/javascript" ></script>
<script>
addToHomescreen();
</script>

<script type='text/javascript' src='//dsms0mj1bbhn4.cloudfront.net/assets/pub/shareaholic.js' data-shr-siteid='27d0ebd1251d8d7de4006b6866ae70c2' data-cfasync='false' async='async'></script>

<script>var base_url = '<?php echo site_url(); ?>';</script>