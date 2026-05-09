<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'user_id',
        'title',
        'message',
        'is_read'
    ];

    // Notificación relacionada con reporte
    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    // Usuario relacionado
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}