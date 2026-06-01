<?php

namespace App\Models;

// Modelo base de Laravel para trabajar con tablas de la base de datos
use Illuminate\Database\Eloquent\Model;

// Permite utilizar fábricas para pruebas o generación automática de datos
use Illuminate\Database\Eloquent\Factories\HasFactory;

/*
|--------------------------------------------------------------------------
| Modelo ReportImage
|--------------------------------------------------------------------------
|
| Este modelo representa la tabla report_images.
| Su función es guardar las imágenes asociadas a cada reporte
| de incendio.
|
*/
class ReportImage extends Model
{
    // Activa el uso de fábricas
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Campos permitidos
    |--------------------------------------------------------------------------
    |
    | Son los únicos campos que Laravel puede guardar mediante
    | asignación masiva.
    |
    */
    protected $fillable = [
        'report_id',   // Reporte al que pertenece la imagen
        'image_path'   // Ruta donde se almacena la imagen
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIÓN
    |--------------------------------------------------------------------------
    |
    | Una imagen pertenece a un único reporte.
    |
    | Gracias a esta relación podemos obtener fácilmente
    | el reporte asociado a una imagen.
    |
    */
    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}