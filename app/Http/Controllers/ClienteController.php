<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;

use sisVentas\Http\Requests;

use sisVentas\Persona; //Modelo
use Illuminate\Support\Facades\Redirect;
use sisVentas\Http\Requests\PersonaFormRequest;
use DB;

class ClienteController extends Controller
{
    //Declaramos un constructor
    public function __construct()
    {
    	//Lo vamos a usar para validar
        // Esto para que se gestione inicialmente el acceso por usuarios
        // Al entrar por url a la dirección "almacen/artículo" esta se irá 
        // al controlador AuthController y eso rediccionará a la vista "login"
        // Con una fucnción que está al final
        $this->middleware('auth');
    }

    //Index va a recibir como parámetro un objeto tipo request
    public function index(Request $request)
    {
    	 //Si existe el request obtenemos todo los registros de nuestra tabla persona de la BD
    	if($request)
    	{
    		//Esta variable va a determinar cual va a ser el texto de busqueda 
    		//para poder filtrar todas las personas (clientes)
    		//el objeto request utilizando el método 'get'    			
    		$query=trim($request->get('searchText')); //Va a haber un objeto en un formulario listado donde voy a ingresar el texto de las personas (clientes) que quiero mostrar para poder realizar busquedas por clientes
    		//utilizamos la tabla persona
    		//Campo nombre, comando LIKE, y el texto que vamos a buscar que va a ser la variable query
    		//Los porcentajes significan buscar el texto en cualquier ubicacion de la cadena de textos
    		$personas=DB::table('persona')
    		->where('nombre','LIKE','%'.$query.'%')
    		->where('tipo_persona','=','Cliente') //Donde el tipo_persona sea igual a Cliente 
    		->orwhere('num_documento','LIKE','%'.$query.'%') //o busca por num_documento donde la persona sea un cliente
    		->where('tipo_persona','=','Cliente') 
    		->orderBy('idpersona','desc')
    		->paginate(7) //De cuantos registros vamos a realizar la paginación
    		; //Punto y coma al final
    		//Van a ver tres vistas, una carpeta llamada ventas, cliente y dentro de cliente una llamada index
    		//A esa vista le vamos a enviar ciertos parámetros, le vamos a enviar personas, las personas que obtenemos de la variable personas 
    		//Y tambien le vamos a enviar el texto de busqueda
    		return view('ventas.cliente.index',["personas"=>$personas,"searchText"=>$query]); 													
    	}	
    }

/*******************************************************************************************************************************************************************************************************************************/

    //Solo retornará una vista
    public function create()
    {
    	return view("ventas.cliente.create");
    }

/*******************************************************************************************************************************************************************************************************************************/

    //Almnacena el objeto del modelo persona en nuestra tabla persona de la BD
    //Para eso validamos utilizando el request PersonaFormRequest
    public function store(PersonaFormRequest $request)
    {
    	//Creamos un objeto dentro de este objeto persona que va a hacer referencia el modelo Persona
    	$persona = new Persona;
    	//El tipo de persona no lo obtendremos de ningun objeto
    	$persona->tipo_persona="Cliente";
    	$persona->nombre=$request->get('nombre'); //El objeto de validacion se llama nombre
    	$persona->tipo_documento=$request->get('tipo_documento');
    	$persona->num_documento=$request->get('num_documento');
    	$persona->direccion=$request->get('direccion');
    	$persona->telefono=$request->get('telefono');
    	$persona->email=$request->get('email');
    	$persona->save(); //Llamamos al objeto save para almacenar
    	return Redirect::to('ventas/cliente'); //Redirecionamos a la URL ventas/cliente (vista)
    }

/*******************************************************************************************************************************************************************************************************************************/

    //Inicialmente vamos a recibir un parámetro que será el id de la persona que quiero mostrar
    public function show($id)
    {
    	//La persona (cliente) que voy a mostrar sera igual a mi modelo Persona
    	//Llamame a esta vista pero enviale esta persona (cliente) (id) para que la muestre
    	return view("ventas.cliente.show",["persona"=>Persona::findOrFail($id)]);
    }

/*******************************************************************************************************************************************************************************************************************************/

    //Los mismo de arriba, vamos a modificar los datos de una persona (cliente) especifica
    //Y los almacenamos con la funcion update
    public function edit($id)
    {
    	return view("ventas.cliente.edit",["persona"=>Persona::findOrFail($id)]);
    }

/*******************************************************************************************************************************************************************************************************************************/

    //Vamos a recibir dos parámetros, PersonaFormRequest y el id
    public function update(PersonaFormRequest $request, $id) //Este id se compara con el id del Modelo
    {
    	$persona=Persona::findOrFail($id);
    	//nombre ahora va ser igual a los que está en mi objeto request y obtengo el valor con el metodo get
    	//No modificamos tipo_persona porque siempre será de tipo cliente
    	$persona->nombre=$request->get('nombre'); //El objeto de validacion se llama nombre
    	$persona->tipo_documento=$request->get('tipo_documento');
    	$persona->num_documento=$request->get('num_documento');
    	$persona->direccion=$request->get('direccion');
    	$persona->telefono=$request->get('telefono');
    	$persona->email=$request->get('email');
    	$persona->update();
    	return Redirect::to('ventas/cliente');
    }

/*******************************************************************************************************************************************************************************************************************************/

    //Recibimos como parametro de entrada el id
    public function destroy($id)
    {
    	//Hacemos un update de nuestro campo 'condicion'
    	//Que me seleccione la categoria cuyo id estoy recibiendo por parametro
    	$persona=Persona::findOrFail($id);
    	$persona->tipo_persona='Inactivo';
    	$persona->update();
    	return Redirect::to('ventas/cliente');
    }
}