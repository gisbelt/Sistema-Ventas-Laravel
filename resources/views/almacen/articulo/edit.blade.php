@extends ('layouts/admin')
<!-- Seccion en la que vamos a mostrar el contenido -->
<!-- Lo que está en layouts/admin.blade.php que dice @yield('contenido') -->
@section ('contenido')
	<div class="row">
		<div class="col-lg-12 col-md-6 col-sm-6 col-xs-2">
			<h3>Editar Articulo: {{ $articulo->nombre}}</h3> <!-- En el método editar tenemos la variable articulo -->
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
	<!-- Le enviamos la ruta y la variable que estamos recibiendo como parametro (idarticulo)-->
	<!-- El model se refiere al modelo creado app/Articulo.php y allí está el idarticulo -->
	<!-- Agregamos un nuevo parametro que es file para poder cargar la imagen -->
	{!! Form::model($articulo,['method'=>'PATCH','route'=>['almacen.articulo.update',$articulo->idarticulo],'files'=>'true'])!!}
	{{Form::token()}}
	<div class="row">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">			
			<div class="form-group">
				<label for="nombre">Nombre</label>
				<!-- El "nombre" va a ser recibido por ArticuloFormRequest y también será usado por CategoriaController en el método store-->
				<!-- El value es para por si el usuario ingresa una cantidad muy grande, se valida con el request y el request regresa a esta vista -->
				<input type="text" name="nombre" required  value="{{$articulo->nombre}}" class="form-control"> 
			</div>	
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label>Categoria</label>
				<select name="idcategoria" class="form-control"> <!-- Recibimos el id mediante ArticuloFormRequest -->
					@foreach ($categorias as $cat) <!-- Viene del controlador de articulo en la funcion create -->
						<!-- Agregamos una condicion para que la categoria aparezca ya seleccionada -->
						@if ($cat->idcategoria == $articulo->idcategoria)
						<option value="{{$cat->idcategoria}}" selected>{{$cat->nombre}}</option>
						@else
						<option value="{{$cat->idcategoria}}">{{$cat->nombre}}</option>
						@endif
					@endforeach
				</select>
			</div>
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="codigo">Código</label>
				<!-- El "nombre" va a ser recibido por ArticuloFormRequest y también será usado por CategoriaController en el método store-->
				<!-- El value es para por si el usuario ingresa una cantidad muy grande, se valida con el request y el request regresa a esta vista -->
				<input type="text" name="codigo" required  value="{{$articulo->codigo}}" class="form-control" > 
			</div>	
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="stock">Stock</label>
				<!-- El "nombre" va a ser recibido por ArticuloFormRequest y también será usado por CategoriaController en el método store-->
				<!-- El value es para por si el usuario ingresa una cantidad muy grande, se valida con el request y el request regresa a esta vista -->
				<input type="text" name="stock" required  value="{{$articulo->stock}}" class="form-control"> 
			</div>	
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="descripcion">Descripcion</label>
				<!-- El "nombre" va a ser recibido por ArticuloFormRequest y también será usado por CategoriaController en el método store-->
				<!-- El value es para por si el usuario ingresa una cantidad muy grande, se valida con el request y el request regresa a esta vista -->
				<input type="text" name="descripcion"  value="{{$articulo->descripcion}}" class="form-control" placeholder="Descripcion del artículo..."> 
			</div>	
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="imagen">Imagen</label>
				<!-- El "nombre" va a ser recibido por ArticuloFormRequest y también será usado por CategoriaController en el método store-->
				<!-- El value es para por si el usuario ingresa una cantidad muy grande, se valida con el request y el request regresa a esta vista -->
				<input type="file" name="imagen"  class="form-control"> 
				<!-- Agregamos condicion para mostrar una imagen si el usuario ha cargado una imagen -->
				@if (($articulo->imagen)!="") <!-- Si ya hay una imagen cargada me la muestres en una etiqueta img -->
					<img src="{{asset('imagenes/articulos/'.$articulo->imagen)}}">
				@endif
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