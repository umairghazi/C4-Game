# Connect 4 Game

A turn based Connect 4 game built with PHP and mySQL on backend
and JavaScript, jQuery and SVG on frontend.

##### Features

1. Follows a service-oriented architecture, where the client makes
request to the middleware at **mid.php** which forwards the request
to the appropriate service i.e. loginService or chatService or gameService
based on the area requested by the client.
2. User logins are token based and the tokens are uniquely created based
on username, IP Address and the login time and salted with a unique string.
3. Uses Material Design Lite (<http://getmdl.io>) for a styling and visual elements.
4. Allows users to chat in the lobby and the within the game.
5. On each user login, it checks for the chat history and removes chat messages
older than an hour and saves in to a log file - **chatLog.txt**.

##### Gameplay

1. The application is available at Kelvin (<http://kelvin.ist.rit.edu/759/Game>).
To test run the application login with the username - *user1* and password *user1* and
in another window with username *user2* and password *user2*.

2. Challenge the available online player by clicking on their username. The other player should
receive and accept the challenge.

3. The application looks for 4 successive occurrences for pieces in downward, right, left,
and diagonal directions and alerts both the users when the event has occured.

