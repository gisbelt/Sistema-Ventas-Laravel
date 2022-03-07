@extends ('layouts/admin')
<!-- Seccion en la que vamos a mostrar el contenido -->
<!-- Lo que está en layouts/admin.blade.php que dice @yield('contenido') -->
@section ('contenido')
	<!-- Antes de empezar este código, eliminamos el primer row y el form porque solo será una vista donde se va a mostrar -->
	<!-- También en la parte detalle ingreso eliminamos todos los div y los botones y el javascript, solo dejamos la tabla y agregamos código en el tbody -->
	<!-- Ingreso -->
	<div class="row">
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">			
			<div class="form-group">
				<label for="proveedor">Proveedor</label> 
				<p>{{$ingreso->nombre}}</p> <!-- En el controlador en la función show, vemos que estamos selecionando el nombre desde la tabla ingreso -->
			</div>	
		</div>

		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<div class="form-group">
				<label>Tipo Comprobante</label>
				<p>{{$ingreso->tipo_comprobante}}</p> 
			</div>
		</div>

		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<div class="form-group">
				<label for="serie_comprobante">Serie Comprobante</label>
				<p>{{$ingreso->serie_comprobante}}</p> 
			</div>	
		</div>

		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<div class="form-group">
				<label for="num_comprobante">Número Comprobante</label>
				<p>{{$ingreso->num_comprobante}}</p> 
			</div>	
		</div>
	</div> <!-- Cerramos el row aquí para hacer un apartado para los detalles ingreso -->

<!-- *************************************************************************************************************************************************************************** -->
	<!-- Detalles Ingreso -->
	<div class="row"> 
		<!-- Agregamos un panel de bootstrap -->
		<div class="panel panel-primary">
			<div class="panel-body">
				
				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
					<table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
						<thead style="background-color:#A9D0F5">
							<th>Articulo</th>
							<th>Cantidad</th>
							<th>Precio Compra</th>
							<th>Precio Venta</th>
							<th>Subtotal</th>
						</thead>
						<tfoot>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th><h4 id="total">{{$ingreso->total}}</h4></th><!-- En el controlador vemos que con esta función: DB::raw('sum(di.cantidad*precio_compra) as total') llamamos al total -->
						</tfoot>
						<tbody>
							<!-- Agregamos un tr multiple dependiendo de los detalles que tenga el ingreso -->
							<!-- Vemos en el controlador en la funcion show llamamos a detalles -->
							@foreach($detalles as $det)
								<tr>
									<td>{{$det->articulo}}</td>
									<td>{{$det->cantidad}}</td>
									<td>{{$det->precio_compra}}</td>
									<td>{{$det->precio_venta}}</td>
									<td>{{$det->cantidad*$det->precio_compra}}</td>
								</tr>
							@endforeach
						</tbody>	
					</table>
				</div>	
			</div>
		</div>
		
	</div>

@endsection