//-----------------------------------------------------------------------------------------
const createOption = (course_code, course_name) => {
    console.log = ("red");
    const courseOpt = document.querySelector("#courseOptions");
    const tag = document.createElement("a");
    tag.href = `courseview.php?course=${course_code}&name=${course_code}`;
    tag.appendChild(document.createTextNode(course_code));
    courseOpt.appendChild(tag);
}
//---------------------------------------------------------------------------------------------------

const createCard = (course_title, course_code, active, personal) => {
    const courseSection = document.querySelector(".availcourse");
    
    const courseCard = document.createElement("a");
    courseCard.href = `courseview.php?course=${course_code}&name=${course_title}`;
    courseCard.classList.add("coursediv");

    const coursePic = document.createElement("div"); 
    coursePic.classList.add("coursepic");
    courseCard.appendChild(coursePic);

    //DETS
        const courseDets = document.createElement("div"); 
        courseDets.classList.add("coursedets");
        //courseCard.appendChild(courseDets);

        const p = document.createElement("p");
        const b = document.createElement("b");
        b.appendChild(document.createTextNode(course_title));
        p.appendChild(b);
        courseDets.appendChild(p);

        //coursewords1
        const courseWords1 = document.createElement("div"); 
        courseWords1.classList.add("coursewords");

        const span1 = document.createElement("span");
        span1.classList.add("ocircle");
        courseWords1.appendChild(span1);

        const span2 = document.createElement("span");
        span2.classList.add("onumber");
        span2.appendChild(document.createTextNode(active));
        courseWords1.appendChild(span2); 

        const span3 = document.createElement("span");
        span3.appendChild(document.createTextNode("Active Complaints"));
        courseWords1.appendChild(span3); 

        //coursewords2
        const courseWords2 = document.createElement("div"); 
        courseWords2.classList.add("coursewords");

        const span4 = document.createElement("span");
        span4.classList.add("bcircle");
        courseWords2.appendChild(span4);

        const span5 = document.createElement("span");
        span5.classList.add("bnumber");
        span5.appendChild(document.createTextNode(personal));
        courseWords2.appendChild(span5); 

        const span6 = document.createElement("span");
        span6.appendChild(document.createTextNode("Personal Complaints"));
        courseWords2.appendChild(span6); 
        //

        courseDets.appendChild(courseWords1);
        courseDets.appendChild(courseWords2);

        courseCard.appendChild(courseDets);

        courseSection.appendChild(courseCard);
    //

}

//--------------------------------------------------------------------------------------------------------------



    const logInMatric = 170805513;
    const logInPassword = "Test@123";
    // Create Header
    var myHeaders = new Headers();
    // Encode the username and password in base64
    var credentials = btoa(logInMatric + ':' + logInPassword);
    // Add it to the header
    myHeaders.append("Authorization", "Basic " + credentials);
    // Other header data
    myHeaders.append("Content-Type", "application/json");
    //Check hosting
    var student;
    fetch('http://localhost//University-Students-Complaints-Management-System/api/api/dashboard.php', {
        method: 'GET',
        headers: myHeaders
        //body: JSON.stringify({}) // For the dashboard API, nothing goes in the body.
    }) //Reeceiving info from api
    .then(response => response.json()) //converting info from json to object
    .then(info => {
        if (info.user.mat_no) {
            student = info;
            //document.location.href = "studentPage.html";
            //window.location = "studentPage.html";
            console.log(student);
            for (var i = 0; i < student.courses.length; i++) {
                //console.log("yes im here");
                var coursee = student.courses[i];
                createOption(coursee.course_code);
            }

            var active = 0;
            var personal = 0 ;
            for (var i = 0; i < student.courses.length; i++) {
                for (var j = 0; j < student.courses[i].complaints.length; j++) {
                    var courseee = student.courses[i];
                    // if (coursee.complaints[j].status == 'open') {
                    //     active++;
                    // }
                    // if (coursee.complaints[j].author == student.user.name) {
                    //     personal++;
                    // }
                }
                createCard(courseee.course_title, courseee.course_code, active, personal);
            }
        }
    });
