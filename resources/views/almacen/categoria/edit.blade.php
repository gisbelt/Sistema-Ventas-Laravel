@extends ('layouts/admin')
<!-- Seccion en la que vamos a mostrar el contenido -->
<!-- Lo que está en layouts/admin.blade.php que dice @yield('contenido') -->
@section ('contenido')
	<div class="row">
		<div class="col-lg-12 col-md-6 col-sm-6 col-xs-2">
			<h3>Editar Categoria: {{ $categoria->nombre}}</h3> <!-- En el método editar tenemos la variable categoria -->
			<!-- Como vamos a validar los registros vamos a utiliar LARAVEL para la validación -->
			<!-- En app/Http/Request/CategoriaFormRequest.php haremos las validaciones -->
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

			<!-- El método para comunicarse con el método update es PATCH -->
			<!-- Le enviamos la ruta y la variable que estamos recibiendo como parametro (idcategoria)-->
			<!-- El model se refiere al modelo creado app/Categoria.php y allí está el idcategoria -->
			{{!! Form::model($categoria,['method'=>'PATCH','route'=>['almacen.categoria.update',$categoria->idcategoria]])!!}}
				{{Form::token()}}
				<div class="form-group">
					<label for="nombre">Nombre</label>
					<!-- El "nombre" va a ser recibido por CategoriaFormRequest y también será usado por CategoriaController en el método store-->
					<input type="text" name="nombre" class="form-control" value="{{$categoria->nombre}}" placeholder="Nombre..."> 
				</div>	
				<div class="form-group">
					<label for="descripcion">Descripción</label>
					<input type="text" name="descripcion" class="form-control" value="{{$categoria->descripcion}}" placeholder="Descripcion..."> 
				</div>	
				<div class="form-group">
					<button class="btn btn-primary" type="submit">Guardar</button>
					<button class="btn btn-danger" type="reset">Cancelar</button>
				</div>
			{{!! Form::close()!!}}

		</div>
	</div>
@endsection