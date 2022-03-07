@extends ('layouts/admin')
<!-- Seccion en la que vamos a mostrar el contenido -->
<!-- Lo que está en layouts/admin.blade.php que dice @yield('contenido') -->
@section ('contenido')
	<div class="row">
		<div class="col-lg-12 col-md-6 col-sm-6 col-xs-2">
			<h3>Nueva Categoria</h3>
			<a href="/almacen/categoria" class="btn btn-info pull-right">Regresar a Categorias</a>
			<br><br>
			<!-- Como vamos a validar los registros vamos a utiliar LARAVEL para la validación -->
			<!-- En app/Http/Request/CategoriaFormRequest.php haremos las validaciones -->
			<!-- Si no se cumple esa validación mostramos algunas alertas -->
			@if (count($errors)>0) <!-- Contamos los errores -->
			<div class="alert alert-danger">
				<!-- Posibles errores que tengamos -->
				<ul>
				@foreach ($errors->all() as $error)		
					<li>{{ $error}}</li>
				@endforeach
				</ul>
			</div>
			@endif

			<!-- Enviamos los parámetros de nuestro formulario dentro de un array -->
			<!-- Enviamos la ruta especifica de nuestro formulario (url) que está en app/Http/routes.php -->
			<!-- El controlador sabrá que funcion va a trabajar mediante el método -->
			<!-- Revisar porque no funciona -->
			{!! Form::open(array('url'=>'almacen/categoria','method'=>'POST','autocomplete'=>'off'))!!}
				{{Form::token()}}
				<div class="form-group">
					<label for="nombre">Nombre</label>
					<!-- El "nombre" va a ser recibido por CategoriaFormRequest y también sera usado por CategoriaController en el método store-->
					<input type="text" name="nombre" class="form-control" placeholder="Nombre..."> 
				</div>	
				<div class="form-group">
					<label for="descripcion">Descripción</label>
					<input type="text" name="descripcion" class="form-control" placeholder="Descripcion..."> 
				</div>	
				<div class="form-group">
					<button class="btn btn-primary" type="submit">Guardar</button>
					<button class="btn btn-danger" type="reset">Cancelar</button>
				</div>
			{!! Form::close()!!}
		</div>
	</div>
@endsection