<div class="MbMainCont">
	<div class="MbImgWrap">
	  <img src="<?php echo image_path('mobile-img.png', true)?>" width="473" height="388" alt="" title="" />
	</div>
  <h1 class="MbHeadingSt">encore bravo !</h1>
  <p class="MbParaSt MbParaStExt">Vos coordonnées ont bien été prises en compte.<br /> Vous allez recevoir sous peu un email de confirmation.</p>
  <p class="MbParaSt MbParaStExt01">Merci de votre participation</p>
  <div class="MbScWrap">
  	<?php include_component('mobile', 'shareBlock')?>
  </div>
</div>
<?php
  include_component(
    'facebookBase',
    'initScript',
    array(
      'lang' => 'fr_FR',
      'fbFuncName' => 'fb_share'
    )
  )?>