<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
//crea la clase user
//"extends authenticatable " hereda todo lo del sistema
//de autenticación de Laravel (login, logout, sesiones)
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;
    // Activa dos funcionalidades dentro de la clase:
    // HasFactory  → permite crear usuarios falsos para pruebas
    // Notifiable  → permite enviar notificaciones al usuario

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
    // Define qué campos se pueden llenar masivamente
    // "Masivamente" = cuando usas User::create([...])
    // Solo los campos listados aquí pueden guardarse así
    // Es una medida de SEGURIDAD
        'name',
        'email',
        'password',
        'role',
        'status',
        'phone',
        'dni',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        // La contraseña NUNCA se muestra en respuestas JSON
        // Aunque alguien intercepte la respuesta, no verá la contraseña
        'remember_token',
    ];

    // Un usuario puede tener muchos reportes
    public function reports()
    {
        return $this->hasMany(Report::class);
        // 'hasMany' = "tiene muchos"
        // Le dice a Laravel: busca en la tabla 'reports'
        // todos los registros donde user_id = este usuario
    }

    // Un usuario puede tener muchas notificaciones
    public function notifications()
    {
        return $this->hasMany(Notification::class);
        // Igual que reports pero con la tabla 'notifications'
        // Busca todas las notificaciones donde user_id = este usuario
        
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    //el casts convierte automaticamnete los datos cuando los guardan o 
    //lees de la BD
    {
        return [
            'email_verified_at' => 'datetime',
            //el email_verified guarda la fecha y la hora en 
            //el que el usuario verifico el correo

            //el datatime lo convierte a un objeto fecha
            'password' => 'hashed',
            //en esta linea cuando guardas una contraseña , laravel la encripta
            //automaticamente
        ];
    }
}
