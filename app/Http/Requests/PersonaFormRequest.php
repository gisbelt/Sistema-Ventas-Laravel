<?php

namespace sisVentas\Http\Requests;

use sisVentas\Http\Requests\Request;

class PersonaFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //Cambiamos a true para indicarle que si está autorizado para hacer el request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //Nos falta el tipo_persona porque ese es un campo de control interno, no va estar mostrado en el formulario de registro o de edicion
        return [
            //Reglas de validacion
            //Voy a tener un objeto en el formulario que se va a llamar nombre
            //Estos son los nombres de nuestro objeto en el formulario html que vamos a validar
            //No son los nombres de los campos en la BD
            'nombre'=>'required|max:100',
            'tipo_documento'=>'required|max:20',
            'num_documento'=>'required|max:15',
            'direccion'=>'max:70',
            'telefono'=>'max:15',
            'email'=>'max:50'
        ];
    }
}
