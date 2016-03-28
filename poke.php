<?php
include ('form/include.php');
session_start();
$code = "messaround" . mt_rand(0,1000000);
$_SESSION['messcheck'] = $code;
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//呼叫設定值
$result = $conn->query("SELECT total, col FROM jackpot_setting");
$data = array();
while($row = $result->fetch_assoc()) {
    $data['col'] = $row['col'];
    $data['total'] = $row['total'];
}

//決定欄數
switch ($data['col']) {
    case "3":
        $col_num = "one-third";
        break;
    case "4":
        $col_num = "one-quarter";
        break;
    case "5":
        $col_num = "one-fifth";
        break;
    case "6":
        $col_num = "one-sixth";
        break;
    case "7":
        $col_num = "one-seventh";
        break;
    case "8":
        $col_num = "one-eighth";
        break;
    case "9":
        $col_num = "one-nineth";
        break;
    default:
        $col_num = "one-tenth";
}
$col_height = 100/ceil($data['total']/$data['col']);

?>
<!DOCTYPE HTML>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>戳戳樂 by LAIPOA</title>
  
  <script src="//cdn.optimizely.com/js/2350390699.js"></script>
  
  <link rel="stylesheet" href="css/gridism.css">
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/lightbox.css">
</head>
<body>
<div id="container">
<?php
$sql = "SELECT id, no, cond, pot FROM jackpot";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	if ($row['no']%$data['col'] == 1) {
    		//echo "id: " . $row["id"]. " - no: " . $row["no"]. " - cond: " . $row["cond"] . "- pot: " . $row["pot"];
    		?>
    		<!-- 首欄顯示 -->
    		<div class="grid" style="height:<?php echo $col_height;?>%;">
    		<?php
    	}
        if ($row["cond"]==0) { ?>
	<a href="validation.php?no=<?php echo $row['no']; ?>&check=<?php echo $code;?>">
		<?php } ?>
		<div class="unit <?php echo $col_num;
			if ($row["cond"]==1) {
				echo " hit";
			} 
		?> targ border" style="height: 100%;"></div>
        <?php
        if ($row["cond"]==0) {
        ?>
        	</a>
        <?php
    	}
        ?>
        <?php
        if ($row['no']%$data['col'] == 0){
        	?>
    		<!-- 尾欄顯示 -->
        	</div>
        	<?php
        }
        ?>
        <?php
    }
} else {
    echo "0 results";
}
$conn->close();
?>
</div>
<!--中獎啦！-->
<div id="lightbox1-t" lightbox style="text-align: center; vertical-align: middle;">
<a href="#screenarea"></a>
<a href="poke.php"><img src="hanko_1st.gif"></a>
</div>
<div id="lightbox1-b" lightbox style="text-align: center; vertical-align: middle;">
<a href="index.php"></a>
<a href="poke.php"><img src="hanko_2nd.gif"></a>
</div>
<div id="lightbox1-inst" lightbox style="text-align: center; vertical-align: middle;">
<a href="index.php"></a>
<a href="poke.php"><img src="oops.gif"></a>
</div>

</body>
</html>
