<?php

namespace App\Service;

use App\Entity\Evento;

class EventoResumenService
{
    public function __construct(
        private EventoDisponibilidadService $disponibilidadService
    ) {
    }

    public function obtenerResumen(Evento $evento): array
    {
        $capacidad = $evento->getCapacidad();
        $inscriptos = $evento->getUsuarios()->count();

        return [
            'capacidad' => $capacidad,
            'inscriptos' => $inscriptos,
            'disponibles' => max(0, $capacidad - $inscriptos),
            'tieneCupos' => $this->disponibilidadService
                ->tieneCupos($evento),
            'mensaje' => $this->disponibilidadService
                ->obtenerMensaje($evento),
        ];
    }
}