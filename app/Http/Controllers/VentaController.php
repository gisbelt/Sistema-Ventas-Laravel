<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;

use sisVentas\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisVentas\Http\Requests\VentaFormRequest;
use sisVentas\Venta; //Modelo Venta
use sisVentas\DetalleVenta; //Modelo DetalleVenta
use DB;

use Carbon\Carbon; //Esto es para poder utilizar el formato de la fecha y hora de nuestra zona horaria
use Response;
use Illuminate\Support\Collection;

class VentaController extends Controller
{
     //Declaramos un constructor
    public function __construct()
    {
    	//Lo vamos a usar para validar detalle_ventas
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
    		$query=trim($request->get('searchText')); //Va a haber un objeto en un formulario listado donde voy a ingresar el texto de las ventas que quiero mostrar para poder realizar busquedas por ventas
    		//utilizamos la tabla ingreso    		
    		$ventas=DB::table('ventas as v')
    		//Unimos la tabla venta con la tabla persona y la tabla venta con la tabla detalleventa
    		->join('persona as p','v.idcliente','=','p.idpersona') 
    		->join('detalle_ventas as dv','v.idventas','=','dv.idventas') //Igual aquí
    		->select('v.idventas','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta') //Seleccionamos los campos que queremos mostrar
    		//Campo num_comprobante, comando LIKE, y el texto que vamos a buscar que va a ser la variable query                          //Mi tabla venta tiene un campo de total_venta, muestra ese campo
    		//Los porcentajes significan buscar el texto en cualquier ubicacion de la cadena de textos
    		->where('v.num_comprobante','LIKE','%'.$query.'%') 																							   
    		->orderBy('v.idventas','desc')
    		->groupBy('v.idventas','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado')
    		->paginate(7) //De cuantos registros vamos a realizar la paginación
    		; //Punto y coma al final
    		//Van a ver tres vistas, una carpeta llamada ventas, venta y dentro de venta una llamada index
    		//A esa vista le vamos a enviar ciertos parámetros, le vamos a enviar ventas, las ventas que obtenemos de la variable ventas 
    		//Y tambien le vamos a enviar el texto de busqueda
    		return view('ventas.venta.index',["ventas"=>$ventas,"searchText"=>$query]); 													
    	}	
    } 

/*******************************************************************************************************************************************************************************************************************************/
	
	public function create()
    {
    	//Esto para mostrar todos los clientes en un listado y que el usuario pueda
    	//seleccionar quien es el cliente a la que le está haciendo la venta
    	//Un proveedor también puede ser un cliente. Si queremos hacer eso simplemente quitamos el where
    	$personas=DB::table('persona')->where('tipo_persona','=','Cliente')->get(); 
    	
    	// Necesitamos unir la tabla articulo con la table detalle_ingreo para obtener el precio de la venta
    	// Ya que en la tabla articulo no nos muestra el precio de la venta, sino que está en la de detalle_ingreo
    	
    	// Para establecer un precio_ventas actual del producto, hay establecer un precio promedio de 
    	// todos los precios de venta, un precio promedio de ese articulo
    	// Tambien vamos a calcular el precio promedio del articulo, ver todas las veces que ha ingresado a almacen
    	$articulos= DB::table('articulo as art')
    		->join('detalle_ingreso as dv', 'art.idarticulo','=','dv.idarticulo')
    		->select(DB::raw('CONCAT(art.codigo, " ", art.nombre) AS articulo'),'art.idarticulo','art.stock',DB::raw('avg(dv.precio_venta) as precio_promedio'))
    				//El avg nos permite calcular un promedio entre los valores de un campo
					//Calcular el promedio de todos los precios de ventas para establecer a ese precio_ventas oficial el precio del articulo
    				//Concatenar el código con el nombre del artículo, para mostrar en una sola columna el codigo con el nombre del articulo
    				//Esto para tambíen mostrar el listado de todos los articulos que el usuario puede seleccionar para que venda
    		->where('art.estado','=','Activo')
    		->where('art.stock','>','0') //Mayor que 0 porque no voy a mostrar en mi formulario articulos que no tienen stock
    		->groupBy('articulo','art.idarticulo','art.stock')
    		->get(); //Obtenemos los articulos con el método get
    	return view("ventas.venta.create",["personas"=>$personas,"articulos"=>$articulos]);
    											//Clientes
    }

/*******************************************************************************************************************************************************************************************************************************/
    
    //VentaFormRequest: con esto validamos los datos del formulario que vamos a almacenar tanto en el modelo Ingreso, como DetalleIngreso
    public function store (VentaFormRequest $request)
    {
        //Iniciamos una transacción, porque en la base de datos primero tenemso que almacenar Ingreso
        //Y luego detalle de Ingreso, pero tienen que almacenarse ambos, ya que puede haber un problema en la red
        try {
            DB::beginTransaction(); //Iniciamos la transaccion

            //Venta
            //Creamos un objeto dentro de este objeto venta que va a hacer referencia el modelo Venta
            $venta = new Venta;
            $venta->idcliente=$request->get('idcliente'); //idcliente va a ser igual a lo que obtenemos del parametro request
            $venta->tipo_comprobante=$request->get('tipo_comprobante');
            $venta->serie_comprobante=$request->get('serie_comprobante');
            $venta->num_comprobante=$request->get('num_comprobante');
            $venta->total_venta=$request->get('total_venta');
            $mytime = Carbon::now('America/Lima'); //Dame la fecha actual,siguendo la zona horaria de Lima
            $venta->fecha_hora=$mytime->toDateTimeString(); //Lo convertimos en un formato de fecha y hora 
            $venta->impuesto='18';
            $venta->estado='A';
            $venta->save();

            //Detalle Venta
            //Lo almacenamos en variables sencillas (sin objetos) ya que esa variable después será un array (en el while de abajo)
            $idarticulo = $request->get('idarticulo');
            $cantidad = $request->get('cantidad');
            $descuento = $request->get('descuento'); //Será un input con un array de valores en el formulario
            $precio_ventas = $request->get('precio_ventas');
            //No solo es un detalle, es un array de detalles
            $cont = 0; //Para ir recorriendo el array desde cero
            //Este array va a ser enviado desde el formulario RegistroDeVentas en nuestra vista
            while ($cont < count($idarticulo)) { //Se ejecutará mientras que el contador sea menor que los idarticulo que estoy enviando como array
                $detalle = new DetalleVenta();
                $detalle->idventas=$venta->idventas; //idventas es igual al idventas de la tabla ingreso de arriba (un idventa auto generado por la función save)
                $detalle->idarticulo=$idarticulo[$cont]; //idarticulo es igual a lo que obtenemos de la variable de arriba ($idarticulo) desde el modelo en la posición cont
                $detalle->cantidad=$cantidad[$cont];
                $detalle->descuento=$descuento[$cont];
                $detalle->precio_ventas=$precio_ventas[$cont];
                $detalle->save();
                $cont=$cont+1;
            }

            DB::commit(); //Finalizamos la transacción

        } catch (Exception $e) {
            DB::rollback(); //Si hay algún error, anulamos la transaccion
        }

        return Redirect::to('ventas/venta'); //Redirecionamos a la URL ventas/venta  (vista)
    }

/*******************************************************************************************************************************************************************************************************************************/	

    //Inicialmente vamos a recibir un parámetro que será el id de la venta que quiero mostrar
    public function show($id)
    {
        $venta=DB::table('ventas as v')
            //Unimos la tabla venta con la tabla persona y la tabla venta con la tabla detalleventa
            ->join('persona as p','v.idcliente','=','p.idpersona') 
            ->join('detalle_ventas as dv','v.idventas','=','dv.idventas') 
            ->select('v.idventas','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta') //Seleccionamos los campos que queremos mostrar
            ->where('v.idventas','=',$id) //No queremos todas las ventas, solo el que sea igual a la variable id que traemos del parámetro        
            ->first(); //Obtener solo el primer venta que cumpla con la condición del where
        
        $detalles=DB::table('detalle_ventas as d')
            ->join('articulo as a','d.idarticulo','=','a.idarticulo')
            ->select('a.nombre as articulo','d.cantidad','d.descuento','d.precio_ventas')
            ->where('d.idventas','=',$id)
            ->get(); //Obtenmos los detalles de esa venta                                                                          
        //Llamame a esta vista pero enviale esta venta y detalleventa 
        return view("ventas.venta.show",["venta"=>$venta,"detalles"=>$detalles]);
    }

/*******************************************************************************************************************************************************************************************************************************/

    //Recibimos el id para determinar cual es el ingreso que deseo cancelar
    public function destroy($id)
    {
        $venta=Venta::findOrFail($id);
        $venta->Estado='C';
        $venta->update();
        return Redirect::to('ventas/venta');
    }

}
