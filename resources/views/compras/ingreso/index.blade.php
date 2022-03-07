@extends ('layouts/admin')
<!-- Seccion en la que vamos a mostrar el contenido -->
<!-- Lo que está en layouts/admin.blade.php que dice @yield('contenido') -->
@section ('contenido')
	<div class="row">
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Listado de Ingresos <a href="ingreso/create"><button class="btn btn-success">Nuevo</button></a></h3>
			@include('compras/ingreso/search')
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
					<thead>	
						<th>Fecha</th>
						<th>Proveedor</th>
						<th>Comprobante</th> 
						<th>Impuesto</th>
						<th>Total</th>
						<th>Estado</th>
						<th>Opciones</th>
					</thead>
				<!-- Un blucle para que me muestro todos los registros de mi tabla ingreso (con un botón donde se cargarán los detalles de ese ingreso) -->
				@foreach ($ingresos as $ing)			
					<tr>
						<!-- Se utilizan llaves para mostrar -->
						<td>{{ $ing->fecha_hora}}</td>
						<td>{{ $ing->nombre}}</td>		<!-- Concatenamos los comprobantes -->
						<td>{{ $ing->tipo_comprobante.': '.$ing->serie_comprobante.'-'.$ing->num_comprobante}}</td>
						<td>{{ $ing->impuesto}}</td>
						<td>{{ $ing->total}}</td>
						<td>{{ $ing->estado}}</td>
						<td>
							<!-- Cuando haga click en este boton se envian los datos correspondientes a la vista para que puedan mostrados -->
							<!-- Le indicamos al controlador que usaremos el metodo show y nos mande el id del ingreso y este id se comparará con el modelo-->
							<!-- vamos a mostrar sus ingresos como sus detalles -->
							<a href="{{URL::action('IngresoController@show',$ing->idingreso)}}"><button class="btn btn-primary">Detalles</button></a>
							<!-- Hacemos referencia al div que está en modal.blade.php. El id de ese modal o div es modal-delete-@ingidingreso. El id del ingreso que quiero cancelar -->
							<!-- Por cada ingreso que este en el listado se creara un div modal -->
							<a href="" data-target="#modal-delete-{{$ing->idingreso}}" data-toggle="modal"><button class="btn btn-danger">Anular</button></a> 
						</td>
					</tr>
					@include('compras.ingreso.modal')
				@endforeach
				</table>
			</div> <!-- Fuera del div de la table-responsive, vamos a mostrar la paginacion -->
			<!-- Llamamos al metodo render que es el metodo que nos va a permitir paginar -->
			{{$ingresos->render()}}
		</div>
	</div>
@endsection