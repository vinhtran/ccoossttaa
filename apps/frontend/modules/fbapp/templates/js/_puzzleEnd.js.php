<script type="text/javascript">
$(document).ready(function() {
	jQuery("#flashGuide").colorbox(
	{
		onComplete: function() {
			jQuery('#cboxClose').fadeIn();
		},
		html: jQuery("#flashGuidePopupContent").parent().html()
	})
	.mouseover(function() {
		$(this).click();
	});
});
</script>