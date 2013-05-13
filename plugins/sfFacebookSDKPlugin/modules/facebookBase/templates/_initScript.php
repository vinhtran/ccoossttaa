<div id="fb-root"></div>
<script type="text/javascript">
	//Load the SDK Asynchronously
	(function(d){
		var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
		js = d.createElement('script'); js.id = id; js.async = true;
		js.src = "//connect.facebook.net/<?php echo $lang?>/all.js";
		d.getElementsByTagName('head')[0].appendChild(js);
	}(document));
	 
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '<?php echo $appId?>', // App ID
      channelURL : '//<?php echo $channelFileUrl?>', // Channel File
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      oauth      : true, // enable OAuth 2.0
      xfbml      : true  // parse XFBML
    });

  <?php 
    $fbFuncName = $sf_data->getRaw('fbFuncName');
    
    if (!is_array($fbFuncName)) {
      $fbFuncName = array($fbFuncName);
    }

    foreach ($fbFuncName as $oneFunc) {
      echo $oneFunc."();\n";
    }?>
  };
</script>