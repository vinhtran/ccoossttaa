<div class="DkMain DkMainExt">
<div class="DkBlockRight">
  <h1 class="Dktxt06">votre participation a déjà <br />été prise en compte aujourd’hui</h1>
  <div class="DkBlockInfo">
    <p class="DkAvarta"><img src="<?php echo image_path('img-avarta.png', true)?>" width="111" height="156" alt="" /></p>
    
    <?php include_component('fbapp', 'inviteBlock')?>
    
  </div>
  <div class="DkBlockTitle">
    <p class="Dktxt07">revenez demain pour tenter votre chance et</p>
    <p class="Dktxt08">figurer dans le classement des 5 meilleurs scores</p>
    <?php if (!empty($yourScore)):?>
    <p class="Dktxt09">votre dernier score est de :</p>
    <p class="Dktxt10"><?php echo $yourScore?> secondes</p>
    <?php endif;?>
  </div>
  
  <?php include_component('fbapp', 'topPlayers', array('parentClass'=> 'DkClasseMentExt'))?>
  
  </div>

  <?php include_partial('nokiaLogo')?>
</div>

