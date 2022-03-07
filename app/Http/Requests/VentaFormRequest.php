<?php

namespace sisVentas\Http\Requests;

use sisVentas\Http\Requests\Request;

class VentaFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //Cambiamos a true para indicarle que si está autorizado para hacer el request o validar
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Todos los campos que vamos a recibir desde nuestro formulario de registro de ventas
        return [
            //Ventas
            'idcliente'=>'required',
            'tipo_comprobante'=>'required|max:20',
            'serie_comprobante'=>'max:7',
            'num_comprobante'=>'required|max:10',
            //DetalleVentas
            'idarticulo'=>'required',
            'cantidad'=>'required',
            'precio_ventas'=>'required',
            'descuento'=>'required',
            'total_venta'=>'required' //Total de ventas se calcula en nuestra vista y ese total lo almacenamos en nuestra tabla
        ];
    }
}
