function loginUser(){
    $("#submitLogin").disabled = true;
    loginAjax($("#username").val(),$("#password").val());
}

function loginCallback(jsonObj){
    if(jsonObj.validUser == true){
        SetCookie("token",jsonObj.token);
        SetCookie("username",jsonObj.username);
        makeUserActiveAjax(jsonObj.username);
    }
    else{
        $("#alertMessage").text("Incorrect Username/Password.");
    }
}

function makeUserActiveCallback(jsonObj){
    if(jsonObj.updateStatus == true){
        window.location.href = 'lobby.php';
    }
}