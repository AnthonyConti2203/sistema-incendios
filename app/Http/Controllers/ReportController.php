<?php

namespace App\Http\Controllers;

// Modelo que representa la tabla de reportes
use App\Models\Report;

// Permite recibir los datos enviados desde formularios
use Illuminate\Http\Request;

// Permite obtener información del usuario que inició sesión
use Illuminate\Support\Facades\Auth;

// Controlador encargado de la lógica relacionada con los reportes
class ReportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Mostrar formulario
    |--------------------------------------------------------------------------
    |
    | Este método se ejecuta cuando el usuario entra a:
    | /reportes/crear
    |
    */
    public function create()
    {
        // Abre la vista resources/views/reports/create.blade.php
        return view('reports.create');
    }

    /*
    |--------------------------------------------------------------------------
    | Guardar reporte
    |--------------------------------------------------------------------------
    |
    | Este método recibe los datos del formulario y los guarda
    | en la base de datos.
    |
    */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validación de datos
        |--------------------------------------------------------------------------
        |
        | Antes de guardar la información verificamos que los
        | datos tengan el formato correcto.
        |
        */

        $validated = $request->validate([

            // La descripción es opcional
            'description' => 'nullable|string|max:1000',

            // La latitud es obligatoria y debe ser numérica
            'latitude' => 'required|numeric',

            // La longitud es obligatoria y debe ser numérica
            'longitude' => 'required|numeric',

            // Solo se aceptan estos dos valores
            'location_type' => 'required|in:auto,manual',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Crear reporte
        |--------------------------------------------------------------------------
        |
        | Una vez validados los datos, se registra un nuevo
        | reporte en la base de datos.
        |
        */

        Report::create([

            // Usuario que realizó el reporte
            'user_id' => Auth::id(),

            // Descripción escrita por el ciudadano
            'description' => $validated['description'],

            // Coordenadas del incendio
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],

            // Tipo de ubicación seleccionada
            'location_type' => $validated['location_type'],

            // Estado inicial del reporte
            'status' => 'enviado',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Redirección
        |--------------------------------------------------------------------------
        |
        | Después de guardar el reporte se vuelve a abrir el
        | formulario y se muestra un mensaje de éxito.
        |
        */

        return redirect()
            ->route('reports.create')
            ->with('success', 'Reporte enviado correctamente.');
    }
}