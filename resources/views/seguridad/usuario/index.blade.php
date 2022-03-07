@extends ('layouts/admin')
<!-- Seccion en la que vamos a mostrar el contenido -->
<!-- Lo que está en layouts/admin.blade.php que dice @yield('contenido') -->
@section ('contenido')
	<div class="row">
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Listado de Usuarios <a href="usuario/create"><button class="btn btn-success">Nuevo</button></a></h3>
			@include('seguridad/usuario/search')
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
					<thead>	
						<th>Id</th>
						<th>Nombre</th>
						<th>Email</th>
						<th>Opciones</th>
					</thead>
				<!-- Un blucle para que me muestro todos los registros de mi tabla usuario -->
				@foreach ($usuarios as $usu)			
					<tr>
						<!-- Se utilizan llaves para mostrar -->
						<td>{{ $usu->id}}</td>
						<td>{{ $usu->name}}</td>
						<td>{{ $usu->email}}</td>
						<td>
							<!-- Cuando haga click en este boton se envian los datos correspondientes a la vista para que puedan editarlos -->
							<!-- Le indicamos al controlador que usaremos el metodo edit y nos mande el id de usuario y este id se comparará con el que está en el modelo-->
							<a href="{{URL::action('UsuarioController@edit',$usu->id)}}"><button class="btn btn-info">Editar</button></a>
							<!-- Hacemos referencia al div que está en modal.blade.php. El id de ese modal o div es modal-delete-@usuid. El id del usuario que quiero eliminar -->
							<!-- Por cada usuario que este en el listado se creara un div modal -->
							<a href="" data-target="#modal-delete-{{$usu->id}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a> 
						</td>
					</tr>
					@include('seguridad.usuario.modal')
				@endforeach
				</table>
			</div> <!-- Fuera del div de la table-responsive, vamos a mostrar la paginacion -->
			<!-- Llamamos al metodo render que es el metodo que nos va a permitir paginar -->
			{{$usuarios->render()}}
		</div>
	</div>
@endsection