<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div id="sensor-data">Esperando datos...</div>
    <div id="connection-status"></div>

    <script src="https://cdn.jsdelivr.net/npm/pusher-js@7.0.3/dist/web/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>

    <script>
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ env('PUSHER_APP_KEY') }}',
            wsHost: window.location.hostname,
            wsPort: {{ env('PUSHER_PORT', 6001) }},
            forceTLS: {{ env('PUSHER_SCHEME') === 'https' ? 'true' : 'false' }},
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            disableStats: true,
            enabledTransports: ['ws', 'wss'],
            authEndpoint: '/broadcasting/auth'
        });

        // Manejo de estado de conexión
        const connectionStatus = document.getElementById('connection-status');

        window.Echo.connector.pusher.connection.bind('connected', () => {
            connectionStatus.innerHTML = 'Conectado al servidor';
            connectionStatus.style.color = 'green';
        });

        window.Echo.connector.pusher.connection.bind('disconnected', () => {
            connectionStatus.innerHTML = 'Desconectado del servidor';
            connectionStatus.style.color = 'red';
        });

        window.Echo.connector.pusher.connection.bind('error', (err) => {
            console.error('Error de conexión:', err);
            connectionStatus.innerHTML = 'Error de conexión';
            connectionStatus.style.color = 'red';
        });

        // Escucha de eventos

        window.Echo.channel('sensores')
    .listen('.SensorDataUpdated', (data) => {
        console.log('Datos recibidos:', data);
        const sensorDataElement = document.getElementById('sensor-data');
        if (sensorDataElement) {
            try {
                sensorDataElement.innerText = JSON.stringify(data.sensores, null, 2);
            } catch (error) {
                console.error('Error al procesar datos:', error);
                sensorDataElement.innerText = 'Error al procesar los datos';
            }
        }
    });

    </script>
</body>

</html>