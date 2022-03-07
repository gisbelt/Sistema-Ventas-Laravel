@extends ('layouts/admin')
<!-- Seccion en la que vamos a mostrar el contenido -->
<!-- Lo que está en layouts/admin.blade.php que dice @yield('contenido') -->
@section ('contenido')
	<div class="row">
		<div class="col-lg-12 col-md-6 col-sm-6 col-xs-2">
			<h3>Nueva Venta</h3>
			<a href="/ventas/venta" class="btn btn-info pull-right">Regresar a Ventas</a>
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

	{!! Form::Open(array('url'=>'ventas/venta','method'=>'post','autocomplete'=>'off'))!!}
	{{Form::token()}}

	<!-- Venta -->
	<div class="row">
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">			
			<div class="form-group">
				<label for="proveedor">Cliente</label> <!-- Usaremos JavaScript -->
				<!-- El "selectpicker" y el data-live-search="true" son del bootstrap-select que descargamos (en la caja de texto está explicado) -->
				<select name="idcliente" id="idcliente" class="form-control selectpicker" data-live-search="true">
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
				<!-- El "serie_comprobante" va a ser recibido por VentaFormRequest y también será usado por VentaController en el método store-->
				<!-- El value es para por si el usuario ingresa una cantidad muy grande, se valida con el request y el request regresa a esta vista -->
				<input type="text" name="serie_comprobante" value="{{old('serie_comprobante')}}" class="form-control" placeholder="Serie Comprobante..."> 
			</div>	
		</div>

		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<div class="form-group">
				<label for="num_comprobante">Número Comprobante</label>
				<!-- El "num_comprobante" va a ser recibido por VentaFormRequest y también será usado por VentaController en el método store-->
				<!-- El value es para por si el usuario ingresa una cantidad muy grande, se valida con el request y el request regresa a esta vista -->
				<input type="text" name="num_comprobante" required value="{{old('num_comprobante')}}" class="form-control" placeholder="Número Comprobante..."> 
			</div>	
		</div>
	</div> <!-- Cerramos el row aquí para hacer un apartado para los detalles ingreso -->


<!-- *************************************************************************************************************************************************************************** -->
	
	<!-- Detalles Venta -->
	<div class="row"> 
		<!-- Agregamos un panel de bootstrap -->
		<div class="panel panel-primary">
			<div class="panel-body">
				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">	
					<div class="form-group">
						<label>Artículo</label><!-- Usaremos JavaScript -->
						<!-- Colocamos pidarticulo porque este no será el array sino que será como un objeto auxiliar que permita ingresar para cargarlo después al detalle -->
						<!-- El "selectpicker" y el data-live-search="true" son del bootstrap-select que descargamos (en la caja de texto está explicado) -->
						<select name="pidarticulo" id="pidarticulo" class="form-control selectpicker" data-live-search="true"> <!-- pidarticulo porque no es el array, después se creará un objeto input que sea el array de todos los idarticulos que tiene este detalle  -->
						<!-- En el método create del controlador, estamos enviando a persona y articulo -->
						<!-- Pero en el value vamos a enviar, tanto el árticulo, su código, como el stock y el precio_venta, los tres los vamos a enviar en el valor -->
						<!-- Eso lo hacemos En javascript utilizando un split y diremos que el split (la diferencia entre un valor y otro) -->
						<!-- va a ser mediante el guion bajo, con el codigo javascrip separamos esos tres valores para poder utilizarlos -->
						@foreach ($articulos as $articulo)		  <!-- codigo, stock y total_venta (total_promedio) -->
						<option value="{{$articulo->idarticulo}}_{{$articulo->stock}}_{{$articulo->precio_promedio}}">{{$articulo->articulo}}</option>
						@endforeach 
				</select>
					</div>
				</div>	

				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">	
					<div class="form-group">
						<label for="cantidad">Cantidad</label>
						<!-- El "cantidad" va a ser recibido por VentaFormRequest y también será usado por VentaController en el método store-->
						<input type="number" name="pcantidad" id="pcantidad" class="form-control" placeholder="Cantidad..."> 
					</div>
				</div>

				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">	
					<div class="form-group">
						<!-- También tendremos el stock ya que vamos a validar que la cantidad que vamos a vender (que está arriba)  -->
						<!-- sea menor que el stock	 -->
						<label for="stock">Stock</label>	
						<!-- Lo que se muestre aquí es el id que nos enviarmos desdes el select de "Artículo" que está arriba -->
						<!-- El cual nos los enviaros por -javaScript -->
						<input type="number" name="pstock" id="pstock" disabled class="form-control" placeholder="Stock..."> 
					</div>
				</div>

				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">	
					<div class="form-group">
						<label for="precio_ventas">Precio Venta</label>
						<!-- El "precio_ventas" va a ser recibido por VentaFormRequest y también será usado por VentaController en el método store-->
						<input type="number" name="pprecio_ventas" disabled id="pprecio_ventas" class="form-control" placeholder="P. Venta..."> 
					</div>
				</div>

				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">	
					<div class="form-group">
						<label for="descuento">Descuento</label>
						<!-- El "Descuento" va a ser recibido por VentaFormRequest y también será usado por VentaController en el método store-->
						<input type="number" name="pdescuento" id="pdescuento" class="form-control" placeholder="Descuento..."> 
					</div>
				</div>
<!-- 
				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">	
					<div class="form-group">
						<label for="precio_compra">Precio Compra</label>
						 El "cantidad" va a ser recibido por IngresoFormRequest y también será usado por IngresoController en el método store
						<input type="number" name="pprecio_compra" id="pprecio_compra" class="form-control" placeholder="P. Compra..."> 
					</div>
				</div> -->
				
				<!-- Botón -->
				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">	
					<div class="form-group">
						<!-- Cuando hagas click a este botón va a haber un JS que va a reconocer ese click y todos los datos pasarán a ser parte del detalle y se mostrarán en la tabla de abajo-->
						<button class="btn btn-primary" type="button" id="bt_add">Agregar</button>
					</div>
				</div>
				<!-- Botón -->

				<!-- Tabla detalles -->
				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
					<table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
						<thead style="background-color:#A9D0F5">
							<th>Opciones</th>
							<th>Articulo</th>
							<th>Cantidad</th>
							<th>Precio Venta</th>
							<th>Precio Descuento</th>
							<th>Subtotal</th>
						</thead>
						<tfoot>
							<th>Total</th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th>
								<!-- Mediante el id identificamos que dentro del h4 se irá actualizando dependiendo del total de esa venta -->
								<h4 id="total">Bsf/. 0.00</h4>
								<!-- Agregamos un input para enviar el valor de total_venta al controlador -->
								<input type="hidden" name="total_venta" id="total_venta">
							</th>
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

<!-- *************************************************************************************************************************************************************************** -->
	
	<!-- JavaScript -->
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

		// Mi select (pidarticulo) cuando se modifque, llame a una funcion que se va a llamar mostrarValores
		// Cada vez que el usuario seleccione un articulo diferente en el select, 
		// este enviará el stock y el precio venta separados por _  y su valor los asignará a su input correspondiente mediante su id
		$("#pidarticulo").change(mostrarValores);
		// Declaramos la funcion mostrar Valores
		function mostrarValores(){
			datosArticulo=document.getElementById('pidarticulo').value.split('_');
			$("#pstock").val(datosArticulo[1]);
			$("#pprecio_ventas").val(datosArticulo[2]);
		}


		function agregar()
		{
			datosArticulo=document.getElementById('pidarticulo').value.split('_');

			//Leemos todos los valores que hay en detalle venta  antes de la tabla detalle
			// El idarticulo está en la posicion 0
			idarticulo=datosArticulo[0];
			articulo=$("#pidarticulo option:selected").text(); //De mi idarticulo, el texto que esté seleccionado
			cantidad=$("#pcantidad").val();
			precio_ventas=$("#pprecio_ventas").val();
			descuento=$("#pdescuento").val();
			stock=$("#pstock").val();

			//Validamos
			if (idarticulo!="" && cantidad!="" && cantidad>"0" && precio_ventas!="" && stock!="")
			{
				// Validamos también que el stock sea mayor o igual que la cantidad que se está vendiendo
				if(stock>=cantidad)
				{
					//Subtotal en la posición cont=0
					subtotal[cont]=(cantidad*precio_ventas-descuento);
					//Acumudalor, Por cada detalle calculo un subtotal y ese subtotal lo agrego al total
					total=total+subtotal[cont]; 

					//Todo en una sola fila, en el orden en el que está la tabla detalle
					var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+')">X</button></td><td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+idarticulo+'</td><td><input type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input type="number" name="precio_ventas[]" value="'+precio_ventas+'"></td><td><input type="number" name="descuento[]" value="'+descuento+'"></td><td>'+subtotal[cont]+'</td></tr>' //Esto para que nos permita eliminar
					//El contador se actualiza para que pueda agregar nuevas filas y se vaya sumando
					cont++; 
					limpiar();
					//id total que está en la última columna de la tabla detalle
					$("#total").html("Bsf/. "+ total);
					$("#total_venta").val(total);
					evaluar();
					//Después de evaluar, agrega la fila a la tabla, que tiene el id detalles
					$('#detalles').append(fila); 
				}	
				else
				{
					alert("La cantidad a vender supera el STOCK");
				}		
			}
			else
			{
				alert("Error al ingresar el detalle de la venta, revise los datos del artículo");
			}
		}

		function limpiar(){
			$("#pcantidad").val("");
			$("#pdescuento").val("");
			$("#pprecio_ventas").val("");
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
			$("#total_venta").val(total);
			$("#fila"+ index).remove();
			evaluar();
		}

		</script>
	@endpush
@endsection