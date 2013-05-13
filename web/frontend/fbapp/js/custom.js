function fb_resize_event()
{
//	FB.Canvas.setAutoGrow(); 
	FB.Canvas.setSize();
}

function puzzleGame(wrapper,result,init,path,timeBox) {
	var wrapper = wrapper,
		obj = ".Piece",
		path = path,
		result = result,
		init = init,
		lastPiece = "",
		wp = 75,
		limitTime = 3600, // 60 minutes
		wrapper = jQuery(wrapper),
		resultArray,
		arrayLength,
		_row = 2,
		_col = 2,
		countUp = 0,
		timeStr = "0:00",
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
		/*
		for(var i = 0; i < 10; i++) {
			var m = Math.floor(Math.random()*9),
				n = Math.floor(Math.random()*9),
				temp = "";
				
			temp = resultArray[m];
			resultArray[m] = resultArray[n];
			resultArray[n] = temp;
		}
		*/
		/*var randomStr = [
			"CHDAEFBGL",
			"GECAHFDBL",
			"CHABDFGEL",
			"EGCDBAFHL",
			"HCGDAEFBL",
			"CBGAEDFHL",
			"HDCAEGFBL",
			"GBADEFCHL",
			"EFDHBCGAL",
			"EHBAFCGDL"
		], randomIndex = Math.floor(Math.random() * (randomStr.length-1));
		
		resultArray = randomStr[randomIndex].split("");
		arrayLength = resultArray.length;
		*/
		resultArray = init.split("");
		arrayLength = resultArray.length;
		
		var currentTime = new Date();
		
		for(var i = 0; i < 3; i++) {
			y = i * wp;
			for(var z = 0; z < 3; z++) {
				x = z * wp;
				if(k == arrayLength-1) {
					lastImgClass = "LastPiece";
				}
				imgs+= '<img id="p' + k +'" class="Piece ' + lastImgClass + '" src="' + path + '/' + resultArray[k] + '.png?' + currentTime.getTime() + '" width="' + wp + '" height="' + wp + '" style="left: ' + x + 'px; top: ' + y + 'px; " />';
				k++;
			}
		}
		window.step = '';
		wrapper.html(imgs).children().draggable({
			cursor: 'move',
			revert: "invalid",
			helper: 'clone',
			stop: cbDragStop
		}).droppable({
			activeClass: "ui-state-hover",
			drop: cbDropEvent
		});
	}
	
	var cbDragStop = function( event, ui ) {
		if(startStatus == 0) {
			startTimer();
			startStatus++;
			submitPlayed();
		}
	}
	var cbDropEvent = function( event, ui ) {
		var draggable = ui.draggable,
			droppable = jQuery(this),
			fisrtPosition = parseInt(draggable.attr('id').replace("p","")),
			secondPosition = parseInt(droppable.attr('id').replace("p","")),
			fisrtTop = Math.round(draggable.position().top),
			fisrtLeft = Math.round(draggable.position().left),
			secondTop = Math.round(droppable.position().top),
			secondLeft = Math.round(droppable.position().left);
			
		draggable.animate({ left: secondLeft, top: secondTop }, 500);
		droppable.animate({ left: fisrtLeft, top: fisrtTop }, 500);
		if(secondPosition != null) {
			var temp = resultArray[secondPosition];
			resultArray[secondPosition] = resultArray[fisrtPosition];
			resultArray[fisrtPosition] = temp;
			draggable.attr("id","p" + secondPosition);
			droppable.attr("id","p" + fisrtPosition);
			window.step += fisrtPosition + '_' + secondPosition + '|';
			//console.log(secondPosition + " / " + fisrtPosition + " / " + resultArray);
		}
		
		var currentStr = resultArray.join("");
		if(currentStr == result) {
			stopTimer();
			wrapper.children().draggable({
				disabled: true
			}).droppable({
				disabled: true
			});
			
			// can remove this.
			/*setTimeout(function() {
				alert("Awesome! You are Superman!\nYour time: " + countUp + " seconds.");
			},2000);*/
			submitPuzzleResult(currentStr, window.step.substr(0, window.step.length - 1), countUp);
		} else {
			//alert("Wrong");
		}
		//alert("A: " + draggable.attr("id") + " - B: " + droppable.attr("id"));
		
	}
	
	var startTimer = function() {
		clearInterval(interval);
		interval = setInterval(function() {
			countUp++;
			if(countUp > limitTime) {
				stopTimer();
				// disable drag
				wrapper.children().draggable({
					disabled: true
				}).droppable({
					disabled: true
				});
				overTime();
			}
			var minute = Math.floor(countUp / 60),
				second = countUp % 60;
			if(second < 10) {
				timeStr = minute + ":0" + second;
			} else {
				timeStr = minute + ":" + second;
			}
			timerBox.html(timeStr);
		},1000);
	}
	
	var stopTimer = function() {
		clearInterval(interval);
	}
	
	// init
	start();
}