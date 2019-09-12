document.getElementById("email").addEventListener("submit", function(){
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      const result = JSON.parse(this.responseText);
      document.write(result);
    }
  };
  xmlhttp.open("POST", "email.php", true);
  xmlhttp.send();
});
