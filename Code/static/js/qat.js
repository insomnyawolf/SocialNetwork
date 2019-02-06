function loadUSER() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
       document.getElementById("editUSER").innerHTML = this.responseText;
      }/*else{
        alert('Request failed.  Returned status of ' + xhttp.status);
      }*/
    };
    xhttp.open("POST", "./code/qatHelper.php", true);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    name = document.getElementById("EditUser").value;
    xhttp.send(param({
      'func': 'loadUser',
      'user': name
    }));
  return false;
}
function editUSER() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     document.getElementById("editUSER").innerHTML = this.responseText;
    }/*else{
      alert('Request failed.  Returned status of ' + xhttp.status);
    }*/
  };
  xhttp.open("POST", "./code/qatHelper.php", true);
  xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  //name = document.getElementById("EditUser").value;
  var active;
  if (document.getElementById("EditIsActive").checked){
    active=1;
  }else{
    active=0;
  }
  xhttp.send(param({
    'func': 'editUser',
    'EditUserID': document.getElementById("EditUserID").value,
    'EditUser': document.getElementById("EditUser").value,
    'EditNombre': document.getElementById("EditNombre").value,
    'EditApellido': document.getElementById("EditApellido").value,
    'EditDomicilio': document.getElementById("EditDomicilio").value,
    'EditFecha_nac': document.getElementById("EditFecha_nac").value,
    'EditTelefono': document.getElementById("EditTelefono").value,
    'EditDNI': document.getElementById("EditDNI").value,
    'EditIsActive': active,
  }));
return false;
}
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