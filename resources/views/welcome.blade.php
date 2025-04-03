<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        Pusher.logToConsole = true;

        var pusher = new Pusher('d4c6b31048d034756c00', {
            wsHost: '127.0.0.1',
            wsPort: 6001,
            forceTLS: false,
            disableStats: true,
        });

        var channel = pusher.subscribe('alertas');
        channel.bind('nueva-alerta', function (data) {
            alert('Nueva alerta: ' + data.mensaje);
        });
    </script>

</body>

</html>