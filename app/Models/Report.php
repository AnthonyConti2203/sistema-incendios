<?php

namespace App\Models;

// Clase base de los modelos de Laravel
use Illuminate\Database\Eloquent\Model;

// Permite utilizar fábricas para pruebas y generación de datos
use Illuminate\Database\Eloquent\Factories\HasFactory;

/*
|--------------------------------------------------------------------------
| Modelo Report
|--------------------------------------------------------------------------
|
| Este modelo representa la tabla "reports" de la base de datos.
| Cada objeto Report corresponde a un reporte de incendio.
|
*/
class Report extends Model
{
    // Activa el uso de fábricas
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Campos permitidos
    |--------------------------------------------------------------------------
    |
    | Estos son los campos que Laravel puede llenar automáticamente
    | al crear un nuevo reporte.
    |
    */
    protected $fillable = [
        'user_id',
        'description',
        'latitude',
        'longitude',
        'location_type',
        'status'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Usuario
    |--------------------------------------------------------------------------
    |
    | Un reporte pertenece a un único usuario.
    | Gracias a esta relación podemos saber quién envió el reporte.
    |
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Imágenes
    |--------------------------------------------------------------------------
    |
    | Un reporte puede tener varias fotografías asociadas.
    |
    */
    public function images()
    {
        return $this->hasMany(ReportImage::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Notificaciones
    |--------------------------------------------------------------------------
    |
    | Un reporte puede generar múltiples notificaciones para
    | los bomberos o jefes de estación.
    |
    */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}