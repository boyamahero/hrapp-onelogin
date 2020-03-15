<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../../css/app.css" rel="stylesheet">
</head>
<body>
  <form class="modal-content animate" action="/register_save/empegat" method = "post">
    <div class="imgcontainer">
     <h2>COVID-19 Tracker Register</h2>
     <h2>ผู้ปฏิบัติงาน กฟผ.</h2>
    </div>
    <div class="container">    
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
      <label for="uname"><b>หมายเลขประจำตัวพนักงาน</b></label>
      <input type="text"  name="empcode" required autocomplete="off">
      <label for="psw"><b>เบอร์โทรศัพท์มือถือ</b></label>
      <input type="number" name="mobilephonenumber" required autocomplete="off">        
      <button type="submit">Register</button>
      </form>
    </div>
  </form>
</body>
</html>
