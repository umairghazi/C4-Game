function registerUser(){
    $("#submitRegister").disabled = true;
    registerAjax($("#username").val(),$("#password").val());
}

function registerCallback(jsonObj){
    if(jsonObj.registerStatus == true){
        $("#alertMessage").text("User Registered Successfully. Please login to continue.");
        window.location = "login.php";
    }
    else if(jsonObj.userExists == true){
        $("#alertMessage").text("Username already exists");
    }
}