var RSA = {
	asc : function (str) {
		return str.charCodeAt(0);
	},
	
	chr : function (code) {
		return String.fromCharCode(code);
	},
	
	encriptar : function (mensaje, e, m) {
		mensaje = Base64.encode(mensaje);
		e = str2bigInt(e, 10 , 0);
		m = str2bigInt(m, 10 , 0);
		var i = 0;
		var codificado = new Array();
		var codigo, codBigInt;
		for (i = 0; i < mensaje.length; i++) {
			codigo = RSA.asc(mensaje[i]);
			codBigInt = str2bigInt(codigo.toString(), 10, 0);
			codBigInt = powMod(codBigInt, e, m);
			codificado[codificado.length] = bigInt2str(codBigInt, 10);
		}
		return codificado.join(' ');
	}
}