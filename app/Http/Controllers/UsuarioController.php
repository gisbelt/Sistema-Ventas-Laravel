<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;

use sisVentas\Http\Requests;

use sisVentas\User; //Modelo
use Illuminate\Support\Facades\Redirect;
use sisVentas\Http\Requests\UsuarioFormRequest;
use DB;

class UsuarioController extends Controller
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
    		//el objeto request utilizando el método 'get'    			
    		$query=trim($request->get('searchText')); //Va a haber un objeto en un formulario listado donde voy a ingresar el texto de los usuarios que quiero mostrar para poder realizar busquedas por usuario
    		//utilizamos la tabla users
    		//Campo name, comando LIKE, y el texto que vamos a buscar que va a ser la variable query
    		//Los porcentajes significan buscar el texto en cualquier ubicacion de la cadena de textos
    		$usuarios=DB::table('users')
    		->where('name','LIKE','%'.$query.'%')
    		->orderBy('id','desc')
    		->paginate(7) //De cuantos registros vamos a realizar la paginación
    		; //Punto y coma al final
    		//Van a ver tres vistas, una carpeta llamada seguridad, usuario y dentro de usuario una llamada index
    		//A esa vista le vamos a enviar ciertos parámetros, le vamos a enviar usuarios, los usuarios que obtenemos de la variable usuarios 
    		//Y tambien le vamos a enviar el texto de busqueda
    		return view('seguridad.usuario.index',["usuarios"=>$usuarios,"searchText"=>$query]); 													
    	}	
    }


/*******************************************************************************************************************************************************************************************************************************/

	//Solo retornará una vista
    public function create()
    {
    	return view("seguridad.usuario.create");
    }


/*******************************************************************************************************************************************************************************************************************************/

	//Almnacena el objeto del modelo User en nuestra tabla users de la BD
    //Para eso validamos utilizando el request UsuarioFormRequest
    public function store(UsuarioFormRequest $request)
    {
    	//Creamos un objeto dentro de este objeto usuario que va a hacer referencia el modelo Persona
    	$usuario = new User;
    	$usuario->name=$request->get('name'); //El objeto de validacion se llama name
    	$usuario->email=$request->get('email');
    	$usuario->password=bcrypt($request->get('password')); //bcrypt para encriptar
    	$usuario->save(); //Llamamos al objeto save para almacenar
    	return Redirect::to('seguridad/usuario'); //Redirecionamos a la URL seguridad/usuario (vista)
    }


/*******************************************************************************************************************************************************************************************************************************/

	//Los mismo de arriba, vamos a modificar los datos de un usuario específico
    //Y los almacenamos con la funcion update
    public function edit($id)
    {
    	return view("seguridad.usuario.edit",["usuario"=>User::findOrFail($id)]);
    }


 /*******************************************************************************************************************************************************************************************************************************/

	//Vamos a recibir dos parámetros, UsuarioFormRequest y el id
    public function update(UsuarioFormRequest $request, $id) //Este id se compara con el id del Modelo
    {
    	$usuario=User::findOrFail($id);
    	//name ahora va ser igual a los que está en mi objeto request y obtengo el valor con el metodo get
    	$usuario->name=$request->get('name'); //El objeto de validacion se llama name
    	$usuario->email=$request->get('email');
    	$usuario->password=bcrypt($request->get('password')); //bcrypt para encriptar
    	$usuario->update();
    	return Redirect::to('seguridad/usuario');
    }

/*******************************************************************************************************************************************************************************************************************************/

	//Recibimos como parametro de entrada el id
    public function destroy($id)
    {
    	// Donde el id coincida con el id que está como parámetro en esta función
    	$usuario = DB::table('users')->where('id','=',$id)->delete();
    	return Redirect::to('seguridad/usuario');
    }





}
