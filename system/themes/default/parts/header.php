<?php 
$css = array(
    'plugins/bootstrap/css/bootstrap.min.css',    
    'plugins/font-awesome/css/font-awesome.css',
    'custom.css',
    'fonts.css',
    'plugins/datepicker/css/bootstrap-datepicker3.min.css',
);
Assets::add_css($css);

$js = array(
    'plugins/bootstrap/js/bootstrap.min.js',
    'plugins/jquery_validation/jquery.validate.min.js',
    'plugins/jquery_validation/additional-methods.min.js',
    'plugins/handlebars-v1.3.0.js',
    'plugins/datepicker/js/bootstrap-datepicker.min.js',
    'common.js',
    'plugins/typeahead/typeahead.jquery.min.js',
    'plugins/googleanalytics/analyticstracking.js',
);
Assets::add_js($js);
?>

<!doctype html>
<html>
<head>
<?php echo theme_view('parts/_head'); ?>
</head>

<script>
// This is called with the results from from FB.getLoginStatus().
function statusChangeCallback(response) {
console.log('statusChangeCallback');
console.log(response);
}

window.fbAsyncInit = function() {
	FB.init({
	appId      : '1664247707121049',
	cookie     : true,  // enable cookies to allow the server to access the session
	xfbml      : true,  // parse social plugins on this page
	version    : 'v2.2' // use version 2.2
	});
	
	FB.getLoginStatus(function(response) {
	statusChangeCallback(response);
	});
};

// Load the SDK asynchronously
(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/en_US/sdk.js";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Here we run a very simple test of the Graph API after login is
// successful.  See statusChangeCallback() for when this call is made.
function testAPI() {
console.log('Welcome!  Fetching your information.... ');
FB.api('/me', function(response) {
  console.log('Successful login for: ' + response.name);
  document.getElementById('status').innerHTML =
    'Thanks for logging in, ' + response.name + '!';
});
}

//stream publish method
function streamPublish(name, description, hrefTitle, hrefLink, userPrompt){
    FB.ui(
    {
        method: 'stream.publish',
        message: '',
        attachment: {
            name: name,
            caption: '',
            description: (description),
            href: hrefLink
        },
        action_links: [
            { text: hrefTitle, href: hrefLink }
        ],
        user_prompt_message: userPrompt
    },
    function(response) {

    });

}

function showStream(){
    FB.api('/me', function(response) {
        //console.log(response.id);
        streamPublish(response.name, 'PT on Demand', 'hrefTitle', 'https://ptondemand.com.au', "Share PT on Demand");
    });
}

function share(){
    var share = {
        method: 'stream.share',
        u: 'https://ptondemand.com.au'
    };

    FB.ui(share, function(response) { console.log(response); });
}

function nolikes() {
/* make the API call */
FB.api(
    "/{user-id}/likes",
    function (response) {
      if (response && !response.error) {
        /* handle the result */
        console.log(data);
      }
    }
);}
</script>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

<script src="https://apis.google.com/js/platform.js" async defer></script>

<body class="<?php echo isset($page_class)?$page_class:''; ?>">  
