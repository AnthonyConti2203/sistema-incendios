<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

    // Campos permitidos para guardar
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

    // Un reporte pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un reporte tiene muchas imágenes
    public function images()
    {
        return $this->hasMany(ReportImage::class);
    }

    // Un reporte tiene muchas notificaciones
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}