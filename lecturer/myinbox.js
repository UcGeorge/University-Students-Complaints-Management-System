
//MY inbox javascript codes

/*******  SIDENAV *******/

//1 when the user clicks on a circle it toggles between current and blank
	// 1.1 When the user clicks on a blank circle it becomes current
	//1.2 When the user clicks on a current circle it becomes blank 
	//NOTE: In a section you cant have more than one current circles


/****  status ***/
		
		var ccircle = document.getElementsByClassName('currentbcirc');
		var bcircle = document.getElementsByClassName('blankcircles');

 function togglecirc() {
	

	for (var i = 0; i < ccircle.length; i++) {
		
		if (event.target == ccircle[i]) {

			ccircle[i].className = ccircle[i].className.replace(" currentbcirc", "blankcircles");
		}

		else{
			break;
		}
		
		
	}
} 




//2 when a current circle is clicked the class that it contains shows while
// others hide 
	//2.1 After a circle is current get all the classes and remove the rest