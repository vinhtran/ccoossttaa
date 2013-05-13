<script type="text/javascript">
function submitPuzzleResult(puzzleStr, step, time)
{
	$.post(
		'<?php echo url_for('@service_validate_puzzle', true)?>',
		{s: step, t: time, up: puzzleStr},
		function(data) 
		{
			if (data.status == 1)
			{
				window.location.href = data.redirect_url;
			}
			else
			{
				window.location.href = data.error_404_url;
			}
		}
	);
}

function overTime()
{
	window.location.href = "<?php echo url_for('@fb_puzzle_played', true)?>";
}

function submitPlayed()
{
	$.post('<?php echo url_for('@service_played_puzzle', true)?>');
}

jQuery(document).ready(function() { 
	var pGame = new puzzleGame(
	  "#game",
	  "<?php echo nfPuzzleQRCodeWrapper::puzzleToString(sfConfig::get('app_puzzleGame_piecesName'))?>",
	  "<?php echo $randomPuzzle?>", 
	  "<?php echo public_path($qrCodePath)?>", 
	  "#timer"
	); 
});
</script>
