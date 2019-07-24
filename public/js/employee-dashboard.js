$(document).ready(function(){

		switch(localStorage.getItem('task_type')) {
		  case 'upload':
		    $('#upload_package_employee').modal({
					backdrop: 'static',
    				keyboard: false,
				});

		    break;
		  case 'support':
		   	$('#support_employee_modal').modal({
					backdrop: 'static',
    				keyboard: false,
				});
		    break;
		  case 'bathroom':
		   	$('#bathroom_employee_modal').modal({
					backdrop: 'static',
    				keyboard: false,
				});
		    break;
		  case 'cleanUp':
		   	$('#clean_up_employee_modal').modal({
					backdrop: 'static',
    				keyboard: false,
				});
		    break;
		  case 'break':
		   	$('#break_employee_modal').modal({
					backdrop: 'static',
    				keyboard: false,
				});
		    break;

		    
		  default:
		  //remainingTimeDashboard();
		    // code block

		    showRemainingTime(gs_window.remaining_time);
		}
});



	function startCountDown(time,class_name='remaing_time_select',logout='yes')
	{
		delay_start_time = getCurrentDateTime();

		let minRemain = 0;
		let secsRemain = 0;
		setInterval(function () {

			//5/4/3/2/1 minutes and 10/5 seconds
			if(time==300 || time==240 || time==180 || time==120 || time==60 || time==10 || time==5)
			{
				 let audio_time = Math.floor(time / 60);
				 var audio;
				 //10 and 5 seconds audio files
				 if(time==10 || time==5)
				 	audio = new Audio(gs_window.asset_audio_url+'/'+time+'_seconds_remaining.mp3');
				 else
				 	//5-4-3-2-1 minutes audio files
				 	audio = new Audio(gs_window.asset_audio_url+'/'+audio_time+'_minutes_remaining.mp3');

              	audio.play();
			}


			time--;
		
			minRemain  = Math.floor(time / 60);

			secsRemain = new String(time - (minRemain * 60));
			clock      = pad(minRemain) + ":" + pad(secsRemain);

		if ( time > 0 ) {

					$('.'+class_name).html(clock);
			}
		else
		{
			$('.'+class_name).html('00:00');

			if(logout=='yes')
			{
				$('#delay_reason_model').modal({
					backdrop: 'static',
    				keyboard: false,
				});
			}

		}
	},1000);

	}


function remainingTimeDashboard(){
	
		secs       =  '30';
	    if(secs> 0) {
	      setTimeout("countdown('.remaing_time_select',"+secs+")", 1000);

	      delay_start_time = getCurrentDateTime();
	    }
	}



 function countdown(class_name, time){
        time--;
        minRemain  = Math.floor(time / 60);
        secsRemain = new String(time - (minRemain * 60));
        clock      = pad(minRemain) + ":" + pad(secsRemain);

        if(localStorage.getItem('count_time') != 'type_change'){
	        if ( time > 0 ) {
	        	//console.log('kkk');
	            $(class_name).html(clock);
	            setTimeout("countdown('" + class_name + "'," + time + ")", 1000);
	            localStorage.setItem('count_time', time);
	        } 
	        else {
	        	//console.log('jjjj');
	            $(class_name).html(clock);

	           
	           /*localStorage.setItem('delay_time', delay_time);*/

	          	$('#delay_reason_model').modal({
					backdrop: 'static',
    				keyboard: false,
				});
	          	//alert('Timer Completed :)');
	        }
    	}else{
    		 $(class_name).html('00:30');
    	}
    }


/*function startTimeCount()
{
	setTimeout("countTime('.remaing_time_select',0)", 1000);
}*/

 function countTime(){
 		var time = 0;

        setInterval(function () {
        	let clock      =  pad(parseInt(time / 60, 10))+ ":" +pad(new String(++time % 60));
		    document.querySelector(".remaing_time_select").innerText 	= clock;
		}, 1000);
    }


    function pad(d) {
	    return (d < 10) ? '0' + d.toString() : d.toString();
	}

function showRemainingTime(time_remaining){
		//console.log(time_remaining);
		
		setInterval(function () {
		let hoursRemaining 	= Math.floor(time_remaining / 3600);

		//console.log(hoursRemaining);
		let minRemainInsec 	= Math.floor(time_remaining - (hoursRemaining * 3600));
 
        let minRemain  		= Math.floor(minRemainInsec / 60);
       
        let secsRemain 		= new String(time_remaining - (hoursRemaining * 3600)-(minRemain * 60));
        let clock      		= pad(new String(hoursRemaining)) + ":" + pad(new String(minRemain)) + ":" + pad(secsRemain);

	
	    document.getElementById("MyClockDisplay").innerText 	= clock;
	    document.getElementById("MyClockDisplay").textContent 	= clock;

		time_remaining--;

	},1000);
	    /*setTimeout(function(){
	     showRemainingTime(time_remaining);
	    }, 1000);*/
	    
	}

function getCurrentDateTime()
	{
		//return new Date().toISOString().slice(0, 19).replace('T', ' ');
		let date 	= new Date();
		let h 		= date.getHours(); // 0 - 23
	    let m 		= date.getMinutes(); // 0 - 59
	    let s 		= date.getSeconds(); // 0 - 59

	    let Y 		= date.getFullYear();
	    let M 		= date.getMonth();
	    let D 		= date.getDate();

		return Y+':'+M+':'+D+' '+ h + ":" + m + ":" + s;
	}

function getCurrentTime()
	{
		var date 	= new Date();
	    var h 		= date.getHours(); // 0 - 23
	    var m 		= date.getMinutes(); // 0 - 59
	    var s 		= date.getSeconds(); // 0 - 59
	    var session = "AM";
	    
	    if(h == 0){
	        h = 12;
	    }
	    
	    if(h > 12){
	        h = h - 12;
	        session = "PM";
	    }
	    
	    h = (h < 10) ? "0" + h : h;
	    m = (m < 10) ? "0" + m : m;
	    s = (s < 10) ? "0" + s : s;
	    
	    return time = h + ":" + m + ":" + s + " " + session;
	}

function LocalStorageClear(){
		localStorage.clear();
	}

