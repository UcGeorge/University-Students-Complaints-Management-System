const initialState = {
	student: {
		matric_no: '',
		email: '',
		name: '',
		courses: [],
	},
	route: 'login',
	// isLoggedIn: false
}

class Dashboard {
	state = initialState;
	
	constructor(data) {
		this.state.student = data;
		this.state.route = 'dashboard';
	}

	addName = () => {
		const studentName = document.querySelector("#name");
		studentName.appendChild(document.createTextNode(this.state.student.name));
	}

	createCourseCard = () => {
		const courses = document.querySelector("#courses");
		const courseCard = document.createElement("div");
		courseCard.classList.add("course-card");
		// if(courseImg) {
		// 	const courseImg = document.createElement("img");
		//  courseImg.classList.add("img-responsive");
		// 	courseImg.src = "https://vlearn.unilag.edu.ng/pluginfile.php/1/theme_lambda/logo/1612453226/android-chrome-192x192.png";	
		//  course-card.appendChild();
		// }
		const details = document.createElement("div");
		details.classList.add("course-card-details");
		
		const courseName = document.createElement("h2");
		courseName.appendChild(document.createTextNode("some-course"))

		const activeComplaints = document.createElement("p");
		activeComplaints.classList.add("active_compaints");
		activeComplaints.appendChild(document.createTextNode("active"))
		
		const personalComplaints = document.createElement("p");
		personalComplaints.classList.add("personal_compaints");
		personalComplaints.appendChild(document.createTextNode("personal"))

		details.appendChild(courseName);
		details.appendChild(activeComplaints);
		details.appendChild(presonalComplaints);

		courseCard.appendChild(details);
		courses.appendChild(courseCard);
	}

	// addCourses = () => {

	// }

	// addingStudentData = () => {
	// 	addName();
	// 	createCourseCard(); 
	// 	addCourses();
	// }
}