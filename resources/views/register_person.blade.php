<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../../css/app.css" rel="stylesheet">
</head>
<body>
  <form class="modal-content animate" action="/action_page.php" method="post">
    <div class="imgcontainer">
     <h1>COVID-19 Tracker Register</h1>
    </div>
    <div class="container">
      <label for="username"><b>หมายเลขประจำตัวประชาชน</b></label>
      <input type="text"  name="username" required autocomplete="off">
      <label for="password"><b>ชื่อ-นามสกุล</b></label>
      <input type="text" name="password" required autocomplete="off">      
      <label for="mobilephonenumber"><b>เบอร์โทรศัพท์มือถือ</b></label>
      <input type="number" name="mobilephonenumber" required autocomplete="off">    
      <button type="submit">Register</button>
    </div>
  </form>
</body>
</html>
