class Login {
	constructor() {
		this.state = {
			logInMatric: '',
			logInPassword: ''
		}
	}
	
	onMatricChange = event => {
		this.state.logInMatric = event.target.value;
		//console.log(event.target.value);
	}

	onPasswordChange = event => {
		this.state.logInPassword = event.target.value;
		//console.log(event.target.value);
	}

	onSubmitLogIn = () => {
		{ logInMatric, logInPassword } = this.state;
		console.log("submitting new student with email " + logInMatric);
		const matricEncode =  window.btoa(logInMatric);
		const passwordEncode =  window.btoa(logInPassword);
		//Check hosting
		fetch('http://localhost/phpmyadmin/script/login.php', {
			method: 'post',
			//headers: {'Content-Type' : 'application/json'},
			headers: {matricEncode : passwordEncode},
			body:JSON.stringify({
				email: logInMatric,
				password: logInPassword
			})
		}).then(response => response.json())
		.then(student => {
			if(student.matric) {
				var newStudent = new Dashboard(student);
				newStudent.loadStudent(student);				
				newStudent.onRouteChange('studentDashboard');
			}
		})
	}
}

var newStudent = new Login();

