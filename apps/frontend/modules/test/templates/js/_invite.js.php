<script type="text/javascript">
  function fb_invite()
  {
    $('#inviteBtn1').click(function() {

    	FB.ui(
        {
            method: 'stream.publish',
            target_id: $('#in').val(),
            attachment: {
                name: 'Demo Pulish To Wall With Popup And Call Back Function',
                description: (
                               "I have experienced with Share On Wall with Popup windows and would like to share with you. Check it now."
                            ),
                href: "<?php echo sfFacebookSDKWrapper::getInstance()->getPageLink();?>",
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
//            	inviteCallback();
                alert('Post was published with post_id:' + response.post_id);
            }
        });


    });

    $('#inviteBtn2').click(function() {
    	FB.ui({
        method: 'send',
        name: 'People Argue Just to Win',
        link: '<?php echo url_for('@homepage', TRUE);?>',
        display: 'popup'
        }, function (response) {
					console.log(response);
      });

    	return false;
    });

    $('#inviteBtn3').click(function() {

    	FB.ui({
    	    method: 'apprequests',
    	    message: 'Invitation',
        	display: 'popup'
    	  },  inviteCallback);
    	return false;
    });
  }

  function inviteCallback() {
    // Send ajax request to tracking invitation
//    $.post("<?php echo url_for('service/invitationTracking');?>", { invitee_id: 1193435953 } );
  }
</script>