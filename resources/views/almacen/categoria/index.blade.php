@extends ('layouts/admin')
<!-- Seccion en la que vamos a mostrar el contenido -->
<!-- Lo que está en layouts/admin.blade.php que dice @yield('contenido') -->
@section ('contenido')
	<div class="row">
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Listado de Categorias <a href="categoria/create"><button class="btn btn-success">Nuevo</button></a></h3>
			@include('almacen/categoria/search')
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
					<thead>	
						<th>Id</th>
						<th>Nombre</th>
						<th>Descripcion</th>
						<th>Opciones</th>
					</thead>
				<!-- Un blucle para que me muestro todos los registros de mi tabla categoria -->
				@foreach ($categorias as $cat)			
					<tr>
						<!-- Se utilizan llaves para mostrar -->
						<td>{{ $cat->idcategoria}}</td>
						<td>{{ $cat->nombre}}</td>
						<td>{{ $cat->descripcion}}</td>
						<td>
							<!-- Cuando haga click en este boton se envian los datos correspondientes a la vista para que puedan editarlos -->
							<!-- Le indicamos al controlador que usaremos el metodo edit y nos mande el id de categoria y este id se comparará con el modelo-->
							<a href="{{URL::action('CategoriaController@edit',$cat->idcategoria)}}"><button class="btn btn-info">Editar</button></a>
							<!-- Hacemos referencia al div que está en modal.blade.php. El id de ese modal o div es modal-delete-@catidcategoria. El id de la categoria que quiero eliminar -->
							<!-- Por cada categoria que este en el listada se creara un div modal -->
							<a href="" data-target="#modal-delete-{{$cat->idcategoria}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a> 
						</td>
					</tr>
					@include('almacen.categoria.modal')
				@endforeach
				</table>
			</div> <!-- Fuera del div de la table-responsive, vamos a mostrar la paginacion -->
			<!-- Llamamos al metodo render que es el metodo que nos va a permitir paginar -->
			{{$categorias->render()}}
		</div>
	</div>
@endsection