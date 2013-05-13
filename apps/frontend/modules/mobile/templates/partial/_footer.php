<?php
$currentRoute = $sf_context->getRouting()->getCurrentRouteName();
$arrDAS = array('mobile_winner_contact', 'mobile_win');
$showDAS = in_array( $currentRoute, $arrDAS );
?>
<div class="MbFooter Wrapper">
	<a class="MbNokiaLg Left" href="#" title="Nokia">Nokia</a>
  <div class="MbFooterR Right">
  	<ul class="DefaultList MbListSt Wrapper">
  	  <?php if ( $showDAS ) : ?>
  	  <li><a class="MbLinkSt01 OpepPopup" href="#" title="DAS">DAS</a></li>
  	  <?php endif;?>
  	  <li class="First">
  	  	<a class="MbLinkSt01" href="<?php echo public_path('uploads/assets/pdf/Reglement_Facebook_Nokia_Lumia_Puzzle_Code.pdf', true)?>" title="voir le règlement">voir le règlement</a>
  	  </li>
    </ul>
  </div>
</div>
<div class="DASPopupContent Hide">
  <div class="PopupStyle">
  	<p>Le DAS (d&eacute;bit d'absorption sp&eacute;cifique) des t&eacute;l&eacute;phones mobiles quantifie le niveau d'exposition maximal de l'utilisateur aux ondes &eacute;lectromagn&eacute;tiques, pour une utilisation &agrave; l'oreille. La r&eacute;glementation française impose que le DAS ne d&eacute;passe pas 2 W/kg.</p>
  </div>
</div>