<div class="DkMain DkMainExt">
  <div class="DkBlockRight">
    <p class="BlocktxtExt">pour savoir si vous <br />avez gagné un Nokia lumia <span>flashez ce qr code <a href="javascript:void(0);" id="flashGuide"></a></span></p>
    <div class="Hidden">
    	<div id="flashGuidePopupContent" style="width: 400px;">
        <h2>Afin de flasher ce QR code</h2><br/>
        <p>Téléchargez gratuitement une application flashcode en tapant <a href="http//tc3.fr" target="_blank">tc3.fr</a> dans le navigateur de votre mobile.</p>
        <p>ou</p>
        <p>Utilisez le service SMS gratuit; en envoyant "flashcode" au 30130 (coût d'un SMS non surtaxé - coût variable selon votre opérateur),</p>
        <p>Vous recevrez par SMS un lien de téléchargement vous permettant d'installer la version du lecteur de flashcode/ QRcode compatible avec votre terminal mobile.</p>
			</div>
    </div>
    <div class="DkGameShow">
      <div id="gameBox"><div id="game"><img src="<?php echo public_path($resultImageURL.'?'.time(), true)?>" width="225" height="225" alt="game" /></div></div>
    </div>
    <div class="DkBlockInfo DkMarTop01">
      <p class="DkAvarta"><img src="<?php echo image_path('img-avarta.png', true)?>" width="111" height="156" alt="" /></p>
      
      <?php include_component('fbapp', 'inviteBlock')?>
      
    </div>
  </div>

  <?php include_partial('nokiaLogo')?>   
</div>
<?php include_partial('puzzleEnd.js')?>

