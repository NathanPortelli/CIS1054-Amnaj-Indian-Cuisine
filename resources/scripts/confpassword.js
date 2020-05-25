var password = document.getElementById("password");
var confirmpassword = document.getElementById("confirmpassword");

function validatePassword(){
    if(password.value.localeCompare(confirmpassword.value) != 0) {
        password.setCustomValidity("");
        confirmpassword.setCustomValidity("Passwords don't match");
    } else if (password.value.length < 8){
        console.log(password.value.length);
        password.setCustomValidity("Password must be at least 8 characters long!");
        confirmpassword.setCustomValidity("");
    } else if (!/[a-z]/g.test(password.value)){
        password.setCustomValidity("Password must contain at least 1 small letter!");
    } else if (!/[A-Z]/g.test(password.value)){
        password.setCustomValidity("Password must contain at least 1 capital letter!");
    } else if (!/[0-9]/g.test(password.value)){
        password.setCustomValidity("Password must contain at least 1 number!");
    } else {
        password.setCustomValidity("");
        confirmpassword.setCustomValidity("");
    }

    try{
        oldpassfield = document.getElementById("oldpass");
        if (oldpassfield.value.length == 0){
            oldpassfield.setCustomValidity("This cannot be empty");
        }
    }
    catch(err){
    }
}

password.onchange = validatePassword;
confirmpassword.onkeyup = validatePassword;