<?php

namespace sisVentas\Http\Requests;

use sisVentas\Http\Requests\Request; 

class CategoriaFormRequest extends Request 
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

    //Agregamos las reglas
    public function rules()
    {
        //Voy a tener un objeto en el formulario que se va a llamar nombre
        return [
            //Estos son los nombres de nuestro objeto en el formulario html que vamos a validar
            //No son los nombres de los campos en la BD
            'nombre'=>'required|max:50', //requerido con maximo 50 caracteres
            'descripcion' =>'max:256',

        ];
    }
}
