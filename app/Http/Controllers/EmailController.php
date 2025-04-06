<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use App\Models\Sensor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class EmailController extends Controller
{
    /**
     * Enviar correo de notificación de reporte
     */
    public function enviarNotificacionReporte(Reporte $reporte)
    {
        try {
            // Obtener información del reporte con relaciones
            $reporte->load(['sensor', 'sensor.unidadMedida', 'sensor.tipoSensor', 'estatusReporte', 'usuario']);
            
            // Obtener administradores para notificar
            $administradores = User::where('role', User::ROLE_ADMIN)
                ->where('is_active', true)
                ->get();
            
            if ($administradores->isEmpty()) {
                Log::warning('No hay administradores activos para enviar notificación de reporte');
                return response()->json([
                    'success' => false,
                    'message' => 'No hay administradores activos para enviar notificación'
                ], 404);
            }
            
            // Enviar correo a cada administrador
            foreach ($administradores as $admin) {
                Mail::send('emails.reporte-notificacion', [
                    'reporte' => $reporte,
                    'admin' => $admin
                ], function ($message) use ($admin, $reporte) {
                    $message->to($admin->email, $admin->name)
                        ->subject('Nuevo reporte de sensor: ' . $reporte->sensor->tipoSensor->nombreSensor);
                });
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Notificación enviada correctamente',
                'destinatarios' => $administradores->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al enviar notificación de reporte: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar notificación: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Enviar correo de alerta de sensor
     */
    public function enviarAlertaSensor(Sensor $sensor)
    {
        try {
            // Obtener información del sensor con relaciones
            $sensor->load(['unidadMedida', 'tipoSensor']);
            
            // Obtener administradores para notificar
            $administradores = User::where('role', User::ROLE_ADMIN)
                ->where('is_active', true)
                ->get();
            
            if ($administradores->isEmpty()) {
                Log::warning('No hay administradores activos para enviar alerta de sensor');
                return response()->json([
                    'success' => false,
                    'message' => 'No hay administradores activos para enviar alerta'
                ], 404);
            }
            
            // Enviar correo a cada administrador
            foreach ($administradores as $admin) {
                Mail::send('emails.sensor-alerta', [
                    'sensor' => $sensor,
                    'admin' => $admin
                ], function ($message) use ($admin, $sensor) {
                    $message->to($admin->email, $admin->name)
                        ->subject('Alerta de sensor: ' . $sensor->tipoSensor->nombreSensor);
                });
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Alerta enviada correctamente',
                'destinatarios' => $administradores->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al enviar alerta de sensor: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar alerta: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Enviar correo de resumen diario
     */
    public function enviarResumenDiario()
    {
        try {
            // Obtener estadísticas del día
            $hoy = now()->format('Y-m-d');
            
            $estadisticas = [
                'total_reportes' => Reporte::whereDate('created_at', $hoy)->count(),
                'reportes_por_estatus' => Reporte::join('estatus_reportes', 'reportes.estatus_id', '=', 'estatus_reportes.id')
                    ->whereDate('reportes.created_at', $hoy)
                    ->select('estatus_reportes.estatus', DB::raw('COUNT(*) as total'))
                    ->groupBy('estatus_reportes.id', 'estatus_reportes.estatus')
                    ->get(),
                'ultimos_reportes' => Reporte::with(['sensor', 'sensor.tipoSensor', 'estatusReporte'])
                    ->whereDate('created_at', $hoy)
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get()
            ];
            
            // Obtener administradores para notificar
            $administradores = User::where('role', User::ROLE_ADMIN)
                ->where('is_active', true)
                ->get();
            
            if ($administradores->isEmpty()) {
                Log::warning('No hay administradores activos para enviar resumen diario');
                return response()->json([
                    'success' => false,
                    'message' => 'No hay administradores activos para enviar resumen'
                ], 404);
            }
            
            // Enviar correo a cada administrador
            foreach ($administradores as $admin) {
                Mail::send('emails.resumen-diario', [
                    'estadisticas' => $estadisticas,
                    'admin' => $admin,
                    'fecha' => $hoy
                ], function ($message) use ($admin, $hoy) {
                    $message->to($admin->email, $admin->name)
                        ->subject('Resumen diario de reportes - ' . $hoy);
                });
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Resumen diario enviado correctamente',
                'destinatarios' => $administradores->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al enviar resumen diario: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar resumen: ' . $e->getMessage()
            ], 500);
        }
    }
} 