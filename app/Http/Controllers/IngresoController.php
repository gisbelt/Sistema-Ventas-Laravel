<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;

use sisVentas\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisVentas\Http\Requests\IngresoFormRequest;
use sisVentas\Ingreso; //Modelo Ingreso
use sisVentas\DetalleIngreso; //Modelo DetalleIngreso
use DB;

use Carbon\Carbon; //Esto es para poder utilizar el formato de la fecha y hora de nuestra zona horaria
use Response;
use Illuminate\Support\Collection;

class IngresoController extends Controller
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
    	 //Si existe el request obtenemos todo los registros de nuestra tabla ingreso de la BD
    	if($request)
    	{
    		//Esta variable va a determinar cual va a ser el texto de busqueda 
    		//el objeto request utilizando el método 'get'   
    		//La función trim es para borrar los espacios tanto al inicio como al final 			
    		$query=trim($request->get('searchText')); //Va a haber un objeto en un formulario listado donde voy a ingresar el texto de las personas (proveedores) que quiero mostrar para poder realizar busquedas por proveedor
    		//utilizamos la tabla ingreso    		
    		$ingresos=DB::table('ingreso as i')
    		//Unimos la tabla ingreso con la tabla persona y la tabla ingreso con la tabla detalleingreso
    		->join('persona as p','i.idproveedor','=','p.idpersona') //En la tabla ingreo el idproveedor tiene que ser igual al idpersona de la tabla persona
    		->join('detalle_ingreso as di','i.idingreso','=','di.idingreso') //Igual aquí
    		->select('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado',DB::raw('sum(di.cantidad*precio_compra) as total')) //Seleccionamos los campos que queremos mostrar
    		//Campo num_comprobante, comando LIKE, y el texto que vamos a buscar que va a ser la variable query                                       //En los archivos de texto está la explicaión de esta parte (se multiplica)
    		//Los porcentajes significan buscar el texto en cualquier ubicacion de la cadena de textos
    		->where('i.num_comprobante','LIKE','%'.$query.'%') 																							   
    		->orderBy('i.idingreso','desc')
    		->groupBy('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado')
    		->paginate(7) //De cuantos registros vamos a realizar la paginación
    		; //Punto y coma al final
    		//Van a ver tres vistas, una carpeta llamada compras, ingreso y dentro de ingreso una llamada index
    		//A esa vista le vamos a enviar ciertos parámetros, le vamos a enviar ingresos, los ingresos que obtenemos de la variable ingresos 
    		//Y tambien le vamos a enviar el texto de busqueda
    		return view('compras.ingreso.index',["ingresos"=>$ingresos,"searchText"=>$query]); 													
    	}	
    }

/*******************************************************************************************************************************************************************************************************************************/
	
	public function create()
    {
    	//Esto para mostrar todos los proveedores en un listado y que el usuario pueda
    	//seleccionar quien es el proveedores que le está abasteciendo de los artículos almacen
    	$personas=DB::table('persona')->where('tipo_persona','=','Proveedor')->get(); 
    	$articulos= DB::table('articulo as art')
    		->select(DB::raw('CONCAT(art.codigo, "", art.nombre) AS articulo'),'art.idarticulo')
    				//Concatenar el código con el nombre del artículo, para mostrar en una sola columna el codigo con el nombre del articulo
    				//Esto para tambíen mostrar el listado de todos los articulos que el usuario puede seleccionar para que venda
    		->where('art.estado','=','Activo')
    		->get(); //Obtenemos los articulos con el método get
    	return view("compras.ingreso.create",["personas"=>$personas,"articulos"=>$articulos]);
    }											//proveedores

/*******************************************************************************************************************************************************************************************************************************/
    
    //IngresoFormRequest: con esto validamos los datos del formulario que vamos a almacenar tanto en el modelo Ingreso, como DetalleIngreso
    public function store (IngresoFormRequest $request)
    {
        //Iniciamos una transacción, porque en la base de datos primero tenemso que almacenar Ingreso
        //Y luego detalle de Ingreso, pero tienen que almacenarse ambos, ya que puede haber un problema en la red
        try {
            DB::beginTransaction(); //Iniciamos la transaccion

            //Ingreso
            //Creamos un objeto dentro de este objeto ingreso que va a hacer referencia el modelo Ingreso
            $ingreso = new Ingreso;
            $ingreso->idproveedor=$request->get('idproveedor'); //idproveedor va a ser igual a lo que obtenemos del parametro request
            $ingreso->tipo_comprobante=$request->get('tipo_comprobante');
            $ingreso->serie_comprobante=$request->get('serie_comprobante');
            $ingreso->num_comprobante=$request->get('num_comprobante');
            $mytime = Carbon::now('America/Lima'); //Dame la fecha actual,siguendo la zona horaria de Lima
            $ingreso->fecha_hora=$mytime->toDateTimeString(); //Lo convertimos en un formato de fecha y hora 
            $ingreso->impuesto='18';
            $ingreso->estado='A';
            $ingreso->save();

            //Detalle Ingreso
            //Lo almacenamos en variables sencillas (sin objetos) ya que esa variable después será un array (en el while de abajo)
            $idarticulo = $request->get('idarticulo');
            $cantidad = $request->get('cantidad');
            $precio_compra = $request->get('precio_compra');
            $precio_venta = $request->get('precio_venta');
            //No solo es un detalle, es un array de detalles
            $cont = 0; //Para ir recorriendo el array desde cero
            //Este array va a ser enviado desde el formulario RegistroDeIngresos en nuestra vista
            while ($cont < count($idarticulo)) { //Se ejecutará mientras que el contador sea menor que los idarticulo que estoy enviando como array
                $detalle = new DetalleIngreso();
                $detalle->idingreso=$ingreso->idingreso; //idingreso es igual al idingreso de la tabla ingreso de arriba (un idingreso auto generado por la función save)
                $detalle->idarticulo=$idarticulo[$cont]; //idarticulo es igual a lo que obtenemos de la variable de arriba ($idarticulo) desde el modelo en la pocisión cont
                $detalle->cantidad=$cantidad[$cont];
                $detalle->precio_compra=$precio_compra[$cont];
                $detalle->precio_venta=$precio_venta[$cont];
                $detalle->save();
                $cont=$cont+1;
            }

            DB::commit(); //Finalizamos la transacción

        } catch (Exception $e) {
            DB::rollback(); //Si hay algún error, anulamos la transaccion
        }

        return Redirect::to('compras/ingreso'); //Redirecionamos a la URL compras/proveedor (vista)
    }

/*******************************************************************************************************************************************************************************************************************************/	

    //Inicialmente vamos a recibir un parámetro que será el id del ingreso que quiero mostrar
    public function show($id)
    {
        $ingreso=DB::table('ingreso as i')
            //Unimos la tabla ingreso con la tabla persona y la tabla ingreso con la tabla detalleingreso
            ->join('persona as p','i.idproveedor','=','p.idpersona') //En la tabla ingreo el idproveedor tiene que ser igual al idpersona de la tabla persona
            ->join('detalle_ingreso as di','i.idingreso','=','di.idingreso') //Igual aquí
            ->select('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado',DB::raw('sum(di.cantidad*precio_compra) as total')) //Seleccionamos los campos que queremos mostrar
            ->where('i.idingreso','=',$id) //No queremos todos los ingresos, solo el que sea igual a la variable id que traemos del parámetro        //En los archivos de texto está la explicaión de esta parte     
            ->first(); //Obtener solo el primer ingreso que cumpla con la condición del where
        $detalles=DB::table('detalle_ingreso as d')
            ->join('articulo as a','d.idarticulo','=','a.idarticulo')
            ->select('a.nombre as articulo','d.cantidad','d.precio_compra','d.precio_venta')
            ->where('d.idingreso','=',$id)
            ->get(); //Obtenmos los detalles de ese ingreso                                                                          
        //Llamame a esta vista pero enviale este ingreso y detalleingreso 
        return view("compras.ingreso.show",["ingreso"=>$ingreso,"detalles"=>$detalles]);
    }

/*******************************************************************************************************************************************************************************************************************************/

    //Recibimos el id para determinar cual es el ingreso que deseo cancelar
    public function destroy($id)
    {
        $ingreso=Ingreso::findOrFail($id);
        $ingreso->Estado='C';
        $ingreso->update();
        return Redirect::to('compras/ingreso');
    }
}
