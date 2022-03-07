<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;

use sisVentas\Http\Requests;

//Aquí agregamos este nuevo espacio de nombre
use Illuminate\Support\Facades\Redirect; 
use Illuminate\Support\Facades\Input; //Esto es para poder subir la imagen desde la máquina del cliente hasta la máquina del servidor
use sisVentas\Http\Requests\ArticuloFormRequest;
use sisVentas\Articulo; //modelo
use DB;   

class ArticuloController extends Controller
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
    		//para poder filtrar todas los articulos
    		//el objeto request utilizando el método 'get'    			
    		$query=trim($request->get('searchText')); //Va a haber un objeto en un formulario listado donde voy a ingresar el texto de los articulo que quiero mostrar para poder realizar busquedas por articulo
    		//utilizamos la tabla articulo
    		//Campo nombre, comando LIKE, y el texto que vamos a buscar que va a ser la variable query
    		//Los porcentajes significan buscar el texto en cualquier ubicacion de la cadena de textos
    		$articulos=DB::table('articulo as a')
    		//La tabla articulo está relacionada con la tabla categoria y con que campos haremos la unión 
    		->join('categoria as c','a.idcategoria','=','c.idcategoria') 
    		//Buscamos lo que necesitamos de cada tabla
    		->select('a.idarticulo','a.nombre','a.codigo','a.stock','c.nombre as categoria','a.descripcion','a.imagen','a.estado')
    		->where('a.nombre','LIKE','%'.$query.'%')
            ->orwhere('a.codigo','LIKE','%'.$query.'%') //Que tambien busque por codigo
    		->orderBy('a.idarticulo','desc')
    		->paginate(7) //De cuantos registros vamos a realizar la paginación
    		; //Punto y coma al final
    		//Van a ver tres vistas, una carpeta llamada almacen, articulo y dentro de articulo una llamada index
    		//A esa vista le vamos a enviar ciertos parámetros, le vamos a enviar articulos, los articulos que obtenemos de la variable articulos 
    		//Y tambien le vamos a enviar el texto de busqueda
    		return view('almacen.articulo.index',["articulos"=>$articulos,"searchText"=>$query]); 													
    	}	
    }

/*******************************************************************************************************************************************************************************************************************************/    	

    //Solo retornará una vista
    public function create()
    {
    	//Tenemos que enviar también el listado de las categorias para poder mostrarlas en un combobox
    	$categorias=DB::table('categoria')->where('condicion','=','1')->get(); //con el método get obtenga esas categorias
    	//También enviamos un parametro para enviarle los valores de la variable categorias que está arriba de esto
    	return view("almacen.articulo.create",["categorias"=>$categorias]); 
    									//Este es el que se usa en la vista
    }

/*******************************************************************************************************************************************************************************************************************************/   

    //Almacena en la BD mediante el modelo
    //Almnacena el objeto del modelo articulo en nuestra tabla articulo de la BD
    //Para eso validamos utilizando el request ArticuloFormRequest
    public function store(ArticuloFormRequest $request)
    {
    	//Creamos un objeto dentro de este objeto articulo que va a hacer referencia el modelo Articulo
    	$articulo = new Articulo;
    	//idcategoria va a ser igual a lo que obtenemos del parametro request
    	$articulo->idcategoria=$request->get('idcategoria'); 
    	$articulo->codigo=$request->get('codigo'); 
    	$articulo->nombre=$request->get('nombre');
    	$articulo->stock=$request->get('stock');
    	$articulo->descripcion=$request->get('descripcion');
    	$articulo->estado='Activo';  //Se almacena como Activo, cuando se elimina se pone Inactivo
    	//cargamos la imagen
    	//Si no está vacía
    	if (Input::hasFile('imagen')){
    		$file=Input::file('imagen'); //Almacenamos la imagen en file
    		//Que file sea movido a la carpeta imagenes en public y obtenemos esa imagen
    		$file->move(public_path().'/imagenes/articulos/',$file->getClientOriginalName());
    		$articulo->imagen=$file->getClientOriginalName();
    	}
    	$articulo->save(); //Llamamos al objeto save para almacenar
    	return Redirect::to('almacen/articulo'); //Redirecionamos a la URL almacen/articulo (vista)
    }

/*******************************************************************************************************************************************************************************************************************************/

    //Inicialmente vamos a recibir un parámetro que será el id del articulo que quiero mostrar
    public function show($id)
    {
    	//El artículo que voy a mostrar sera igual a mi modelo Articulo
    	//Llamame a esta vista pero enviale este articulo (id) para que la muestre
    	return view("almacen.articulo.show",["articulo"=>Articulo::findOrFail($id)]);
    }

/*******************************************************************************************************************************************************************************************************************************/

    //Los mismo de arriba, vamos a modificar los datos de un articulo especifico
    //Y los almacenamos con la funcion update
    public function edit($id)
    {
    	//Implementamos una variable que haga referencia al objeto articulo para poder seleccionar solo un articulo especifico
    	$articulo=Articulo::findOrFail($id);
    	$categorias=DB::table('categoria')->where('condicion','=','1')->get();
    	return view("almacen.articulo.edit",["articulo"=>$articulo,"categorias"=>$categorias]);
    }

/*******************************************************************************************************************************************************************************************************************************/

    //Vamos a recibir dos parámetros, ArticuloFormRequest y el id
    					  //Primero valido los datos antes de recibirlos
    public function update(ArticuloFormRequest $request, $id) //Este id se compara con el id del Modelo el que dice 'primaryKey'
    {
    	$articulo=Articulo::findOrFail($id);
    	$articulo->idcategoria=$request->get('idcategoria'); 
    	$articulo->codigo=$request->get('codigo'); 
    	$articulo->nombre=$request->get('nombre');
    	$articulo->stock=$request->get('stock');
    	$articulo->descripcion=$request->get('descripcion');
    	//cargamos la imagen
    	//Si no está vacía
    	if (Input::hasFile('imagen')){
    		$file=Input::file('imagen'); //Almacenamos la imagen en file
    		//Que file sea movido a la carpeta imagenes en public y obtenemos esa imagen
    		$file->move(public_path().'/imagenes/articulos/',$file->getClientOriginalName());
    		$articulo->imagen=$file->getClientOriginalName();
    	}
    	$articulo->update();
    	return Redirect::to('almacen/articulo');
    }

/*******************************************************************************************************************************************************************************************************************************/

    //Recibimos como parametro de entrada el id
    public function destroy($id)
    {
    	//Hacemos un update de nuestro campo 'estado'
    	//Que me seleccione el articulo cuyo id estoy recibiendo por parametro
    	$articulo=Articulo::findOrFail($id);
    	$articulo->estado='Inactivo';
    	$articulo->update();
    	return Redirect::to('almacen/articulo');
    }
}
