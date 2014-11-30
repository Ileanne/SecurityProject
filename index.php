<?php
session_start();
include('rsa.php');
$rsa = new RSA();
if (isset($_POST['dato_secreto'])) {
	$dato = trim($_POST['dato_secreto']);
	echo "<p>Se ha recibido: <strong>" . htmlspecialchars($dato) . "</strong></p>";
	$keys = $_SESSION['RSA_KEYS'];
	$e = $keys['publica'];
	$d = $keys['privada'];
	$m = $keys['modulo'];
	$dato_descifrado = $rsa->DesencriptarTexto($dato, $d, $m);
} else {
	$keys = $rsa->GenerarClaves();
	$_SESSION['RSA_KEYS'] = $keys;
	$e = $keys['publica'];
	$d = $keys['privada'];
	$m = $keys['modulo'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Env&iacute;o de Dato Secreto</title>
	<style type="text/css">
		body {
			font-family:Verdana, Geneva, Tahoma, sans-serif;
			font-size:12px;
		}
		
		div#wrapper {			
			color:#005;
			border:1px #005 solid;
			background-color:#DDF;
			width:1024px;
			margin:0 auto;
			padding:10px;
		}
	</style>
	
	<script type="text/javascript" language="javascript" src="./js/jquery.js"></script>
	<script type="text/javascript" language="javascript" src="./js/base64.js"></script>
	<script type="text/javascript" language="javascript" src="./js/bigint.js"></script>
	<script type="text/javascript" language="javascript" src="./js/rsa.js"></script>
	<script language="javascript" type="text/javascript">
	function eliminarBlancos(cadena) {
		for (i=0; i<cadena.length; ) {
			if (cadena[i] == " ")
				cadena = cadena.substring(i+1, cadena.length);
			else
				break;
		}
	
		for (i=cadena.length-1; i>=0; i=cadena.length-1)	{
			if (cadena[i] == " ")
				cadena = cadena.substring(0,i);
			else
				break;
		}
		
		return cadena;
	}
	
	$(function() {
		$('#formulario').submit(function() {
			var mensaje = $('#dato_secreto').val();
			var e = '<?php echo $e; ?>';
			var m = '<?php echo $m; ?>';
			mensaje = eliminarBlancos(mensaje);
			if (mensaje.length > 0) {
				$('#dato_secreto').val(RSA.encriptar(mensaje, e, m));
				return true;
			} else {
				return false;
			}
		});	
	});
	</script>
</head>

<body>
	<div id="wrapper">
		<?php if (isset($dato)) : ?>
		<p>
			Se ha recibido:
			<strong><?php echo $dato; ?></strong>
		</p>
		<p>
			El dato descifrado es:
			<strong><?php echo $dato_descifrado; ?></strong><br />
		</p>
		<?php else: ?>	
		<form action="index.php" method="post" name="formulario" id="formulario">
			<label for="dato_secreto">Ingresate algo que quieres que se encripte...</label>
			<input type="text" name="dato_secreto" id="dato_secreto" />
			<input type="submit" value="Enviar" name="enviar" />
		</form>
		<?php endif; ?>
	</div>
</body>

</html>
