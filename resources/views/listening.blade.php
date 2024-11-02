<!DOCTYPE html>
<head>
    <title>Pusher Test</title>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('6cf3a8a4cc81717824c3', {
            cluster: 'ap2'
        });

        var channel = pusher.subscribe('chatroom.1');

        channel.bind('pusher:subscription_succeeded', function(members) {
            alert('successfully subscribed!');
        });

        channel.bind('message.sent', function(data) {
            alert('ok!');
        });
    </script>
</head>
<body>
<h1>Pusher Test</h1>
<p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
</p>
</body>
