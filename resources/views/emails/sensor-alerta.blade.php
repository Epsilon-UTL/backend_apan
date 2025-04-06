<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Alerta de Sensor</title>
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
            background-color: #dc4a4a;
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
            color: #dc4a4a;
        }
        .btn {
            display: inline-block;
            background-color: #dc4a4a;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            margin-top: 15px;
        }
        .alert {
            background-color: #fff3f3;
            border-left: 4px solid #dc4a4a;
            padding: 15px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>⚠️ Alerta de Sensor</h2>
    </div>
    
    <div class="content">
        <p>Hola {{ $admin->name }},</p>
        
        <div class="alert">
            <p><strong>¡ALERTA!</strong> Se ha detectado una lectura anormal en uno de los sensores del sistema.</p>
        </div>
        
        <div class="info-box">
            <div class="info-title">Información del Sensor</div>
            <p><strong>ID:</strong> {{ $sensor->id }}</p>
            <p><strong>Tipo:</strong> {{ $sensor->tipoSensor->nombreSensor }}</p>
            <p><strong>Valor Actual:</strong> {{ $sensor->valor }} {{ $sensor->unidadMedida->unidadMedida }}</p>
            <p><strong>Fecha de lectura:</strong> {{ $sensor->fecha }}</p>
            <p><strong>Estado:</strong> {{ $sensor->estado }}</p>
        </div>
        
        <div class="info-box">
            <div class="info-title">Detalles de la Alerta</div>
            <p><strong>Valor Mínimo Permitido:</strong> {{ $sensor->valor_minimo }} {{ $sensor->unidadMedida->unidadMedida }}</p>
            <p><strong>Valor Máximo Permitido:</strong> {{ $sensor->valor_maximo }} {{ $sensor->unidadMedida->unidadMedida }}</p>
        </div>
        
        <p>Por favor, revise el estado del sensor y tome las acciones necesarias.</p>
        
        <a href="{{ url('/sensores/' . $sensor->id) }}" class="btn">Ver Sensor</a>
    </div>
    
    <div class="footer">
        <p>Este es un correo automático del sistema de monitoreo de sensores. Por favor, no responda a este mensaje.</p>
    </div>
</body>
</html> 