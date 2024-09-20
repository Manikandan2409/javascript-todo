function validateUserName(){
    const username = document.getElementById('username').value
        const usernameRegex = /^[a-zA-Z\s.]{3,}$/
    if (!usernameRegex.test(username)) {
        alert("Username must contain at least 3 characters, spaces, and dots allowed.")
        return false
    }else{
        console.log('Name success')
    }
    return true

}

function validatePassword() {
    const password = document.getElementById('signupPassword').value
    
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/
    if (!passwordRegex.test(password)) {
        alert("Password must be at least 6 characters long, contain one uppercase, one lowercase letter, and one special character.")
        return false
    }else{
        console.log('pass success')
    }
    return true
    
}

function validateEmail(){
    const email = document.getElementById('signupEmail').value
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
    if(!emailRegex.test(email)){
        alert("Invalid email")
        return false
    }
    else{
        console.log('email success')
    }
    return true
}

function validateSignupForm() {

    if(!validateUserName() ||  !validateEmail() || ! validatePassword()){
        return false
    }        
    return true
}



function togglePassword(id) {
    const input = document.getElementById(id);
    if (input.type === 'password') {
        input.type = 'text';
    } else {
        input.type = 'password';
    }
}

//  Calling API
document.getElementById('signupForm').addEventListener('submit', async function (e) {
    e.preventDefault();
    console.log("calling the API");

    if (validateSignupForm()) {
        const username = document.getElementById('username').value;
        const email = document.getElementById('signupEmail').value;
        const password = document.getElementById('signupPassword').value;

        try {
            const response = await fetch('http://localhost/tutorial/signup.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ username, email, password }),
            });

            const data = await response.json();

            if (response.ok) {
                alert('Signup successful!');
                alert(data)
            } else {
                alert('Signup failed: ' + data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred during signup.');
        }
    } else {
        alert("Invalid Credentials");
    }
});


