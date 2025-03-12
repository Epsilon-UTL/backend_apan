alert(12);
Echo.private('user.' + userId)
    .listen('NotificationEvent', (event) => {
        console.log(event.message); // Puedes mostrar la notificación aquí
        alert(event.message);  // Mostrar una alerta, o actualizar el contador de notificaciones
    });
