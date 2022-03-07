@extends ('layouts/admin')
<!-- Seccion en la que vamos a mostrar el contenido -->
<!-- Lo que está en layouts/admin.blade.php que dice @yield('contenido') -->
@section ('contenido')
	<div class="row">
		<div class="col-lg-12 col-md-6 col-sm-6 col-xs-2">
			<h3>Editar Proveedor: {{ $persona->nombre}}</h3> <!-- En el método editar tenemos la variable articulo -->
			<!-- Como vamos a validar los registros vamos a utiliar LARAVEL para la validación -->
			<!-- En app/Http/Request/ArticuloFormRequest.php haremos las validaciones -->
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

	<!-- El método para comunicarse con el método update es PATCH -->
	<!-- Le enviamos la ruta y la variable que estamos recibiendo como parametro (idpersona)-->
	<!-- El model se refiere al modelo creado app/Persona.php y allí está el idpersona -->
	<!-- Agregamos un nuevo parametro que es file para poder cargar la imagen -->
	{!! Form::model($persona,['method'=>'PATCH','route'=>['compras.proveedor.update',$persona->idpersona]])!!}
	{{Form::token()}}
	<!-- Aquí va a cambiar el "value" de cada uno comparado con create -->
	<div class="row">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">			
			<div class="form-group">
				<label for="nombre">Nombre</label>
				<!-- El "nombre" va a ser recibido por PersonaFormRequest y también será usado por ProveedorController en el método store-->
				<!-- El value es para por si el usuario ingresa una cantidad muy grande, se valida con el request y el request regresa a esta vista -->
				<input type="text" name="nombre" required  value="{{$persona->nombre}}" class="form-control" placeholder="Nombre..."> 
			</div>	
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">			
			<div class="form-group">
				<label for="nombre">Direccion</label>
				<!-- El "nombre" va a ser recibido por PersonaFormRequest y también será usado por ProveedorController en el método store-->
				<!-- El value es para por si el usuario ingresa una cantidad muy grande, se valida con el request y el request regresa a esta vista -->
				<input type="text" name="direccion"  value="{{$persona->direccion}}" class="form-control" placeholder="Direccion..."> 
			</div>	
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label>Documento</label>
				<select name="tipo_documento" class="form-control"> <!-- Recibimos el id mediante PersonaFormRequest -->
						<!-- Si el tipo de documento a DNI, la opcion estara seleccionada -->
						@if ($persona->tipo_documento=='DNI')
						<option value="DNI" selected>DNI</option>
						<option value="RUC">RUC</option>
						<option value="PAS">PAS</option>
						@elseif ($persona->tipo_documento=='RUC')
						<option value="DNI">DNI</option>
						<option value="RUC" selected>RUC</option>
						<option value="PAS">PAS</option>
						@else
						<option value="DNI">DNI</option>
						<option value="RUC">RUC</option>
						<option value="PAS" selected>PAS</option>
						@endif
				</select>
			</div>
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="num_documento">Número Documento</label>
				<!-- El "nombre" va a ser recibido por PersonaFormRequest y también será usado por ProveedorController en el método store-->
				<!-- El value es para por si el usuario ingresa una cantidad muy grande, se valida con el request y el request regresa a esta vista -->
				<input type="text" name="num_documento" value="{{$persona->num_documento}}" class="form-control" placeholder="Número de documento..."> 
			</div>	
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="telefono">Telefono</label>
				<!-- El "nombre" va a ser recibido por PersonaFormRequest y también será usado por ProveedorController en el método store-->
				<!-- El value es para por si el usuario ingresa una cantidad muy grande, se valida con el request y el request regresa a esta vista -->
				<input type="text" name="telefono"  value="{{$persona->telefono}}" class="form-control" placeholder="Telefono..."> 
			</div>	
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="email">Email</label>
				<!-- El "nombre" va a ser recibido por PersonaFormRequest y también será usado por ProveedorController en el método store-->
				<!-- El value es para por si el usuario ingresa una cantidad muy grande, se valida con el request y el request regresa a esta vista -->
				<input type="text" name="email"  value="{{$persona->email}}" class="form-control" placeholder="Email..."> 
			</div>	
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
					<button class="btn btn-primary" type="submit">Guardar</button>
					<button class="btn btn-danger" type="reset">Cancelar</button>
			</div>
		</div>
	</div>
				
	{!! Form::close()!!}

	
@endsection