<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $table="articulo";

    protected $primaryKey='idarticulo';

    //Laravel automáticamente puede adicionar a la tabla dos columnas
    //Estas columnas nos va a permitir especificar cuando ha sido creado
    //o cuando ha sido actualizado el registro. Si queremos que se agreguen 
    //automáticamente creamos una propiedad, en este caso "$timetamps=true"
    //Para este caso no queremos que se agreguen esas dos columnas
    public $timetamps=false; 

    //Especificando campos que van a recibir una valor para poder almacenarlo en la BD (campos que va a ser rellenables)
    //Estos campos se asignarán al modelo
    protected $fillabel = [
    	'idcategoria', //Hacemos referencia a la tabla categoria
    	'codigo',
    	'nombre',
    	'stock',
    	'descripcion',
    	'imagen',
    	'estado'
    ];

    //Los campos guarded se van a especificar cuando no queremos que se asignen al modelo
    protected $guarded = [


    ];
}
