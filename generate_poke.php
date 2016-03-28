
<html lang="zh-TW">
<head>
  <meta charset="UTF-8">
<title>RESET POKE PAGE</title>
</head>
<body>
<?php
session_start();
$cell = $_POST['cell']; //how many cells
$targ = $_POST['targ']; //how many targets
$targ2 = $_POST['targ2']; //how many targets
$pawd = $_POST['password'];
$col = $_POST['column'];
$cap = $_POST['captcha'];
$mypw = "what"; //密碼

if ($pawd != $mypw) {
	echo "密碼錯誤";
} elseif ($cap !=$_SESSION['digit']) {
	echo "識別碼錯誤";
} elseif ($_POST['originator'] != $_SESSION['code']) {
	echo "請勿嘗試洗頻";
} else {
include 'form/include.php';
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("資料庫連線異常: " . $conn->connect_error);
} 
//清空重來
$sql = "TRUNCATE TABLE jackpot"; 
mysqli_query($conn, $sql);
$sql = "TRUNCATE TABLE jackpot_setting"; 
mysqli_query($conn, $sql);
$sql = "INSERT INTO jackpot_setting (total, col) VALUES ('$cell','$col')";
mysqli_query($conn, $sql);
ECHO "建立" . $cell . "格戳戳樂<br>";

for ($i = 1; ; $i++) {
    if ($i > $cell) {
        break;
    }
    $sql = "INSERT INTO jackpot (no) VALUES ('$i')";
		if ($conn->query($sql) === TRUE) {
		} else {
   			echo "Error: " . $sql . "<br>" . $conn->error;
		}
}

//隨機產生中獎序號函式
function randomGen($min, $max, $quantity) {
    $numbers = range($min, $max);
    shuffle($numbers);
    return array_slice($numbers, 0, $quantity);
}
//產生頭獎序號
$oneprize = randomGen(1,$cell,$targ);
//依照格字數產生貳獎數目
$number2 = range(1,$cell);
//將頭獎排除在二獎外
$number2_array = array_diff($number2, $oneprize);
//將二獎序列隨機排序
shuffle($number2_array);
//將頭獎序號陣列轉為sql位址
$setpot = implode(", ",$oneprize);
//將二獎序號陣列轉為sql位址
$setpot2 = implode(", ", array_slice($number2_array, 0, $targ2));
//重設原先已設為中獎的格子
$resetsql = "UPDATE jackpot SET pot='0' WHERE pot='1'";
if ($conn->query($resetsql) === TRUE) {
    		echo "已成功清空既有獎品<br />";
		} else {
   			echo "清空獎品錯誤: " . $resetsql . "<br>" . $conn->error;
		}
//再次設置中獎格子
$sql = "UPDATE jackpot SET pot='1' WHERE no IN ($setpot)";
		if ($conn->query($sql) === TRUE) {
    		echo "已成功暗藏頭獎於 $setpot<br />";
		} else {
   			echo "安置獎品錯誤: " . $sql . "<br>" . $conn->error;
		}
$sql = "UPDATE jackpot SET pot='2' WHERE no IN ($setpot2)";
		if ($conn->query($sql) === TRUE) {
    		echo "已成功暗藏二獎於 $setpot2<br />";
		} else {
   			echo "安置獎品錯誤: " . $sql . "<br>" . $conn->error;
		}
}
session_destroy();?>
</body>
</html>
