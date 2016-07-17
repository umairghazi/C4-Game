function getOnlineUsers() {
    ajaxCall('GET', {method: "getOnlineUsers", a: "lobby", data: username}, onlineUsersHandler);
}

function onlineUsersHandler(data, status) {
    var list = "";
    if (data) {
        for (var i = 0; i < data.length; i++) {
            list += "<div onclick='challengePlayer(\"" + data[i].name + "\")'>" + data[i].name + '</div><br/>';
        }
        $("#userList").html(list);
        setTimeout("getOnlineUsers()", 1000);
    } else {
        setTimeout("getOnlineUsers()", 1000);
    }

}


function challengePlayer(playerId) {
    showDialog({
        title: 'Challenge Player?',
        text: 'Do you want to challenge this player for a match?',
        negative: {
            title: 'No'
        },
        positive: {
            title: 'Yes',
            onClick: function (e) {
                var challengeDetails = username + "|" + playerId;
                ajaxCall('GET', {method: "challengePlayer", a: "lobby", data: challengeDetails}, challengeHandler);

            }
        }
    });

}

function challengeHandler(data, status) {
    if (data.gameId > 0) {
        loc = "game.php?player=" + username + "&gameId=" + data.gameId;
        window.location = loc;
    } else if (data.gameId < 0) {
        showDialog({
            title: 'Challenge Rejected.',
            text: 'The opponent has rejected your challenge :(',
            negative: {
                title: 'Cancel',
                onClick: function (e) {
                    window.location = "lobby.php";
                }
            }
        });
    }
}

function checkForChallenge() {
    ajaxCall('GET', {method: "checkChallenges", a: "lobby", data: username}, checkForChallengeHandler);
}

function checkForChallengeHandler(data, status) {
    if (data.gameId != 0) {


        showDialog({
            title: 'Incoming challenge?',
            text: data.player1 + ' has challenged you for a match.',
            negative: {
                title: 'Reject',
                onClick: function (e) {
                    var challengeDetails = username + "|" + data.gameId;
                    ajaxCall('GET', {method: "rejectChallenge", a: "lobby", data: challengeDetails}, challengeHandler);
                }
            },
            positive: {
                title: 'Accept',
                onClick: function (e) {
                    var challengeDetails = username + "|" + data.gameId;
                    ajaxCall('GET', {method: "acceptChallenge", a: "lobby", data: challengeDetails}, challengeHandler);
                }
            }
        });

    } else {
        setTimeout("checkForChallenge()", 1000);
    }
}