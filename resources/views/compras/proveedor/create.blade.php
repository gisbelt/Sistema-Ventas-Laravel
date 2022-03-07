@extends ('layouts/admin')
<!-- Seccion en la que vamos a mostrar el contenido -->
<!-- Lo que está en layouts/admin.blade.php que dice @yield('contenido') -->
@section ('contenido')
	<div class="row">
		<div class="col-lg-12 col-md-6 col-sm-6 col-xs-2">
			<h3>Nuevo Proveedor</h3>
			<a href="/compras/proveedor" class="btn btn-info pull-right">Regresar a Proveedor</a>
			<!-- Como vamos a validar los registros vamos a utiliar LARAVEL para la validación -->
			<!-- En app/Http/Requests/PersonaFormRequest.php haremos las validaciones -->
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
		</div>
	</div>

	<!-- La diferencia es que aquí hay dos row -->
	<!-- Enviamos los parámetros de nuestro formulario dentro de un array -->
	<!-- Enviamos la ruta especifica de nuestro formulario (url) que está en app/Http/routes.php -->
	<!-- El controlador sabrá que funcion va a trabajar mediante el método -->

	{!! Form::Open(array('url'=>'compras/proveedor','method'=>'post','autocomplete'=>'off'))!!}
	{{Form::token()}}
	<div class="row">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">			
			<div class="form-group">
				<label for="nombre">Nombre</label>
				<!-- El "nombre" va a ser recibido por PersonaFormRequest y también será usado por ProveedorController en el método store-->
				<!-- El value es para por si el usuario ingresa una cantidad muy grande, se valida con el request y el request regresa a esta vista -->
				<input type="text" name="nombre" required  value="{{old('nombre')}}" class="form-control" placeholder="Nombre..."> 
			</div>	
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">			
			<div class="form-group">
				<label for="nombre">Direccion</label>
				<!-- El "nombre" va a ser recibido por PersonaFormRequest y también será usado por ProveedorController en el método store-->
				<!-- El value es para por si el usuario ingresa una cantidad muy grande, se valida con el request y el request regresa a esta vista -->
				<input type="text" name="direccion"  value="{{old('direccion')}}" class="form-control" placeholder="Direccion..."> 
			</div>	
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label>Documento</label>
				<select name="tipo_documento" class="form-control selectpicker" data-live-search="true"> <!-- Recibimos el id mediante PersonaFormRequest -->
						<option value="DNI">DNI</option>
						<option value="RUC">RUC</option>
						<option value="PAS">PAS</option>
				</select>
			</div>
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="num_documento">Número Documento</label>
				<!-- El "nombre" va a ser recibido por PersonaFormRequest y también será usado por ProveedorController en el método store-->
				<!-- El value es para por si el usuario ingresa una cantidad muy grande, se valida con el request y el request regresa a esta vista -->
				<input type="text" name="num_documento" value="{{old('num_documento')}}" class="form-control" placeholder="Número de documento..."> 
			</div>	
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="telefono">Telefono</label>
				<!-- El "nombre" va a ser recibido por PersonaFormRequest y también será usado por ProveedorController en el método store-->
				<!-- El value es para por si el usuario ingresa una cantidad muy grande, se valida con el request y el request regresa a esta vista -->
				<input type="text" name="telefono"  value="{{old('telefono')}}" class="form-control" placeholder="Telefono..."> 
			</div>	
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="email">Email</label>
				<!-- El "nombre" va a ser recibido por PersonaFormRequest y también será usado por ProveedorController en el método store-->
				<!-- El value es para por si el usuario ingresa una cantidad muy grande, se valida con el request y el request regresa a esta vista -->
				<input type="text" name="email"  value="{{old('email')}}" class="form-control" placeholder="Email..."> 
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