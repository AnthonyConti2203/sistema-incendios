<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'image_path'
    ];

    // La imagen pertenece a un reporte
    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}