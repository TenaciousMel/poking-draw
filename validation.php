<?php
include 'form/include.php';
session_start();
$no   = $_GET['no'];
$check = $_GET['check'];

if(isset($no) && $_SESSION['messcheck']==$check) {
      $conn = new mysqli($servername, $username, $password, $dbname);
      $sql = "UPDATE jackpot SET cond='1' WHERE no='$no'";
      mysqli_query($conn, $sql);

      //呼叫設定值
      $result = $conn->query("SELECT pot FROM jackpot WHERE no='$no'");
      $data = array();
      while($row = $result->fetch_assoc()) {
          $data['pot'] = $row['pot'];
      }
      switch ($data['pot']) {
          case "1":
              header('Location: poke.php#lightbox1-t');
              break;
          case "2":
              header('Location: poke.php#lightbox1-b');
              break;
          default:
              header('Location: poke.php#lightbox1-inst');
      }
      //header('Location: poke.php');
} else {
   echo "請乖乖的，別亂來！";
}