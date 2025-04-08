@extends('app')
@section('title', 'Principal')
@section('activeNav', 'Escritorio')
@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Estadísticas principales -->
        <div class="col-md-3 mb-4">
            <div class="card text-white h-100" style="background-color: var(--color-primary-dark);">
                <div class="card-body">
                    <h5 class="card-title">Total de Sensores</h5>
                    <h2 class="mb-0">{{ $totalSensores }}</h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card text-white h-100" style="background-color: var(--color-primary-medium);">
                <div class="card-body">
                    <h5 class="card-title">Reportes Totales</h5>
                    <h2 class="mb-0">{{ $totalReportes }}</h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card text-white h-100" style="background-color: var(--color-primary-light);">
                <div class="card-body">
                    <h5 class="card-title">Reportes Abiertos</h5>
                    <h2 class="mb-0">{{ $reportesAbiertos }}</h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card text-white h-100" style="background-color: var(--color-accent);">
                <div class="card-body">
                    <h5 class="card-title">Reportes Resueltos</h5>
                    <h2 class="mb-0">{{ $reportesResueltos }}</h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Gráfico de lecturas por día -->
        <div class="col-md-6 mb-4">
            <div class="card h-100" style="background-color: var(--color-background-light);">
                <div class="card-header" style="background-color: var(--color-primary-medium); color: var(--color-text-light);">
                    <h5>Lecturas de Sensores (Últimos 7 días)</h5>
                </div>
                <div class="card-body">
                    <canvas id="lecturasChart" height="200"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Gráfico de reportes por estado -->
        <div class="col-md-6 mb-4">
            <div class="card h-100" style="background-color: var(--color-background-light);">
                <div class="card-header" style="background-color: var(--color-primary-medium); color: var(--color-text-light);">
                    <h5>Reportes por Estado</h5>
                </div>
                <div class="card-body">
                    <canvas id="reportesChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Últimas lecturas -->
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="background-color: var(--color-background-light);">
                <div class="card-header" style="background-color: var(--color-primary-medium); color: var(--color-text-light);">
                    <h5>Últimas Lecturas de Sensores</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead style="background-color: var(--color-primary-light); color: var(--color-text-light);">
                                <tr>
                                    <th>Tipo de Sensor</th>
                                    <th>Valor</th>
                                    <th>Unidad de Medida</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ultimasLecturas as $lectura)
                                <tr style="color: var(--color-text-dark);">
                                    <td>{{ $lectura->tipoSensor->nombreSensor }}</td>
                                    <td>{{ $lectura->valor }}</td>
                                    <td>{{ $lectura->tipoSensor->unidadMedida[0]->unidadMedida }}</td>
                                    <td>{{ $lectura->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilos generales para el dashboard */
body {
    background-color: var(--color-background-light);
    color: var(--color-text-dark);
}

.card {
    border: none;
    border-radius: 8px;
    box-shadow: var(--shadow-sm);
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.card-header {
    border-bottom: none;
    border-radius: 8px 8px 0 0 !important;
}

.table {
    color: var(--color-text-dark);
}

.table thead th {
    border-bottom: 2px solid var(--color-primary-light);
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(77, 184, 201, 0.05);
}

/* Ajustes para modo oscuro */
[data-theme="dark"] .card {
    background-color: var(--color-primary-dark);
    color: var(--color-text-light);
}

[data-theme="dark"] .table {
    color: var(--color-text-light);
}

[data-theme="dark"] .table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(10, 46, 56, 0.5);
}
</style>

<!-- Scripts para gráficos -->
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de lecturas por día
    const lecturasCtx = document.getElementById('lecturasChart').getContext('2d');
    const lecturasChart = new Chart(lecturasCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($lecturasPorDia->pluck('date')) !!},
            datasets: [{
                label: 'Lecturas por día',
                data: {!! json_encode($lecturasPorDia->pluck('count')) !!},
                backgroundColor: 'rgba(42, 138, 157, 0.2)',
                borderColor: 'rgba(42, 138, 157, 1)',
                borderWidth: 2,
                tension: 0.1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        color: 'var(--color-text-dark)'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        color: 'var(--color-text-dark)'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        color: 'var(--color-text-dark)'
                    }
                }
            }
        }
    });
    
    // Gráfico de reportes por estado
    const reportesCtx = document.getElementById('reportesChart').getContext('2d');
    const reportesChart = new Chart(reportesCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($reportesPorEstado->pluck('EstatusReporte.estatus')) !!},
            datasets: [{
                data: {!! json_encode($reportesPorEstado->pluck('count')) !!},
                backgroundColor: [
                    'rgba(10, 46, 56, 0.7)',
                    'rgba(26, 90, 106, 0.7)',
                    'rgba(42, 138, 157, 0.7)',
                    'rgba(77, 184, 201, 0.7)'
                ],
                borderColor: 'var(--color-background-light)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        color: 'var(--color-text-dark)'
                    }
                }
            }
        }
    });
</script>
@endsection
@endsection