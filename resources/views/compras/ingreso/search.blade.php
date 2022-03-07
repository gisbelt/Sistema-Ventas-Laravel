<!-- Como esta vista se va a incluir en el archivo index, no va a ser necesario cargar el admin.blade.php porque esta vista estará dentro de index.blade.php-->
<!-- Abrimos un formulario para que envie la informacion de este formulario a la pagina index -->
{!! Form::open(array('url'=>'compras/ingreso','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!} 
<div class="form-group">
	<div class="input-group">
		<input type="text" class="form-control" name="searchText" placeholder="Buscar..." value="{{$searchText}}">
		<span class="input-group-btn">
			<!-- Enviamos lo que se escribe en la caja de texto a la ruta compras/proveedor y esa ruta llamará nuestro método index de nuestro controlador-->
			<button type="submit" class="btn btn-primary">Buscar</button>
		</span>
	</div>
</div>


{{Form::close()}}














