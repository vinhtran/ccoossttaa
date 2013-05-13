<script type="text/javascript">
<?php $facebookVars = $sf_data->getRaw('facebookVars')?>

function fb_share()
{
	$('#shareTWBtn').click(function() {
		var width = 500;
		var height = 400;
		window.open(
		  $(this).attr('href'), 
			'Nokia Lumia puzzle code', 
			'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, copyhistory=no, '
			+ 'width=' + width + ', height=' + height + ', '
			+ 'top=' + ((window.screen.height/2) - (height/2)) + ', left=' + ((window.screen.width/2) - (width/2))
		);
		return false;
	});
	
	$('#shareFBBtn').click(function() {
		var obj = {
      method: 'feed',
      <?php foreach ($facebookVars as $property => $value):?>
        <?php echo $property.': "'.$value.'",'."\n"?>
      <?php endforeach;?>
      display: 'popup'
    };

    function callback(response) 
    {
      //document.getElementById('msg').innerHTML = "Post ID: " + response['post_id'];
    }

    FB.ui(obj, callback);
  });
}
</script>