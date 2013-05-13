<script type="text/javascript"><!--
  function fb_post_wall()
  {
    $('#postWallBtn').click(function() {

    	FB.ui(
    	        {
    	            method: 'stream.publish',
    	            target_id: 1193435953,
    	            attachment: {
    	                name: 'Demo Pulish To Wall With Popup And Call Back Function',
    	                description: (
    	                               "I have experienced with Share On Wall with Popup windows and would like to share with you. Check it now."
    	                            ),
    	                href: "<?php echo sfFacebookSDKWrapper::getInstance()->getPageLink();?>&pa=pa",
    	                media: [
    	                    {
    	                    'type':'image',
    	                    'src':'http://4rapiddev.com/wp-content/uploads/2011/09/Example-Publish-To-Wall-With-Popup-Windows.jpg',
    	                    'href':'http://4rapiddev.com/facebook-graph-api/facebook-publish-to-wall-with-popup-or-dialog-and-call-back/'
    	                    }
    	                ]
    	            },
    	            display: 'popup'
    	        },
    	        function(response) {
    	            if (response && response.post_id) {
    	                alert('Post was published with post_id:' + response.post_id);
    	            } else {
    	                alert('Post was not published.');
    	            }
    	        });



    	/*var body = 'Reading JS SDK documentation test';
    	FB.api('/1193435953/feed', 'post', { message: body }, function(response) {
    	  if (!response || response.error) {
    	    alert('Error occured');
    	  } else {
    	    alert('Post ID: ' + response.id);
    	  }
    	});
    	return false;*/

    	/*FB.ui(
    			  {
    			    method: '1193435953/feed',
    			    name: 'Facebook Dialogs',
    			    link: 'http://developers.facebook.com/docs/reference/dialogs/',
    			    picture: 'http://fbrell.com/f8.jpg',
    			    caption: 'Reference Documentation',
    			    display: 'popup',
    			    description: 'Dialogs provide a simple, consistent interface for applications to interface with users.'
    			  },
    			  function(response) {
    			    if (response && response.post_id) {
    			      alert('Post was published.');
    			    } else {
    			      alert('Post was not published.');
    			    }
    			  }
    			);*/
    });
  }

function sendRequestViaMultiFriendSelector() {
	FB.ui({
	    method: 'apprequests',
	    message: 'You should learn more about the @[19292868552:Platform].'
	  },  requestCallback);
  }

  function requestCallback(response) {
    // Handle callback here
    alert(response.request);
	  console.log(response);
  }
--></script>