 function dencrypt(){

        var Datas = Parse.Object.extend("DatosEncriptados");
        var query = new Parse.Query(Datas);

        query.equalTo("email", document.getElementById('email').value);
          query.find({
            success: function(results) {
              for (var i = 0; i < results.length; i++) {
                var object = results[i];
                var pass =  object.get('pass');
                var PassPhrase = document.getElementById('email').value; 
                var Bits = 1024; 
                var RSAkey = cryptico.generateRSAKey(PassPhrase, Bits);
                var PublicKeyString = cryptico.publicKeyString(RSAkey);       
                var PlainText = document.getElementById('password').value;
                var EncryptionResult = cryptico.encrypt(PlainText, object.get('publicKey'));
                var DecryptionResult = cryptico.decrypt(pass, RSAkey);


                if(DecryptionResult.plaintext.toString() == PlainText){
                  alert('Usuario Valido');
                }else{
                  alert('usuario invalido o no registrado ');
                }
              }
            },
            error: function(error) {
              alert("Error: " + error.code + " " + error.message);
            }
        });

}



 function encrypt(){

      var PassPhrase = document.getElementById('email').value; 
      var Bits = 1024; 
      var RSAkey = cryptico.generateRSAKey(PassPhrase, Bits);
      var PublicKeyString = cryptico.publicKeyString(RSAkey);       
      var PlainText = document.getElementById('password').value;
      var EncryptionResult = cryptico.encrypt(PlainText, PublicKeyString);
      var DecryptionResult = cryptico.decrypt(EncryptionResult.cipher, RSAkey);
      var nombre = document.getElementById('nombre').value;
      var DatosEncriptados = Parse.Object.extend("DatosEncriptados"); 
      var datosencriptados = new DatosEncriptados();
      var mail  = document.getElementById('email').value
      var encrypted = EncryptionResult.cipher


      datosencriptados.set("publicKey",PublicKeyString)
      datosencriptados.set("nombre", nombre);
      datosencriptados.set("email",  mail);
      datosencriptados.set("pass", encrypted);

      datosencriptados.save(null, {
        success: function(gameScore) {
          alert('Usuario creado ');
          window.open("login.html", "_self",false);
        },
        error: function(gameScore, error) {
          alert('Ups algo salio mal intentalo de nuevo');
        }
      });
}