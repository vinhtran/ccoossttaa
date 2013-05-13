<div class="<?php echo $parentClass?>">
 	<div class="DkTitleClasse"><p class="DkTxtClasse">Classement des <br />5 meilleurs scores</p></div>
  <ul class="DkListClasse">
  <?php 
    if (isset($topPlayers) && count($topPlayers)):
      foreach ($topPlayers as $rank => $player):?>
  	<li><span class="FLeft"><?php echo ($rank + 1).'. '.$player['first_name'].' '.$player['last_name'] ?></span><span class="FRight"><?php echo $player['number_of_second']?> s</span></li>
  <?php 
      endforeach;
    endif;?>
  </ul>
</div> 	  
