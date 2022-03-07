<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
	//esto para mostrar previamente el formulario de acceso al sistema
    return view('auth/login'); 
});

//Creamos una ruta de tipo resourse para hacer un grupo de rutas de recursos
//Con las peticiones index, create, edit, show, update, destroy
//Estas operaciones son las más usadas en laravel y laravel las agrupa
//En una sola ruta de tipo resource y esta ruta va a ligar a un controlador
Route::resource('almacen/categoria','CategoriaController'); 
Route::resource('almacen/articulo','ArticuloController');
Route::resource('ventas/cliente','ClienteController');
Route::resource('compras/proveedor','ProveedorController');
Route::resource('compras/ingreso','IngresoController');
Route::resource('ventas/venta','VentaController');
Route::resource('seguridad/usuario','UsuarioController');
				//Esto lo hacemos dentro de vistas y esa vista ligará 
				//al controlador CategoriaController
				//Cuando estemos trabajando con esta ruta trabajaremos con el controlador CategoriaController
				//Y en el controlador vamos a crear las funciones index, create, etc..


// auth(): Para poder gestionar el acceso a nuestro proyecto
Route::auth();

Route::get('/home', 'HomeController@index');

// Si la ruta no exite o no es una de las anteriores, redirecionamos a
// HomeController y enviamos el index
Route::get('/{slug?}', 'HomeController@index');

