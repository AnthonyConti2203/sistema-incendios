<?php

namespace App\Http\Requests;
//la direccion de este archivo dentro del proyecto

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
// Crea la clase ProfileUpdateRequest
// 'extends FormRequest' hereda todo lo que tiene FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */


    public function rules(): array
    //define el metodo rules()
    // ': array' = siempre debe devolver un array
    {
        return [
        // Inicia el array de reglas que se va a devolver

            'name' => ['required', 'string', 'max:255'],
            //1-no puede estar vacio
            //2-debe ser texto
            //3-debe tener maximo 255 caracteres
            'email' => [
                'required',//no debe estar vacio
                'string',//deber ser texto
                'lowercase', //debe estar en minuscula XD
                'email',//debe tener en el formato valido , osea con @ todo eso jeje
                'max:255',//aca sabemos que debe tener 255
                Rule::unique(User::class)->ignore($this->user()->id),
                //esto implica verificacion que el email no exista 
                //osea verifica si alguien tiene ese gmail
                //y lo revisa por su id
                //en la tabla de users de la BD(todo eso es el rule)

                //ahora hablemos del ignore 
                //el this -> user() obtiene al usuario logeado
                //obtiene su id que es 1
                //entonces lo que hace es ignorar al usuario y pasar al otro 
                //osea su id 2 , 3,4,etc.
            ],
        ];
    }
}
