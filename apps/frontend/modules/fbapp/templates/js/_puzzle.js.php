<script type="text/javascript">
function puzzle(wrapper,obj,result,timeBox) {
	var wrapper = wrapper,
		obj = obj,
		result = result,
		lastPiece = "",
		wp = 165,
		wrapper = jQuery(wrapper),
		resultArray = result.split(""),
		arrayLength = resultArray.length,
		_row = 2,
		_col = 2,
		countUp = 0,
		interval,
		timerBox = jQuery(timeBox),
		startStatus = 0;
		
	var start = function() {
		var imgs = "",
			lastImgClass = "",
			x = 0,
			y = 0,
			k = 0;
			
		// change piece's positions
		// maybe change to another way
		for(var i = 0; i < 6; i++) {
			var m = Math.floor(Math.random()*8),
				n = Math.floor(Math.random()*8),
				temp = "";
				
			temp = resultArray[m];
			resultArray[m] = resultArray[n];
			resultArray[n] = temp;
		}
		jQuery("#randomStr").html(resultArray.join());
		
		for(var i = 0; i < 3; i++) {
			y = i * wp;
			for(var z = 0; z < 3; z++) {
				x = z * wp;
				if(k == arrayLength-1) {
					lastImgClass = "LastPiece";
				}
				imgs+= '<img id="p' + k +'" class="Piece ' + lastImgClass + '" src="images/' + resultArray[k] + '.jpg" width="165" height="165" style="left: ' + x + 'px; top: ' + y + 'px; " />';
				k++;
			}
		}
		wrapper.html(imgs).children().click(changePiece);
		lastPiece = jQuery(".LastPiece").css({ opacity: 0.3 });
	}
	
	var changePiece = function() {
		
		if(startStatus == 0) {
			startTimer();
			startStatus++;
		}
		
		var piece = jQuery(this),
			position = parseInt(piece.attr('id').replace("p","")),
			newPosition = null,
			temp = "",
			row = piece.position().top / wp,
			col = piece.position().left / wp,
			currentStr = "";
	
		if (row == _row && col == _col + 1) {
			// Move left
			piece.animate({ left: "-=" + wp + "px" }, 100);
			lastPiece.animate({ left: piece.position().left + "px" }, 100);
			_col++;
			newPosition = position-1;
		}
		else if (row == _row && col == _col - 1) {
			// Move right
			piece.animate({ left: "+=" + wp + "px" }, 100);
			lastPiece.animate({ left: piece.position().left + "px" }, 100);
			_col--;
			newPosition = position+1;
		}
		else if (col == _col && row == _row + 1) {
			// Move up
			piece.animate({ top: "-=" + wp + "px" }, 100);
			lastPiece.animate({ top: piece.position().top + "px" }, 100);
			_row++;
			newPosition = position-3;
		}
		else if (col == _col && row == _row - 1) {
			// Move down
			piece.animate({ top: "+=" + wp + "px" }, 100);
			lastPiece.animate({ top: piece.position().top + "px" }, 100);
			_row--;
			newPosition = position+3;
		}
		
		if(newPosition != null) {
			temp = resultArray[newPosition];
			resultArray[newPosition] = resultArray[position];
			resultArray[position] = temp;
			piece.attr("id","p"+newPosition);
			//console.log(newPosition + " / " + position + " / " + resultArray);
		}
		
		currentStr = resultArray.join("");
		if(currentStr == result) {
			lastPiece.css({opacity:1});
			stopTimer();
			alert("Awesome! You are Superman!\nYour time: " + countUp + " seconds.");
		} else {
			//alert("Wrong");
		}
	}
	
	var startTimer = function() {
		clearInterval(interval);
		interval = setInterval(function() {
			countUp++;
			timerBox.html(countUp);
		},1000);
	}
	
	var stopTimer = function() {
		clearInterval(interval);
	}
	
	// init
	start();
}

jQuery(document).ready(function () {
	var pGame = new puzzle("#main",".Piece","ABCDEFGHL","#timer");
});
</script>