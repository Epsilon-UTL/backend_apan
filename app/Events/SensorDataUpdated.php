<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SensorDataUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sensores;

    public function __construct($sensores)
    {
        $this->sensores = $sensores;
    }

    public function broadcastOn()
    {
        return new Channel('sensores');
    }

    public function broadcastWith()
    {
        return $this->sensores;
    }

    // Corrección importante: este método debe devolver solo el nombre del evento
    public function broadcastAs()
    {
        return 'SensorDataUpdated'; // Solo el nombre del evento como string
    }
}