<?php
//direccion del archivo
namespace App\Http\Controllers;

// Modelo que representa la tabla de reportes
//es como import , osea usa la clase report
//sin escribir su ruta completa
use App\Models\Report;

// Modelo que representa la tabla de imagenes de reportes
use App\Models\ReportImage;

// Permite recibir los datos enviados desde formularios
//representa el formulario que el usuario envio
use Illuminate\Http\Request;

// Permite obtener información del usuario que inició sesión
//osea sus datos ingresados
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
    {   //click aca muestra el formulario 
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
    //cuando el usuario envia el formulario
    //que en este caso lo recibe en $request
    public function store(Request $request)
    {
        $validated = $request->validate([

            // La descripción es opcional
            'description' => 'nullable|string|max:1000',

            // La latitud es obligatoria y debe ser numérica
            'latitude' => 'required|numeric',

            // La longitud es obligatoria y debe ser numérica
            'longitude' => 'required|numeric',

            // Solo se aceptan estos dos valores
            'location_type' => 'required|in:auto,manual',

            // Arreglo de imágenes (máximo 3)
            'images' => 'nullable|array|max:3',

            // Cada archivo debe ser una imagen JPG o PNG
            'images.*' => 'image|mimes:jpg,jpeg,png|max:5120',
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

        $reporte=Report::create([

            // Usuario que realizó el reporte
            //el auth ::id() devuelve el id del usuario que ingreso
            'user_id' => Auth::id(),

            // Descripción escrita por el ciudadano
            'description' => $validated['description'],

            // Coordenadas del incendio
            //$validated solo contiene la validacion que ya paso
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],

            // Tipo de ubicación seleccionada
            'location_type' => $validated['location_type'],

            // Estado inicial del reporte
            'status' => 'enviado',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Guardar imágenes del reporte
        |--------------------------------------------------------------------------
        |
        | Si el usuario adjuntó fotografías, se almacenan
        | en la carpeta storage/app/public/reports
        |
        | En la base de datos solo se guarda la ruta.
        |
        */
        $whatsappImages = [];
        //se crea un array donde se ira llenando las urls de la imagenes

        if ($request->hasFile('images')) {
            //esto es si el usuario subio imagenes, si no es asi se salta todo esto

            foreach ($request->file('images') as $key => $image) {
                //el foreach recorre cada imagen, el $key es el indice osea 0,1 y 2 

                // Guarda la imagen físicamente
                $path = $image->store(
                    'reports',
                    'public'
                );
                //se guarda eb reports, laravel genera un nombre unico
                //retorna la ruta reports/nombre de lo que le da.jpg

                // Guarda la ruta en SQLite osea en la base de datos
                ReportImage::create([

                    'report_id' => $reporte->id,

                    'image_path' => $path

                ]);

                $whatsappImages['image' . ($key + 1)] = asset('storage/' . $path);
                //el asset es para que pueda abrir en el navegador las imagenes
            }
        }

        $reporteMensaje = " *REPORTE DE INCENDIO ENVIADO* \n\n" .
            " *Descripción:* " . ($reporte->description ?? 'Sin descripción') . "\n" .
            //lo que hace el ?? es si hay descripcion se toma , sino se pone sin descripcion en el mensaje
            " *Coordenadas:* Lat: " . $reporte->latitude . ", Lng: " . $reporte->longitude;
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
            ->with('success', 'Reporte enviado correctamente.')
            ->with('whatsapp_text', $reporteMensaje) //guarda en wasap web en contenido de reporteMnesaje
            ->with('whatsapp_images', $whatsappImages);//es el array , se guarda las url 
            //para poder utilizarla en el simulador
            }
}