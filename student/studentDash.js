// General JS for pages


//1. Create a course Dropdown on mouse over
	

		var dropdown = document.getElementsByClassName('dropdown')[0].style;

		//1.1 Show the hidden div
		function mOver() {
			
				dropdown.display = "block";
		
			
		}
		

		//1.2 hide the div after mouse is outside element
		function mOut() {
			dropdown.display = "none";
		}
		
	
	



// 2. Create a toggle search input on mouse over
	var hoverinput = document.getElementsByClassName('hoverinput')[0].style;

		//2.1 Show the hidden div
		function hOver() {
			
				hoverinput.display = "inline-block";
		
			
		}
		

		//2.2 hide the div after mouse is outside element
		function hOut() {
			hoverinput.display = "none";
		}



// 3. Create a user Dropdown
	var triangle = document.getElementsByClassName("userdrop")[0].style;

	function showhide() {
	// 3.1 When the element is clicked the user dropdown shows

		if (triangle.display == "none" || triangle.display == "") {
			triangle.display = "block";
		}
	// 3.2 When the element is clicked  the user dropdown hides
	// 

		else{
			
			triangle.display = "none";
		}


	
	}


	