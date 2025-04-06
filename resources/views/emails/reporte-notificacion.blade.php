<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Notificación de Reporte</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4a6fdc;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
        .info-box {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .info-title {
            font-weight: bold;
            margin-bottom: 5px;
            color: #4a6fdc;
        }
        .btn {
            display: inline-block;
            background-color: #4a6fdc;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Nuevo Reporte de Sensor</h2>
    </div>
    
    <div class="content">
        <p>Hola {{ $admin->name }},</p>
        
        <p>Se ha registrado un nuevo reporte en el sistema. A continuación, los detalles:</p>
        
        <div class="info-box">
            <div class="info-title">Información del Reporte</div>
            <p><strong>ID:</strong> {{ $reporte->id }}</p>
            <p><strong>Fecha:</strong> {{ $reporte->fecha }}</p>
            <p><strong>Estatus:</strong> {{ $reporte->estatusReporte->estatus }}</p>
            <p><strong>Descripción:</strong> {{ $reporte->descripcion }}</p>
        </div>
        
        <div class="info-box">
            <div class="info-title">Información del Sensor</div>
            <p><strong>Tipo:</strong> {{ $reporte->sensor->tipoSensor->nombreSensor }}</p>
            <p><strong>Valor:</strong> {{ $reporte->sensor->valor }} {{ $reporte->sensor->unidadMedida->unidadMedida }}</p>
            <p><strong>Fecha de lectura:</strong> {{ $reporte->sensor->fecha }}</p>
        </div>
        
        <div class="info-box">
            <div class="info-title">Información del Usuario</div>
            <p><strong>Nombre:</strong> {{ $reporte->usuario->name }}</p>
            <p><strong>Email:</strong> {{ $reporte->usuario->email }}</p>
        </div>
        
        <p>Puedes ver el reporte completo en el sistema.</p>
        
        <a href="{{ url('/reportes/' . $reporte->id) }}" class="btn">Ver Reporte</a>
    </div>
    
    <div class="footer">
        <p>Este es un correo automático del sistema de monitoreo de sensores. Por favor, no responda a este mensaje.</p>
    </div>
</body>
</html> 