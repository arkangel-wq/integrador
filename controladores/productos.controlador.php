<?php

class ControladorProductos
{


	/*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/
	static public function ctrMostrarProductos($item, $valor)
	{

		$tabla = "productos";

		$respuesta = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor);

		return $respuesta;
	}

	static public function ctrCrearProducto()
	{
		if (isset($_POST["nuevaDescripcion"])) {
			if (
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaDescripcion"]) &&
				preg_match('/^[0-9]+$/', $_POST["nuevoStock"]) &&
				preg_match('/^[0-9]+$/', $_POST['nuevoPrecioCompra']) &&
				preg_match('/^[0-9]+$/', $_POST['nuevoPrecioVenta'])
			) {

				$ruta = "vistas/img/productos/default/anonymous.png";

				if (isset($_FILES["nuevaImagen"]["tmp_name"])) {

					list($ancho, $alto) = getimagesize($_FILES["nuevaImagen"]["tmp_name"]);

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/

					$directorio = "vistas/img/productos/" . $_POST["nuevoCodigo"];

					mkdir($directorio, 0755);

					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if ($_FILES["nuevaImagen"]["type"] == "image/jpeg") {

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100, 999);

						$ruta = "vistas/img/productos/" . $_POST["nuevoCodigo"] . "/" . $aleatorio . ".jpg";

						$origen = imagecreatefromjpeg($_FILES["nuevaImagen"]["tmp_name"]);

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);
					}

					if ($_FILES["nuevaImagen"]["type"] == "image/png") {

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100, 999);

						$ruta = "vistas/img/productos/" . $_POST["nuevoCodigo"] . "/" . $aleatorio . ".png";

						$origen = imagecreatefrompng($_FILES["nuevaImagen"]["tmp_name"]);

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);
					}
				}

				//envio de datos

				$tabla = "productos";
				$datos = array(
					"id_categoria" => $_POST["nuevaCategoria"],
					"codigo" => $_POST["nuevoCodigo"],
					"descripcion" => $_POST["nuevaDescripcion"],
					"stock" => $_POST['nuevoStock'],
					"precio_compra" => $_POST['nuevoPrecioCompra'],
					"precio_venta" => $_POST['nuevoPrecioVenta'],
					"imagen" => $ruta
				);
				$respuesta = ModeloProductos::mdlIngresarProducto($tabla, $datos);
				if ($respuesta == "ok") {

					echo '<script>

					Swal.fire({
							  title: "Success!",
							  text: "¡Se registrado un producto correctamente!",
							  icon: "success",
							  confirmButtonText: "Ok"
						
							}).then((result)=>{
								if(result.value){
							window.location = "Productos";
								}
							});

				</script>';
				}
			} else {
				//echo ('<script>alert ("ingreso");</script>');
				echo ("<script>

					Swal.fire({
							  title: 'Error!',
							  text: '¡Comprueba los datos!',
							  icon: 'error',
							  confirmButtonText: 'Ok'
						
							});

				</script>");
			}
		}
	}

	static public function ctrEditarProducto()
	{
		if (isset($_POST["editarDescripcion"])) {
			if (
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarDescripcion"]) &&
				preg_match('/^[0-9]+$/', $_POST["editarStock"]) &&
				preg_match('/^[0-9]+$/', $_POST['editarPrecioCompra']) &&
				preg_match('/^[0-9]+$/', $_POST['editarPrecioVenta'])
			) {

				$ruta = $_POST["imagenActual"];
				if (isset($_FILES["editarImagen"]["tmp_name"])) {

					list($ancho, $alto) = getimagesize($_FILES["editarImagen"]["tmp_name"]);

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/

					$directorio = "vistas/img/productos/" . $_POST["editarCodigo"];

					/*=============================================
					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					=============================================*/

					if (!empty($_POST["imagenActual"]) && $_POST["imagenActual"] != "vistas/img/productos/default/anonymous.png") {

						unlink($_POST["imagenActual"]);
					} else {

						mkdir($directorio, 0777);
					}

					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if ($_FILES["editarImagen"]["type"] == "image/jpeg") {

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100, 999);

						$ruta = "vistas/img/productos/" . $_POST["editarCodigo"] . "/" . $aleatorio . ".jpg";

						$origen = imagecreatefromjpeg($_FILES["editarImagen"]["tmp_name"]);

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);
					}

					if ($_FILES["editarImagen"]["type"] == "image/png") {

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100, 999);

						$ruta = "vistas/img/productos/" . $_POST["editarCodigo"] . "/" . $aleatorio . ".png";

						$origen = imagecreatefrompng($_FILES["editarImagen"]["tmp_name"]);

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);
					}
				}

				//envio de datos

				$tabla = "productos";
				$datos = array(
					"id_categoria" => $_POST["editarCategoria"],
					"codigo" => $_POST["editarCodigo"],
					"descripcion" => $_POST["editarDescripcion"],
					"stock" => $_POST['editarStock'],
					"precio_compra" => $_POST['editarPrecioCompra'],
					"precio_venta" => $_POST['editarPrecioVenta'],
					"imagen" => $ruta
				);
				$respuesta = ModeloProductos::mdlEditarProducto($tabla, $datos);
				if ($respuesta == "ok") {

					echo '<script>

					Swal.fire({
							  title: "Success!",
							  text: "¡El producto ha sido editado correctamente!",
							  icon: "success",
							  confirmButtonText: "Ok"
						
							}).then((result)=>{
								if(result.value){
							window.location = "Productos";
								}
							});

				</script>';
				}
			} else {
				//echo ('<script>alert ("ingreso");</script>');
				echo ("<script>

					Swal.fire({
							  title: 'Error!',
							  text: '¡El producto no puede ir con los campos vacios o caracteres especiales!',
							  icon: 'error',
							  confirmButtonText: 'Ok'
						
							});

				</script>");
			}
		}
	}

	/*=============================================
	BORRAR PRODUCTO
	=============================================*/
	static public function ctrEliminarProducto()
	{

		if (isset($_GET["idProducto"])) {

			$tabla = "productos";
			$datos = $_GET["idProducto"];

			if ($_GET["imagen"] != "" && $_GET["imagen"] != "vistas/img/productos/default/anonymous.png") {

				unlink($_GET["imagen"]);
				rmdir('vistas/img/productos/' . $_GET["codigo"]);
			}

			$respuesta = ModeloProductos::mdlEliminarProducto($tabla, $datos);

			if ($respuesta == "ok") {

				echo "<script>
                Swal.fire({
                title: 'Success!',
                text: '¡El Producto ha sido borrado correctamente!',
                icon: 'success',
                confirmButtonText:'Ok'
                }).then((result)=>{
                if(result.value){
                 window.location = 'Productos';
                 }
                 })
            </script>";
			}
		}
	}
}