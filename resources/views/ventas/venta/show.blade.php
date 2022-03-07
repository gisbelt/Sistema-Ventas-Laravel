@extends ('layouts/admin')
<!-- Seccion en la que vamos a mostrar el contenido -->
<!-- Lo que está en layouts/admin.blade.php que dice @yield('contenido') -->
@section ('contenido')
	<!-- Antes de empezar este código, eliminamos el primer row y el form porque solo será una vista donde se va a mostrar -->
	<!-- También en la parte detalle venta  eliminamos todos los div y los botones y el javascript, solo dejamos la tabla y agregamos código en el tbody -->
	<!-- Venta -->
	<div class="row">
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">			
			<div class="form-group">
				<label for="cliente">Cliente</label> 
				<p>{{$venta->nombre}}</p> <!-- En el controlador en la función show, vemos que estamos selecionando el nombre desde la tabla venta -->
			</div>	
		</div>

		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<div class="form-group">
				<label>Tipo Comprobante</label>
				<p>{{$venta->tipo_comprobante}}</p> 
			</div>
		</div>

		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<div class="form-group">
				<label for="serie_comprobante">Serie Comprobante</label>
				<p>{{$venta->serie_comprobante}}</p> 
			</div>	
		</div>

		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<div class="form-group">
				<label for="num_comprobante">Número Comprobante</label>
				<p>{{$venta->num_comprobante}}</p> 
			</div>	
		</div>
	</div> <!-- Cerramos el row aquí para hacer un apartado para los detalles ventas -->

<!-- *************************************************************************************************************************************************************************** -->
	<!-- Detalles Ventas -->
	<div class="row"> 
		<!-- Agregamos un panel de bootstrap -->
		<div class="panel panel-primary">
			<div class="panel-body">
				
				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
					<table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
						<thead style="background-color:#A9D0F5">
							<th>Articulo</th>
							<th>Cantidad</th>
							<th>Precio Venta</th>
							<th>Descuento</th>
							<th>Subtotal</th>
						</thead>
						<tfoot>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th><h4 id="total">{{$venta->total_venta}}</h4></th>
						</tfoot>
						<tbody>
							<!-- Agregamos un tr multiple dependiendo de los detalles que tenga la venta -->
							<!-- Vemos en el controlador en la funcion show llamamos a detalles -->
							@foreach($detalles as $det)
								<tr>
									<td>{{$det->articulo}}</td>
									<td>{{$det->cantidad}}</td>
									<td>{{$det->precio_ventas}}</td>
									<td>{{$det->descuento}}</td>
									<td>{{$det->cantidad*$det->precio_ventas-$det->descuento}}</td>
								</tr>
							@endforeach
						</tbody>	
					</table>
				</div>	
			</div>
		</div>
		
	</div>

@endsection