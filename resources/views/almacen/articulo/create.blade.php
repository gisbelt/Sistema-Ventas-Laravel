@extends ('layouts/admin')
<!-- Seccion en la que vamos a mostrar el contenido -->
<!-- Lo que está en layouts/admin.blade.php que dice @yield('contenido') -->
@section ('contenido')
	<div class="row">
		<div class="col-lg-12 col-md-6 col-sm-6 col-xs-2">
			<h3>Nuevo Artículo</h3>
			<a href="/almacen/articulo" class="btn btn-info pull-right">Regresar a Artículos</a>
			<!-- Como vamos a validar los registros vamos a utiliar LARAVEL para la validación -->
			<!-- En app/Http/Request/ArticuloFormRequest.php haremos las validaciones -->
			<!-- Si no se cumple esa validación mostramos algunas alertas -->
			@if (count($errors)>0) <!-- Contamos los errores -->
			<div class="alert alert-danger">
				Posibles errores que tengamos
				<ul>
				@foreach ($errors->all() as $error)		
					<li>{{ $error}}</li>
				@endforeach
				</ul>
			</div>
			@endif
		</div>
	</div>

	<!-- La diferencia es que aquí hay dos row -->
	<!-- Enviamos los parámetros de nuestro formulario dentro de un array -->
	<!-- Enviamos la ruta especifica de nuestro formulario (url) que está en app/Http/routes.php -->
	<!-- El controlador sabrá que funcion va a trabajar mediante el método -->

	{!! Form::Open(array('url'=>'almacen/articulo','method'=>'post','autocomplete'=>'off','file'=>'true'))!!} <!-- Con file le diremos que si nos permita enviar archivos -->
	{{Form::token()}}
	<div class="row">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">			
			<div class="form-group">
				<label for="nombre">Nombre</label>
				<!-- El "nombre" va a ser recibido por ArticuloFormRequest y también será usado por CategoriaController en el método store-->
				<!-- El value es para por si el usuario ingresa una cantidad muy grande, se valida con el request y el request regresa a esta vista -->
				<input type="text" name="nombre" required  value="{{old('nombre')}}" class="form-control" placeholder="Nombre..."> 
			</div>	
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label>Categoria</label>
				<select name="idcategoria" class="form-control"> <!-- Recibimos el id mediante ArticuloFormRequest -->
					@foreach ($categorias as $cat) <!-- Viene del controlador de articulo en la funcion create -->
						<option value="{{$cat->idcategoria}}">{{$cat->nombre}}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="codigo">Código</label>
				<!-- El "nombre" va a ser recibido por ArticuloFormRequest y también será usado por CategoriaController en el método store-->
				<!-- El value es para por si el usuario ingresa una cantidad muy grande, se valida con el request y el request regresa a esta vista -->
				<input type="text" name="codigo" required  value="{{old('codigo')}}" class="form-control" placeholder="Código del artículo..."> 
			</div>	
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="stock">Stock</label>
				<!-- El "nombre" va a ser recibido por ArticuloFormRequest y también será usado por CategoriaController en el método store-->
				<!-- El value es para por si el usuario ingresa una cantidad muy grande, se valida con el request y el request regresa a esta vista -->
				<input type="text" name="stock" required  value="{{old('stock')}}" class="form-control" placeholder="Stock del artículo..."> 
			</div>	
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="descripcion">Descripcion</label>
				<!-- El "nombre" va a ser recibido por ArticuloFormRequest y también será usado por CategoriaController en el método store-->
				<!-- El value es para por si el usuario ingresa una cantidad muy grande, se valida con el request y el request regresa a esta vista -->
				<input type="text" name="descripcion"  value="{{old('descripcion')}}" class="form-control" placeholder="Descripcion del artículo..."> 
			</div>	
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="imagen">Imagen</label>
				<!-- El "nombre" va a ser recibido por ArticuloFormRequest y también será usado por CategoriaController en el método store-->
				<!-- El value es para por si el usuario ingresa una cantidad muy grande, se valida con el request y el request regresa a esta vista -->
				<input type="file" name="imagen"  class="form-control"> 
			</div>	
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
					<button class="btn btn-primary" type="submit">Guardar</button>
					<button class="btn btn-danger" type="reset">Cancelar</button>
			</div>
		</div>
	</div>
	{!! Form::Close()!!}

@endsection