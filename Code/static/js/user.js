function addAcount() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
       document.getElementById("addAccount").innerHTML = this.responseText;
	  }/*else{
        alert('Request failed.  Returned status of ' + xhttp.status);
      }*/
    };
    xhttp.open("POST", "./code/settings.php", true);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhttp.send(param({
      'func': 'addAccount',
    }));
  return false;
}
//Parsear los datos a editar a datos de formulario
function param(object) {
  var encodedString = '';
  for (var prop in object) {
      if (object.hasOwnProperty(prop)) {
          if (encodedString.length > 0) {
              encodedString += '&';
          }
          encodedString += encodeURI(prop + '=' + object[prop]);
      }
  }
  //alert(encodedString)
  return encodedString;
}
function refreshAcounts() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     document.getElementById("tusCuentas").innerHTML = this.responseText;
  }/*else{
      alert('Request failed.  Returned status of ' + xhttp.status);
    }*/
  };
  xhttp.open("POST", "./code/settings.php", true);
  xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhttp.send(param({
    'func': 'refreshAcounts',
  }));
return false;
}