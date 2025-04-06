<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Resumen Diario de Reportes</title>
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
            background-color: #4adc4a;
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
            color: #4adc4a;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        .stat-box {
            background-color: #f0f9f0;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
        }
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #4adc4a;
        }
        .stat-label {
            font-size: 14px;
            color: #666;
        }
        .report-list {
            list-style: none;
            padding: 0;
        }
        .report-item {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }
        .report-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>📊 Resumen Diario de Reportes</h2>
    </div>
    
    <div class="content">
        <p>Hola {{ $admin->name }},</p>
        
        <p>Aquí está el resumen de la actividad del sistema para el día de hoy:</p>
        
        <div class="stats-grid">
            <div class="stat-box">
                <div class="stat-value">{{ $totalReportes }}</div>
                <div class="stat-label">Total de Reportes</div>
            </div>
            <div class="stat-box">
                <div class="stat-value">{{ $reportesPendientes }}</div>
                <div class="stat-label">Reportes Pendientes</div>
            </div>
            <div class="stat-box">
                <div class="stat-value">{{ $reportesEnProceso }}</div>
                <div class="stat-label">En Proceso</div>
            </div>
            <div class="stat-box">
                <div class="stat-value">{{ $reportesCompletados }}</div>
                <div class="stat-label">Completados</div>
            </div>
        </div>
        
        <div class="info-box">
            <div class="info-title">Últimos Reportes</div>
            <ul class="report-list">
                @foreach($ultimosReportes as $reporte)
                <li class="report-item">
                    <strong>ID: {{ $reporte->id }}</strong><br>
                    Sensor: {{ $reporte->sensor->tipoSensor->nombreSensor }}<br>
                    Estado: {{ $reporte->estatusReporte->estatus }}<br>
                    Fecha: {{ $reporte->fecha }}
                </li>
                @endforeach
            </ul>
        </div>
        
        <div class="info-box">
            <div class="info-title">Sensores con Alertas</div>
            @if(count($sensoresConAlertas) > 0)
                <ul class="report-list">
                    @foreach($sensoresConAlertas as $sensor)
                    <li class="report-item">
                        <strong>{{ $sensor->tipoSensor->nombreSensor }}</strong><br>
                        Valor: {{ $sensor->valor }} {{ $sensor->unidadMedida->unidadMedida }}<br>
                        Estado: {{ $sensor->estado }}
                    </li>
                    @endforeach
                </ul>
            @else
                <p>No hay sensores con alertas activas.</p>
            @endif
        </div>
        
        <p>Puedes ver más detalles en el panel de control del sistema.</p>
        
        <a href="{{ url('/dashboard') }}" class="btn" style="background-color: #4adc4a;">Ir al Dashboard</a>
    </div>
    
    <div class="footer">
        <p>Este es un correo automático del sistema de monitoreo de sensores. Por favor, no responda a este mensaje.</p>
    </div>
</body>
</html> 