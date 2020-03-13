<!DOCTYPE html>
<html>
<body onload="getLocation()">

<script>	

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    alert("Geolocation is not supported by this browser.");
  }
}

function showPosition(position) {
    var url = window.location.href;
    var c = url.split('/');
    var room = c[c.length - 1];
    var lat =  position.coords.latitude;
    var long = position.coords.longitude;
    
    window.location.href = "<?php echo URL::to('geolocation_result/'); ?>/" + room + "/" + lat + "/" + long;
}
</script>
</body>
</html>
