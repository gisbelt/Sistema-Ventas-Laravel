<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
    protected $table="detalle_ingreso";

    protected $primaryKey='iddetalle_ingreso';

    //Laravel automáticamente puede adicionar a la tabla dos columnas
    //Estas columnas nos va a permitir especificar cuando ha sido creado
    //o cuando ha sido actualizado el registro. Si queremos que se agreguen 
    //automáticamente creamos una propiedad, en este caso $timetamps=true
    //Para este caso no queremos que se agreguen esas dos columnas
    public $timetamps=false; 

    //Especificando campos que van a recibir una valor para poder almacenarlo en la BD
    //Estos campos se asignarán al modelo
    protected $fillabel = [
    	'idingreso', //El ingreso al que pertenece este detalle
    	'idarticulo', //El articulo que estoy agregando
    	'cantidad', //La cantidad de ese articulo que se está agregando como detalle
    	'precio_compra',
    	'precio_venta' //Precio al cual voy a vender ese articulo
    	
    ];

    //Los campos guarded se van a especificar cuando no queremos que se asignen al modelo
    protected $guarded = [


    ];
}
