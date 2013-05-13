<script type="text/javascript">
  function fb_login_event()
  {
    $('#playGameBtn').click(function() {
      window.oldText = $('#playGameBtn > span').html();
    	var loadingText = new Array(
	  		'je joue.&nbsp;&nbsp;',
	  		'je joue..&nbsp;', 
	  		'je joue...'
	  	);
			var position = 0;
			$('#playGameBtn > span').addClass('Loading');
			window.playGameBtnInterval = setInterval(function() {
				$('#playGameBtn > span').html(loadingText[position % 3]);
		  	++position == 3 && (position = 0);
			}, 500);
			
			$('#playGameBtn').unbind('click');
			
  	  FB.getLoginStatus(function(glsResponse) {
//  	  	console.log('getLoginStatus:');
  		  if (glsResponse.authResponse)
      	{
//    			console.log('success');
  			  FB.api('/me', function(aResponse) {
//    				console.log('me:');
		        if (aResponse.error || aResponse.id != glsResponse.authResponse.userID)
    		    {
//		        	console.log('success');
		        	fb_do_login();
		        }
		        else
	  		    {
//		        	console.log('fail');
		        	fb_save_info();
	  		    }
		      });
  		  }
  		  else
            {
    //    			console.log('fail');
      			  fb_do_login();
            }
  		});

  		return false;
    });
  }

  function fb_do_login()
  {
	  FB.login(function(lResponse) {
//		  console.log('dologin:');
 	    if (lResponse.authResponse)
     	{
// 	     	console.log('success');
 	    	fb_save_info();
	    }
	    else
  		{
//	    	console.log('fail');
	    	clearInterval(window.playGameBtnInterval);
	    	$('#playGameBtn > span').html(window.oldText);
	    	fb_login_event();
	    }
    },
    {scope: '<?php echo implode(',', sfFacebookSDKWrapper::getInstance()->getAppRequiredPermission())?>'});
  }

  function fb_save_info()
  {
//	  console.log('save info:');
	  $.post(
			'<?php echo url_for('@service_save_user_info', true)?>',
			function(data) {
				if (data.status == 1)
				{
//					console.log('success');
					window.location.href = data.redirect_url;
				}
				else
				{
//					console.log('fail');
				}
			}
		);
  }
</script>