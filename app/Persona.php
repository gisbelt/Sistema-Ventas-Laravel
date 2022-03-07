<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table="persona";

    protected $primaryKey='idpersona';

    //Laravel automáticamente puede adicionar a la tabla dos columnas
    //Estas columnas nos va a permitir especificar cuando ha sido creado
    //o cuando ha sido actualizado el registro. Si queremos que se agreguen 
    //automáticamente creamos una propiedad, en este caso $timetamps=true
    //Para este caso no queremos que se agreguen esas dos columnas
    public $timetamps=false; 

    //Especificando campos que van a recibir una valor para poder almacenarlo en la BD
    //Estos campos se asignarán al modelo
    protected $fillabel = [
    	'tipo_persona',
    	'nombre',
    	'tipo_documento',
    	'num_documento',
    	'direccion',
    	'telefono',
    	'email'
    ];

    //Los campos guarded se van a especificar cuando no queremos que se asignen al modelo
    protected $guarded = [


    ];
}
