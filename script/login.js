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
		const { logInMatric, logInPassword } = this.state;
		console.log("submitting new student with email " + logInMatric);
		const matricEncode =  window.btoa(logInMatric);
		const passwordEncode =  window.btoa(logInPassword);
		//Check hosting
		fetch('http://http://localhost/api/api/dashboard.php', {
			method: 'post',
			//headers: {'Content-Type' : 'application/json'},
			headers: {'Authorization' : matricEncode : passwordEncode},
			body:JSON.stringify({
				mat_no: logInMatric,
				password: logInPassword
			})
		}).then(response => response.json())
		.then(student => {
			if(student.mat_no) {
				const tudent = new Dashboard(student);
				window.location.replace('studentPage.html');
				//document.location.href = "studentPage.html";
				//window.location = "studentPage.html";
			}
		})
	}
}

var newStudent = new Login();

