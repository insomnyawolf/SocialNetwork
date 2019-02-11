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
function DeleteAcount(AccountID) {
  	var xhttp = new XMLHttpRequest();
  	xhttp.onreadystatechange = function() {
    	if (this.readyState == 4 && this.status == 200) {
     		document.getElementById("form"+AccountID).innerHTML = this.responseText;
  		}/*else{
      	alert('Request failed.  Returned status of ' + xhttp.status);
    	}*/
  	};
	xhttp.open("POST", "./code/settings.php", true);
  	xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  	var cantidad = document.getElementById("cantidad"+AccountID).value;
  	xhttp.send(param({
  		'func': 'deleteAccount',
    	'accounts_id': AccountID,
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
  	var x = document.getElementById("tusCuentas");
  	if (x.style.display === "none"){
    	x.style.display = "block";
  	}
	return false;
}
function addMoney(AccountID) {
  	var xhttp = new XMLHttpRequest();
  	xhttp.onreadystatechange = function() {
    	if (this.readyState == 4 && this.status == 200) {
     		document.getElementById("form"+AccountID).innerHTML = this.responseText;
  		}/*else{
      		alert('Request failed.  Returned status of ' + xhttp.status);
    	}*/
  	};
  	xhttp.open("POST", "./code/settings.php", true);
  	xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  	var cantidad = document.getElementById("cantidad"+AccountID).value;
  	if (cantidad > 0){
    	xhttp.send(param({
      	'func': 'addMoney',
      	'accounts_id': AccountID,
      	'amount': cantidad,
    	}));
  	}else{
    	alert("Debe introducir una cantidad superior a 0");
  	}
	return false;
}
function takeMoney(AccountID) {
  	var xhttp = new XMLHttpRequest();
  	xhttp.onreadystatechange = function() {
    	if (this.readyState == 4 && this.status == 200) {
     		document.getElementById("form"+AccountID).innerHTML = this.responseText;
  		}/*else{
      		alert('Request failed.  Returned status of ' + xhttp.status);
    	}*/
  	};
  	xhttp.open("POST", "./code/settings.php", true);
  	xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  	var cantidad = document.getElementById("cantidad"+AccountID).value;
  	if (cantidad > 0){
    	xhttp.send(param({
      	'func': 'takeMoney',
      	'accounts_id': AccountID,
      	'amount': cantidad,
    }));
  	}else{
    	alert("Debe introducir una cantidad superior a 0");
  	}
return false;
}
function updatePrecio(ID){
	var cantidad = document.getElementById("cantidad"+ID).value;
	var valor = document.getElementById("valor"+ID).value;
	document.getElementById("precio"+ID).value = cantidad*valor;
}
function HideAccounts(){
  	var x = document.getElementById("tusCuentas");
  	if (x.style.display === "none"){
    	x.style.display = "block";
  	}else{
    	x.style.display = "none";
  	}
}