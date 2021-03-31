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
        // const matricEncode = window.btoa(logInMatric);
        // const passwordEncode = window.btoa(logInPassword);

        // Create Header
        var myHeaders = new Headers();
        // Encode the username and password in base64
        var credentials = btoa(logInMatric + ':' + logInPassword);
        // Add it to the header
        myHeaders.append("Authorization", "Basic " + credentials);
        // Other header data
        myHeaders.append("Content-Type", "application/json");
        //Check hosting
        fetch('http://localhost/api/api/dashboard.php', {
                method: 'GET',
                headers: myHeaders,
                body: JSON.stringify({}) // For the dashboard API, nothing goes in the body.
            })
            .then(response => response.json())
            .then(student => {
                if (student.mat_no) {
                    const tudent = new Dashboard(student);
                    window.location.replace('studentPage.html');
                    //document.location.href = "studentPage.html";
                    //window.location = "studentPage.html";
                }
            })
    }
}

var newStudent = new Login();