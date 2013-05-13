<div class="DkHeader">
  <div class="FRight">
  	<p class="Dktxt01 FLeft">partager</p><a href="javascript:void(0);" id="shareFBBtn"><img src="<?php echo image_path('ico-face.png', true)?>" alt="facebook" /></a><a id="shareTWBtn" href="https://twitter.com/share?<?php echo $twitterShareConfig?>"><img src="<?php echo image_path('ico-twiter.png', true)?>" alt="twitter" /></a>
  </div>
</div>
<?php include_partial('shareBlock.js', array('facebookVars' => $facebookVars))?>
