<script type="text/javascript">
function fb_invite()
{
	$('#inviteBtn').click(function() {
		var width = 600;
    var height = 400;
    var left = Math.floor((screen.availWidth - width) / 2);
    var top = Math.floor((screen.availHeight - height) / 2);
    var windowFeatures = "width=" + width + ",height=" + height +
    				",menubar=no,toolbar=no,location=no,directories=no,status=no,copyhistory=no,scrollbars=no,resizable=yes," +
            "left=" + left + ",top=" + top +
            "screenX=" + left + ",screenY=" + top;

		window.open($(this).attr('href'), 'Invite_Facebook', windowFeatures);
		return false;
	});
}
</script>