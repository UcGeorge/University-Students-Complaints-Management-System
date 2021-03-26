class Login {
	constructor() {
		this.state = {
			logInEmail: '',
			logInPassword: ''
		}
	}
	
	

	onEmailChange = event => {
		this.state.logInEmail = event.target.value;
		//console.log(event.target.value);
	}

	onPasswordChange = event => {
		this.state.logInPassword = event.target.value;
		//console.log(event.target.value);
	}

	onSubmitLogIn = () => {
		console.log("submitting new student with email " + this.state.logInEmail);

		fetch('login.php', {
			method: 'post',
			headers: {'Content-Type' : 'application/json'},
			body:JSON.stringify({
				email: this.state.logInEmail,
				password: this.state.signInPassword
			})
		}).then(response => response.json())
		.then(student => {
			if(student.matric) {
				loadStudent(student);
				onRouteChange('studentDashboard');
			}
		})
	}
}

var newStudent = new Login();