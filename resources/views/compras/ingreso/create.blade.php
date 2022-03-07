@extends ('layouts/admin')
<!-- Seccion en la que vamos a mostrar el contenido -->
<!-- Lo que está en layouts/admin.blade.php que dice @yield('contenido') -->
@section ('contenido')
	<div class="row">
		<div class="col-lg-12 col-md-6 col-sm-6 col-xs-2">
			<h3>Nueva Ingreso</h3>
			<a href="/compras/ingreso" class="btn btn-info pull-right">Regresar a Ingresos</a>
			<!-- Como vamos a validar los registros vamos a utiliar LARAVEL para la validación -->
			<!-- En app/Http/Requests/PersonaFormRequest.php haremos las validaciones -->
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

	<!-- La diferencia es que aquí hay dos row -->
	<!-- Enviamos los parámetros de nuestro formulario dentro de un array -->
	<!-- Enviamos la ruta especifica de nuestro formulario (url) que está en app/Http/routes.php -->
	<!-- El controlador sabrá que funcion va a trabajar mediante el método -->

	{!! Form::Open(array('url'=>'compras/ingreso','method'=>'post','autocomplete'=>'off'))!!}
	{{Form::token()}}
	<!-- Ingreso -->
	<div class="row">
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">			
			<div class="form-group">
				<label for="proveedor">Proveedor</label> <!-- Usaremos JavaScript -->
				<!-- El "selectpicker" y el data-live-search="true" son del bootstrap-select que descargamos (en la caja de texto está explicado) -->
				<select name="idproveedor" id="idproveedor" class="form-control selectpicker" data-live-search="true">
					<!-- En el método create del controlador, estamos enviando a persona y articulo -->
					@foreach ($personas as $persona)
					<option value="{{$persona->idpersona}}">{{$persona->nombre}}</option>
					@endforeach
				</select>
			</div>	
		</div>

		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<div class="form-group">
				<label>Tipo Comprobante</label>
				<select name="tipo_comprobante" class="form-control selectpicker" data-live-search="true"> <!-- Recibimos el id mediante PersonaFormRequest -->
						<option value="Boleta">Boleta</option>
						<option value="Factura">Factura</option>
						<option value="Ticket">Ticket</option>
				</select>
			</div>
		</div>

		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<div class="form-group">
				<label for="serie_comprobante">Serie Comprobante</label>
				<!-- El "serie_comprobante" va a ser recibido por IngresoFormRequest y también será usado por IngresoController en el método store-->
				<!-- El value es para por si el usuario ingresa una cantidad muy grande, se valida con el request y el request regresa a esta vista -->
				<input type="text" name="serie_comprobante" value="{{old('serie_comprobante')}}" class="form-control" placeholder="Serie Comprobante..."> 
			</div>	
		</div>

		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<div class="form-group">
				<label for="num_comprobante">Número Comprobante</label>
				<!-- El "num_comprobante" va a ser recibido por IngresoFormRequest y también será usado por IngresoController en el método store-->
				<!-- El value es para por si el usuario ingresa una cantidad muy grande, se valida con el request y el request regresa a esta vista -->
				<input type="text" name="num_comprobante" required value="{{old('num_comprobante')}}" class="form-control" placeholder="Número Comprobante..."> 
			</div>	
		</div>
	</div> <!-- Cerramos el row aquí para hacer un apartado para los detalles ingreso -->

<!-- *************************************************************************************************************************************************************************** -->
	<!-- Detalles Ingreso -->
	<div class="row"> 
		<!-- Agregamos un panel de bootstrap -->
		<div class="panel panel-primary">
			<div class="panel-body">
				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">	
					<div class="form-group">
						<label>Artículo</label><!-- Usaremos JavaScript -->
						<!-- Colocamos pidarticulo porque este no será el array sino que será como un objeto auxiliar que permita ingresar para cargarlo después al detalle -->
						<!-- El "selectpicker" y el data-live-search="true" son del bootstrap-select que descargamos (en la caja de texto está explicado) -->
						<select name="pidarticulo" id="pidarticulo" class="form-control selectpicker" data-live-search="true"> pidarticulo porque no es el array, después se creará un objeto input que sea el array de todos los idarticulos que tiene este detalle 
						<!-- En el método create del controlador, estamos enviando a persona y articulo -->
						@foreach ($articulos as $articulo)		  <!-- codigo y nombre -->
						<option value="{{$articulo->idarticulo}}">{{$articulo->articulo}}</option>
						@endforeach 
				</select>
					</div>
				</div>	

				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">	
					<div class="form-group">
						<label for="cantidad">Cantidad</label>
						<!-- El "cantidad" va a ser recibido por IngresoFormRequest y también será usado por IngresoController en el método store-->
						<input type="number" name="pcantidad" id="pcantidad" class="form-control" placeholder="Cantidad..."> 
					</div>
				</div>

				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">	
					<div class="form-group">
						<label for="precio_compra">Precio Compra</label>
						<!-- El "cantidad" va a ser recibido por IngresoFormRequest y también será usado por IngresoController en el método store-->
						<input type="number" name="pprecio_compra" id="pprecio_compra" class="form-control" placeholder="P. Compra..."> 
					</div>
				</div>

				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">	
					<div class="form-group">
						<label for="precio_venta">Precio Venta</label>
						<!-- El "cantidad" va a ser recibido por IngresoFormRequest y también será usado por IngresoController en el método store-->
						<input type="number" name="pprecio_venta" id="pprecio_venta" class="form-control" placeholder="P. Venta..."> 
					</div>
				</div>
				<!-- Botón -->
				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">	
					<div class="form-group">
						<!-- Cuando hagas click a este botón va a haber un JS que va a reconocer ese click y todos los datos pasarán a ser parte del detalle y se mostrarán en la tabla de abajo-->
						<button class="btn btn-primary" type="button" id="bt_add">Agregar</button>
					</div>
				</div>

				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
					<table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
						<thead style="background-color:#A9D0F5">
							<th>Opciones</th>
							<th>Articulo</th>
							<th>Cantidad</th>
							<th>Precio Compra</th>
							<th>Precio Venta</th>
							<th>Subtotal</th>
						</thead>
						<tfoot>
							<th>Total</th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th><h4 id="total">Bsf/. 0.00</h4></th><!-- Mediante el id identificamos que dentro del h4 se irá actualizando dependiendo del total de ese ingreso -->
						</tfoot>
						<tbody>
						</tbody>	
					</table>
				</div>	
			</div>
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" id="guardar">
			<div class="form-group">
				<!-- Este input no importa donde esté, solo no debe estar fuera del form -->
				<!-- Nos permitirá poder trabajar con las transacciones -->
				<input name="_token" value="{{csrf_token()}}" type="hidden">
				<button class="btn btn-primary" type="submit">Guardar</button>
				<button class="btn btn-danger" type="reset">Cancelar</button>
			</div>
		</div>
	</div>
	{!! Form::Close()!!}

	<!-- Antes del endsection trabajaremos con código JavaScript -->
	<!-- Hacemos referencia al stack que agregamos en admin.blade.php en el layouts "@stack('scripts')" -->
	@push ('scripts') 
		<!-- Todo lo que yo coloque aquí, es como si lo estuviera trabajando en donde hemos puesto el @stack('scripts'), osea en admin.blade.php -->
		<script>
		$(document).ready(function(){
			$('#bt_add').click(function(){
				agregar();
			})
		})
		//Primero crearemos una función que nos permita limpiar las cajas de texto antes de que se agreguen a la tabla detalle
		var cont=0;
		subtotal=[]; //Este array capturará todos los subtotales de cada una de las lineas de los detalles
		total = 0;
		$("#guardar").hide(); //Cuando el documento inicia el botón guardar va a estar oculto

		function agregar(){
			//Leemos todos los valores que hay en detalle ingreso antes de la tabla detalle
			idarticulo=$("#pidarticulo").val();
			articulo=$("#pidarticulo option:selected").text(); //De mi idarticulo, el texto que esté seleccionado
			cantidad=$("#pcantidad").val();
			precio_compra=$("#pprecio_compra").val();
			precio_venta=$("#pprecio_venta").val();

			//Validamos
			if (idarticulo!="" && cantidad!="" && cantidad > 0 && precio_compra!="" && precio_venta!=""){
				//Subtotal en la posición cont=0
				subtotal[cont]=(cantidad*precio_compra);
				total=total+subtotal[cont]; //Acumudalor, Por cada detalle calculo un subtotal y ese subtotal lo agrego al total

				//Todo en una sola fila, en el orden en el que está la tabla detalle
				var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+')">X</button></td><td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+idarticulo+'</td><td><input type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input type="number" name="precio_compra[]" value="'+precio_compra+'"></td><td><input type="number" name="precio_venta[]" value="'+precio_venta+'"></td><td>'+subtotal[cont]+'</td></tr>' //Esto para que nos permita eliminar
				cont++; //El contador se actualiza para que pueda agregar nuevas filas y se vaya sumando
				limpiar();
				//id total que está en la última columna de la tabla detalle
				$("#total").html("Bsf/. "+ total);
				evaluar();
				$('#detalles').append(fila); //Después de evaluar, agrega la fila a la tabla, que tiene el id detalles
			}
			else
			{
				alert("Error al ingresar el detalle del ingreso, revise los datos del artículo");
			}
		}

		function limpiar(){
			$("#pcantidad").val("");
			$("#pprecio_compra").val("");
			$("#pprecio_venta").val("");
		}

		function evaluar(){
			if(total>0)
			{
				$("#guardar").show();
			}
			else
			{
				$("#guardar").hide();
			}
		}

		function eliminar(index){
			total=total-subtotal[index];
			$("#total").html("Bsf/. "+ total);
			$("#fila"+ index).remove();
			evaluar();
		}

		</script>
	@endpush
@endsection