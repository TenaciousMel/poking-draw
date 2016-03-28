
<html lang="zh-TW">
<head>
  <meta charset="UTF-8">
<title>RESET POKE PAGE</title>
<script>
function validateForm() {
    var cellv = document.forms["myForm"]["cell"].value;
    var targv = document.forms["myForm"]["targ"].value;
    var targ2v = document.forms["myForm"]["targ2"].value;
    var targt = +targv + +targ2v;
    if (cellv == null || cellv == "") {
        alert("請至少輸入格子數量！");
        return false;
    } else if(targv == null || targv == "") {
        alert("請至少輸入頭獎數量！");
        return false;
    } else if (targt >= cellv) {
    	alert("獎品總量高於格子數目！");
    	return false;
    }
}
</script>
</head>
<body>
<?php
session_start();
$code = mt_rand(0,1000000);
$_SESSION['code'] = $code;
?>
<form name="myForm" action="generate_poke.php" onsubmit="return validateForm()" method="POST">
格子數目(10~100)：
<input type="number" name="cell" min="10" max="100">
<br />
頭獎數目(至少1)：
<input type="text" name="targ" min="1" maxlength="2" size="2">
<br />
二獎數目：
<input type="text" name="targ2" maxlength="2" size="2">
<br />
顯示欄數：
<select name="column">
<option>3</option>
<option>4</option>
<option>5</option>
<option selected>6</option>
<option>7</option>
<option>8</option>
<option>9</option>
<option>10</option>
</select>
<br />
密碼：
<input type="password" name="password">
<br />

<p>請輸入下方驗證數值<br>
<img src="captcha.php" width="120" height="30" border="1" alt="CAPTCHA"><input type="text" size="6" maxlength="5" name="captcha" value=""></p>
<input type="hidden" name="originator" value="<?=$code?>">
<input type="submit" name="submit" value="BOOM!">
</form>
</body>
</html>