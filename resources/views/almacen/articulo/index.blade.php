@extends ('layouts/admin')
<!-- Seccion en la que vamos a mostrar el contenido -->
<!-- Lo que está en layouts/admin.blade.php que dice @yield('contenido') -->
@section ('contenido')
	<div class="row">
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Listado de Articulos <a href="articulo/create"><button class="btn btn-success">Nuevo</button></a></h3>
			@include('almacen/articulo/search')
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
					<thead>	
						<th>Id</th>
						<th>Nombre</th>
						<th>Código</th>
						<th>Categoría</th> <!-- categoría a la que pertenece -->
						<th>Stock</th>
						<th>Imagen</th>
						<th>Estado</th>
						<th>Opciones</th>
					</thead>
				<!-- Un blucle para que me muestro todos los registros de mi tabla articulo -->
				@foreach ($articulos as $art)			
					<tr>
						<!-- Se utilizan llaves para mostrar -->
						<td>{{ $art->idarticulo}}</td>
						<td>{{ $art->nombre}}</td>
						<td>{{ $art->codigo}}</td>
						<td>{{ $art->categoria}}</td>
						<td>{{ $art->stock}}</td>
						<td>
							<!-- Agregamos dentro de un atributo img una imagen haciendo referencia al archivo que está almanecado en nuestra carpeta public -->
							<!-- Con utilizar asset ya estamos indicando que trabajaremos con la carpeta public -->
							<img src="{{asset('imagenes/articulos/'.$art->imagen)}}" alt="{{ $art->nombre}}" height="100px" width="100px" class="img-thumbnail"> <!-- Por si no se carga la img -->
						</td>
						<td>{{ $art->estado}}</td>
						<td>
							<!-- Cuando haga click en este boton se envian los datos correspondientes a la vista para que puedan editarlos -->
							<!-- Le indicamos al controlador que usaremos el metodo edit y nos mande el id de articulo y este id se comparará con el modelo-->
							<a href="{{URL::action('ArticuloController@edit',$art->idarticulo)}}"><button class="btn btn-info">Editar</button></a>
							<!-- Hacemos referencia al div que está en modal.blade.php. El id de ese modal o div es modal-delete-@artidarticulo. El id del articulo que quiero eliminar -->
							<!-- Por cada articulo que este en el listada se creara un div modal -->
							<a href="" data-target="#modal-delete-{{$art->idarticulo}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a> 
						</td>
					</tr>
					@include('almacen.articulo.modal')
				@endforeach
				</table>
			</div> <!-- Fuera del div de la table-responsive, vamos a mostrar la paginacion -->
			<!-- Llamamos al metodo render que es el metodo que nos va a permitir paginar -->
			{{$articulos->render()}}
		</div>
	</div>
@endsection