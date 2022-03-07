<?php

//REQUEST ES EL FORMULARIO , LO DEL MODELO CATEGORIA SON LOS CAMPOS
namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;

use sisVentas\Http\Requests;

//Agregamos el modelo
use sisVentas\Categoria;
//Para hacer redirecciones
use Illuminate\Support\Facades\Redirect;
//Hacemos referencia al Request creado previamente
use sisVentas\Http\Requests\CategoriaFormRequest;
//Para trabajar con la clase DB de laravel
use DB;

class CategoriaController extends Controller
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
    	 //Si existe el request obtenemos todo los registros de nuestra tabla categoria de la BD
    	if($request)
    	{
    		//Esta variable va a determinar cual va a ser el texto de busqueda 
    		//para poder filtrar todas las categorias
    		//el objeto request utilizando el método 'get'    			
    		$query=trim($request->get('searchText')); //Va a haber un objeto en un formulario listado donde voy a ingresar el texto de las categorias que quiero mostrar para poder realizar busquedas por categorias
    		//utilizamos la tabla categoria
    		//Campo nombre, comando LIKE, y el texto que vamos a buscar que va a ser la variable query
    		//Los porcentajes significan buscar el texto en cualquier ubicacion de la cadena de textos
    		$categorias=DB::table('categoria')->where('nombre','LIKE','%'.$query.'%')
    		->where('condicion','=','1') //Donde la condicion sea igual a 1
    		->orderBy('idcategoria','desc')
    		->paginate(7) //De cuantos registros vamos a realizar la paginación
    		; //Punto y coma al final
    		//Van a ver tres vistas, una carpeta llamada almacen, cetagoria y dentro de categoria una llamada index
    		//A esa vista le vamos a enviar ciertos parámetros, le vamos a enviar categorias, las categorias que obtenemos de la variable categorias 
    		//Y tambien le vamos a enviar el texto de busqueda
    		return view('almacen.categoria.index',["categorias"=>$categorias,"searchText"=>$query]); 													
    	}	
    }

/*******************************************************************************************************************************************************************************************************************************/

    //Solo retornará una vista
    public function create()
    {
    	return view("almacen.categoria.create");
    }

/*******************************************************************************************************************************************************************************************************************************/

    //Almnacena el objeto del modelo categoria en nuestra tabla categoria de la BD
    //Para eso validamos utilizando el request CategoriaFormRequest
    public function store(CategoriaFormRequest $request)
    {
    	//Creamos un objeto dentro de este objeto categoria que va a hacer referencia el modelo Categoria
    	$categoria = new Categoria;
    	//nombre va a ser igual a lo que obtenemos del parametro request
    	$categoria->nombre=$request->get('nombre'); //El objeto de validacion se llama nombre
    	$categoria->descripcion=$request->get('descripcion');
    	$categoria->condicion='1';  //Se almacena con uno, cuando se elimina se pone 0
    	$categoria->save(); //Llamamos al objeto save para almacenar
    	return Redirect::to('almacen/categoria'); //Redirecionamos a la URL almacen/categoria (vista)
    }

/*******************************************************************************************************************************************************************************************************************************/

    //Inicialmente vamos a recibir un parámetro que será el id de la categoria que quiero mostrar
    public function show($id)
    {
    	//La categoria que voy a mostrar sera igual a mi modelo Categoria
    	//Llamame a esta vista pero enviale esta categoria (id) para que la muestre
    	return view("almacen.categoria.show",["categoria"=>Categoria::findOrFail($id)]);
    }

/*******************************************************************************************************************************************************************************************************************************/

    //Los mismo de arriba, vamos a modificar los datos de una categoria especifica
    //Y los almacenamos con la funcion update
    public function edit($id)
    {
    	return view("almacen.categoria.edit",["categoria"=>Categoria::findOrFail($id)]);
    }

/*******************************************************************************************************************************************************************************************************************************/

    //Vamos a recibir dos parámetros, CategoriaFormRequest y el id
    public function update(CategoriaFormRequest $request, $id) //Este id se compara con el id del Modelo
    {
    	$categoria=Categoria::findOrFail($id);
    	//nombre ahora va ser igual a los que está en mi objeto request y obtengo el valor con el metodo get
    	$categoria->nombre=$request->get('nombre');
    	$categoria->descripcion=$request->get('descripcion');
    	$categoria->update();
    	return Redirect::to('almacen/categoria');
    }

/*******************************************************************************************************************************************************************************************************************************/

    //Recibimos como parametro de entrada el id
    public function destroy($id)
    {
    	//Hacemos un update de nuestro campo 'condicion'
    	//Que me seleccione la categoria cuyo id estoy recibiendo por parametro
    	$categoria=Categoria::findOrFail($id);
    	$categoria->condicion='0';
    	$categoria->update();
    	return Redirect::to('almacen/categoria');
    }

}
