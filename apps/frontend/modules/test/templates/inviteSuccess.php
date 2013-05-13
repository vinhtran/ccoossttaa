<h1>Invite Friends</h1>
<div>
<p>Click <a href="javascript:void(0);" id="loginBtn">here</a> to login the FACEBOOK APP</p>
<script type="text/javascript">
  function fb_login_event()
  {
    $('#loginBtn').click(function() {
  	  FB.getLoginStatus(function(glsResponse) {
      	//console.log(glsResponse);
  		  if (glsResponse.authResponse)
      	{
  			  FB.api('/me', function(aResponse) {
      			  //console.log(aResponse);
		        if (aResponse.error || aResponse.id != glsResponse.authResponse.userID)
    		    {
		        	fb_do_login();
		        }
		        else
	  		    {
//		        	fb_save_info();
	  		    }
		      });
  		  }
  		  else
        {
  			  fb_do_login();
        }
  		});

  		return false;
    });
  }

  function fb_do_login()
  {
	  FB.login(function(lResponse) {
      //console.log(lResponse);
 	    if (lResponse.authResponse)
     	{
// 	    	fb_save_info();
	    }
	    else
  		{
//	  		alert('You must accept the request permission to access the app');
      		//@todo: alert to user
	    }
    },
    {scope: '<?php echo implode(',', sfFacebookSDKWrapper::getInstance()->getAppRequiredPermission())?>'});
  }
</script>
<ul>
<input type="text" value="1193435953" id="in"/>
<li><a href="#" id="inviteBtn1">Invite ( by post to wall )</a></li>
<li><a href="#" id="inviteBtn2">invite ( send message to mailbox of facebook )</a></li>
<li><a href="#" id="inviteBtn3">invite ( request application )</a></li>
<?php include_partial('invite.js')?>
</ul>
</div>