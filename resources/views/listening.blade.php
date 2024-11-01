<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chatroom Listener</title>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
</head>
<body>
<h1>Chatroom Listener</h1>
<div id="messages"></div>
<script>
    const pusher = new Pusher('72535f3c20de782f6400', {
        cluster: 'ap2',
        encrypted: true
    });

    const chatroomId = '1';
    const channel = pusher.subscribe('chatroom.' + chatroomId);

    channel.bind('App\\Events\\MessageSent', function(data) {
        console.log("Received message data:", data);
        const messagesDiv = document.getElementById('messages');
        messagesDiv.innerHTML += '<p>' + data.message.message + '</p>';
    });
</script>
</body>
</html>
