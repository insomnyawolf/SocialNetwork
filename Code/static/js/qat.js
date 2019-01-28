function loadUSER() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
       document.getElementById("editUSER").innerHTML = this.responseText;
      }else{
        alert('Request failed.  Returned status of ' + xhr.status);
      }
    };
    xhttp.open("POST", "ajax_info.txt", true);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    name = document.getElementById("");
    xhttp.send(encodeURI('name=' + newName));
    return false;
}