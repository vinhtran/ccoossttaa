<div class="DkMain">
  <div class="DkBlockRight">
    <h1 class="Dktxt02">Nokia Lumia</h1>
    <h2 class="Dktxt03">Puzzle Code</h2>
    <p class="Blocktxt">Reconstituez le plus rapidement votre QR code en faisant glisser les pièces du puzzle.</p>
    <div class="DkGameShow">
      <div id="gameBox"><div id="game"></div></div>
      <div class="DkVotreHour">
        <p class="DktxVotre">votre score</p>
        <p class="DktxtHour" id="timer">0:00</p>
      </div>
    </div>
    <div class="DkThumbGame">
    	<p class="BoderAvarta"><img src="<?php echo public_path($qrCodePath.'.png?'.time(), true)?>" width="75" height="75" align="absmiddle" alt="" /></p>Modèle à reconstituer.
    </div>

    <?php include_component('fbapp', 'topPlayers', array('parentClass'=> 'DkClasseMent'))?>

  </div>

  <?php include_partial('nokiaLogo')?>

</div>
<?php include_partial('puzzleGame.js', array('randomPuzzle' => $randomPuzzle, 'qrCodePath' => $qrCodePath))?>

<?php 
//@todo must remove these code lines
/*echo '
<script type="text/javascript">

alert("'.str_replace(array('T', 'B', 'L', 'R'), array('B', 'T', 'R', 'L'), $steps).'");
</script>';
*/?>
