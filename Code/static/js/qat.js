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