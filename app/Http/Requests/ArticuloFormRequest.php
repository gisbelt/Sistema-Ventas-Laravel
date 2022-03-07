<?php

namespace sisVentas\Http\Requests;

use sisVentas\Http\Requests\Request;

class ArticuloFormRequest extends Request
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
        return [
            //Establecemos nuestras reglas de validación
            //Estos son los nombres de nuestro objeto en el formulario html que vamos a validar
            //No son los nombres de los campos en la BD
            'idcategoria'=>'required', //Será un select en el formulario
            'codigo'=>'required|max:50',
            'nombre'=>'required|max:100',
            'stock'=>'required|numeric',
            'descripcion'=>'max:512',
            'imagen'=>'mimes:.jpg,.bmp,.png' //En el contralador vamos a hacer que en imagen se almacene solo la ruta 

        ];
    }
}
