<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table="ventas";

    protected $primaryKey='idventas';

    //Laravel automáticamente puede adicionar a la tabla dos columnas
    //Estas columnas nos va a permitir especificar cuando ha sido creado
    //o cuando ha sido actualizado el registro. Si queremos que se agreguen 
    //automáticamente creamos una propiedad, en este caso $timetamps=true
    //Para este caso no queremos que se agreguen esas dos columnas
    public $timetamps=false; 

    //Especificando campos que van a recibir una valor para poder almacenarlo en la BD
    //Estos campos se asignarán al modelo
    protected $fillabel = [
    	'idcliente', 
    	'tipo_comprobante',
    	'serie_comprobante',
    	'num_comprobante',
    	'fecha_hora',
    	'impuesto',
    	'total_venta', //Esto será un campo calculado. igual será almacenado directamente en la BD
    	'estado'
    ];

    //Los campos guarded se van a especificar cuando no queremos que se asignen al modelo
    protected $guarded = [


    ];
}
