<!-- Aquí va a preguntar si realmete desea eliminar la categoría -->
<!-- También le agregamos un atributo id al div para que por cada registro que tengamos en el listado 
se me va a generar un div --> 
<!-- Este código estará incluido en el index.blade.php -->
<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{$cat->idcategoria}}">
	<!-- Hacemos referencia al método destroy en el controlador y le enviamos el parámetro idcategoria -->
	<!-- Y el método para que llame al método destroy es "delete" -->
	{{Form::Open(array('action'=>array('CategoriaController@destroy',$cat->idcategoria),'method'=>'delete'))}}
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" arial-label="Close ">
						<span aria-hidden="true">x</span>
					</button>
					<h4 class="modal-title">Eliminar Categoria</h4>
				</div>
				<div class="modal-body">
					<p>Confirme si desea Eliminar la categoria</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary">Confirmar</button>
				</div>		
			</div>
		</div>
	{{Form::Close()}}

</div>