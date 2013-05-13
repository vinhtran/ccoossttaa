<div class="MbMainCont">
	<h1 class="MbHeadingSt MbHeadingStExt01">Dommage, </h1>
  <h2 class="MbHeadingSt02">ce QR code n'est pas gagnant...</h2>
  <p class="MbParaSt MbParaStExt02">Mais revenez demain<br /> pour tenter à nouveau votre chance</p>
  <div class="MbScWrap">
    <p class="MbParaSt01">Votre score aujourd'hui est de</p>
    <p class="MbHeadingSt03"><?php echo !empty($yourScore) ? $yourScore : 'N/A'?> secondes</p>
  </div>
  <div class="MbScWrap">
    <?php include_component('mobile', 'shareBlock')?>
  </div>
  <div class="MbBlockClasse">
    <p class="MbHeadingSt02">Classement des<br /> 5 meilleurs scores</p>
    <ul class="DefaultList MbListClasse">
    <?php 
      if (isset($topPlayers) && count($topPlayers)):
        foreach ($topPlayers as $rank => $player):?>
  	  <li class="Wrapper"><span class="Left"><?php echo ($rank + 1).'. '.$player['first_name'].' '.$player['last_name'] ?></span><span class="Right"><?php echo $player['number_of_second']?> s</span></li>
    <?php 
        endforeach;
      endif;?>
    </ul>
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