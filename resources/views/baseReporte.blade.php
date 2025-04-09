<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte de {{ $sensorLabel }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 0; background-color: #f4f4f9; }
        .header { text-align: center; margin-bottom: 30px; background-color: #2c3e50; padding: 20px; color: white; border-radius: 10px; }
        .title { font-size: 28px; color: #ecf0f1; margin-bottom: 10px; font-weight: bold; }
        .subtitle { font-size: 16px; color: #bdc3c7; margin-bottom: 20px; }
        .section-title { font-size: 20px; color: #2c3e50; margin: 20px 0 10px 0; border-bottom: 2px solid #2c3e50; padding-bottom: 5px; }
        .parameter { margin-bottom: 8px; font-size: 16px; color: #34495e; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th { background-color: #3498db; color: white; padding: 12px 15px; text-align: left; border-radius: 5px 5px 0 0; }
        td { padding: 12px 15px; text-align: left; border: 1px solid #ddd; border-radius: 5px; }
        tr:nth-child(even) { background-color: #ecf0f1; }
        tr:hover { background-color: #f39c12; }
        .footer { margin-top: 40px; font-size: 12px; text-align: center; color: #7f8c8d; }
        .chart-placeholder { background-color: #ffffff; padding: 30px; text-align: center; border: 1px dashed #ccc; margin: 15px 0; border-radius: 10px; }
        .footer { font-size: 12px; text-align: center; margin-top: 50px; color: #7f8c8d; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Reporte de {{ $sensorLabel }}</div>
        <div class="subtitle">
            Generado el: {{ now()->format('d/m/Y H:i') }}<br>
            Sistema de Monitoreo de Calidad del Agua
        </div>
    </div>

    <!-- 1. Información del Reporte -->
    <div class="section-title">1. Información del Reporte</div>
    <div class="parameter">• Tipo de Sensor: {{ $sensorLabel }}</div>
    <div class="parameter">• Unidad de Medida: {{ $unit }}</div>
    <div class="parameter">• Rango Temporal: {{ $timeRange }}</div>
    <div class="parameter">• Elementos incluidos: {{ $includedOptions }}</div>

    <!-- 2. Gráfico -->
    @if($includeChart)
    <div class="section-title">2. Gráfico de Datos</div>
    <div class="chart-placeholder">
        [Gráfico de {{ $sensorLabel }}]
        <!-- Si tienes imágenes base64 del gráfico: -->
        <!-- <img src="{{ $chartImage }}" style="max-width: 100%; height: auto;"> -->
    </div>
    @endif

    <!-- 3. Tabla de Datos -->
    @if($includeTable && count($tableData) > 0)
    <div class="section-title">3. Tabla de Datos</div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Medición ({{ $unit }})</th>
                <th>Fecha y Hora</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tableData as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ number_format($item['measurement'], 2) }}</td>
                <td>{{ $item['timestamp'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- 4. Resumen Estadístico -->
    @if($includeSummary && count($tableData) > 0)
    <div class="section-title">4. Resumen Estadístico</div>
    <div class="parameter">• Mínimo: {{ $stats['min'] }} {{ $unit }}</div>
    <div class="parameter">• Máximo: {{ $stats['max'] }} {{ $unit }}</div>
    <div class="parameter">• Promedio: {{ $stats['avg'] }} {{ $unit }}</div>
    <div class="parameter">• Desviación Estándar: {{ $stats['stdDev'] }} {{ $unit }}</div>
    <div class="parameter">• Total de registros: {{ $stats['count'] }}</div>

    <div class="footer">
        Página {PAGE_NUM} de {PAGE_COUNT} | Reporte generado por Apan
    </div>
</body>
</html>