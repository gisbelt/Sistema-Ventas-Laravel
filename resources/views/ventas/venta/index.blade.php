@extends ('layouts/admin')
<!-- Seccion en la que vamos a mostrar el contenido -->
<!-- Lo que está en layouts/admin.blade.php que dice @yield('contenido') -->
@section ('contenido')
	<div class="row">
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Listado de Ventas <a href="venta/create"><button class="btn btn-success">Nuevo</button></a></h3>
			@include('ventas/venta/search')
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
					<thead>	
						<th>Fecha</th>
						<th>Cliente</th>
						<th>Comprobante</th> 
						<th>Impuesto</th>
						<th>Total</th>
						<th>Estado</th>
						<th>Opciones</th>
					</thead>
				<!-- Un blucle para que me muestro todos los registros de mi tabla venta (con un botón donde se cargarán los detalles de esa venta) -->
				@foreach ($ventas as $ven)			
					<tr>
						<!-- Se utilizan llaves para mostrar -->
						<td>{{ $ven->fecha_hora}}</td>
						<td>{{ $ven->nombre}}</td>		<!-- Concatenamos los comprobantes -->
						<td>{{ $ven->tipo_comprobante.': '.$ven->serie_comprobante.'-'.$ven->num_comprobante}}</td>
						<td>{{ $ven->impuesto}}</td>
						<td>{{ $ven->total_venta}}</td>
						<td>{{ $ven->estado}}</td>
						<td>
							<!-- Cuando haga click en este boton se envian los datos correspondientes a la vista para que puedan mostrarlos -->
							<!-- Le indicamos al controlador que usaremos el metodo show y nos mande el id de la venta y este id se comparará con el modelo-->
							<!-- vamos a mostrar sus ventas, como sus detalles -->
							<a href="{{URL::action('VentaController@show',$ven->idventas)}}"><button class="btn btn-primary">Detalles</button></a>
							<!-- Hacemos referencia al div que está en modal.blade.php. El id de ese modal o div es modal-delete-@venidventa. El id de la venta que quiero cancelar -->
							<!-- Por cada venta que este en el listado se creara un div modal -->
							<a href="" data-target="#modal-delete-{{$ven->idventas}}" data-toggle="modal"><button class="btn btn-danger">Anular</button></a> 
						</td>
					</tr>
					@include('ventas.venta.modal')
				@endforeach
				</table>
			</div> <!-- Fuera del div de la table-responsive, vamos a mostrar la paginacion -->
			<!-- Llamamos al metodo render que es el metodo que nos va a permitir paginar -->
			{{$ventas->render()}}
		</div>
	</div>
@endsection