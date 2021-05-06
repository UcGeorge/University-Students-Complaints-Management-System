const initialState = {
	student: {
		mat_no: '',
		name: '',
		department: '',
		year: '',
		password: '',
	},
	courses: [],
	route: 'login',
	type: ''
	// isLoggedIn: false
}

class Dashboard {
	
	let state = initialState;
	
	constructor(data) {
		this.state.route = 'dashboard';
		this.state.student.mat_no = data.user.mat_no;
		this.state.student.name = data.user.name;
		this.state.department = data.user.department;
		this.state.student.year = data.user.year;
		this.state.courses = data.courses;
	}


	addName = () => {
		const studentName = document.querySelector("#name");
		studentName.appendChild(document.createTextNode(this.state.student.name));
	}

	createCourseCard = (course_name, course_img, active, personal) => {
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

	addCourseCard() {
		for (var i = 0; i < this.state.courses.length; i++) {
			createCourseCard();
		}
	}
	// addCourses = () => {

	// }

	// addingStudentData = () => {
	// 	addName();
	// 	createCourseCard(); 
	// 	addCourses();
	// }
}