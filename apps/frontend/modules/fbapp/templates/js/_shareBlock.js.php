<script type="text/javascript">
<?php $facebookVars = $sf_data->getRaw('facebookVars')?>

function fb_share()
{
	$('#shareTWBtn').click(function() {
		var width = 600;
    var height = 400;
    var left = Math.floor((screen.availWidth - width) / 2);
    var top = Math.floor((screen.availHeight - height) / 2);
    var windowFeatures = "width=" + width + ",height=" + height +
            ",menubar=no,toolbar=no,location=no,directories=no,status=no,copyhistory=no,scrollbars=no,resizable=yes," +
            "left=" + left + ",top=" + top +
            "screenX=" + left + ",screenY=" + top;

		window.open($(this).attr('href'), 'Sharing_on_Twitter', windowFeatures, false);
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