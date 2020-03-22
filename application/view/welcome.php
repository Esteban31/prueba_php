<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Prueba PHP</title>
</head>
<body>
	<center>
		<h2>Prueba PHP</h2>
	</center>
	<ul>
		<li><?=N_A?></li>
		<li><?=D_A?></li>
		<li><?=C_A?></li>
	</ul>
	<p>Para ejecutar puedes usar postman u otro programa para consumir servicios rest, copia la URL base a continuación <strong><?=$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]?> </strong> y luego concatena a esa URL con la del servicio solicitado</p>
	<br>

	<p>La base de datos está en la carpeta de <em>application/public/bd/prueba_php</em> el nombre de la base de datos al ser importada debe de ser <strong>prueba_php</strong></p>
	
	<hr>

	<h4>Obtener productos (GET)</h4>
	<ul>
		<li><em>Rest/get_products/all</em></li>
	</ul>

	<hr>


	<h4>Obtener productos por parámetro (id, categories o reference) (GET)</h4>
	<ul>
		<li><em>Rest/get_products/tipo/parametro</em></li>
	</ul>
	
	<hr>

	<h4>Agregar nuevo producto (POST)</h4>
	<p>Para registrar un producto pon en el cuerpo de la solicitud cada campo en inglés (name, reference, price, weight, category, stock) la fecha se registrará automáticamente</p>
	<ul>
		<li><em>Rest/add_product</em></li>
	</ul>
	
	<hr>


	<h4>Actualizar Producto (PUT)</h4>
	<p>El cuerpo de la solicitud debes armar un JSON con los campos a actualizar, que serían (name, reference, price, weight, category, stock y creation_date) en la URL debemos indicar el producto a actualizar, el cual debemos indicar el id del mismo </p>
	
	<p>ejemplo json</p>

	{	
		"name":"honda navi",
		"reference":"65451654",
		"price":"4100000",
		"weight":"90",
		"category":"vehiculoeditado",
		"stock":"54",
		"creation_date":"2020-03-21"
	}

	<ul>
		<li><em>Rest/update_product/id</em></li>
	</ul>

	<hr>

	<h4>Eliminar Producto (GET)</h4>
	<p>Para eliminar un producto solo basta en indicar en la URL el id del producto</p>
	<ul>
		<li><em>Rest/delete_product/id_producto</em></li>
	</ul>

	<hr>

	<h4>Realiza compra (POST)</h4>
	<p>Para registrar una compra de un producto, debemos indicar el id del producto y la cantidad</p>
	<ul>
		<li><em>Rest/add_purchase/id_producto/cantidad</em></li>
	</ul>

</body>
</html>