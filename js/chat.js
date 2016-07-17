function getChat() {
    ajaxCall('GET', {method: "getChat", a: "lobby", data: gameId}, chatHandler)
}

function chatHandler(chat, status) {
    var messages = "";
    for(var i = 0; i < chat.length; i++) {
        messages+= "<div id='msg-whole'><span class='chat-username'>" + chat[i].name + ':</span><span class = "message-text"> ' + chat[i].message + '</span><span class="message-time">' + chat[i].timeStamp + '</span></div>';
        document.getElementById('chatMessages').scrollTop = document.getElementById('chatMessages').scrollHeight;


    }
    //console.log("chat"+messages);
    $("#chatMessages").html(messages);
    setTimeout("getChat()", 1000);
    // document.getElementById('chatMessages').scrollTop = document.getElementById('chatMessages').scrollHeight;
}

function sendChat() {
    var chatMessage = document.getElementById("newChatMessage").value;
    if (chatMessage == "" || chatMessage == null) {
        console.log("no chat message");
        //@TODO - Use a Tooltip here
    }
    else {
        var chatText = username + "|" + chatMessage + "|" + gameId;
        ajaxCall('POST', {method: "sendChat", a: "lobby", data: chatText}, null);
        document.getElementById("newChatMessage").value = "";
    }
}


$('#newChatMessage').on('keypress', function (event) {
    if(event.which === 13){

        //Disable textbox to prevent multiple submit
        $(this).attr("disabled", "disabled");
        sendChat();
    }
});