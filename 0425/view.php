<form method=post action=view.php>
  <select name="did" >
<?php
   //MYSQL연결한다
   $conn = mysqli_connect('localhost', 'root', '','bssm2_3');

   //device table에서 did목록을 가지고온다
     $query = "select * from device;";
   $result = mysqli_query($conn, $query);
   while($row = mysqli_fetch_assoc($result)){
    echo "<option value='".$row['did']."'>".$row['did']."</option>";
   }
?>
  </select>
  <BR>갯수선택하기<BR>
  <input type=radio name=limit value=10 checked> 10개<BR>
  <input type=radio name=limit value=20> 20개<BR>
  <input type=radio name=limit value=30> 30개<BR>

  <BR>
  <input type=radio name=order value=asc checked> 오름차순<BR>
  <input type=radio name=order value=desc> 내림차순<BR>
  <input type=submit value=확인>
</form>

<?php
   if(isset($_POST['did'])){
     //유저가 콤보박스에서 디바이스 아이디를 선택해서 submit버튼을 눌렀다!
     echo $_POST['did'] . "<BR>";  
   }else{
     //유저가 웹브라우저에서 view.php를 열었다!
     echo "디바이스 아이디를 선택해주세요!";
        exit;
   }


   //데이터를 읽어오는 쿼리를 작성한다
   $query = "select * from sensor where did='".$_POST['did']."' order by num ".$_POST['order']." limit ".$_POST['limit'].";";
   //쿼리를 실행한다
    echo $query . "<BR>";
   $result = mysqli_query($conn, $query);
   //결과를 출력한다

   //그래프 집어넣기!
   include 'graph.php';

   echo "<table border=1 width=500>"; 
      echo "<tr>";
    echo "<th>번호</th>";
    echo "<th>디바이스명</th>";
    echo "<th>온도값</th>";
    echo "<th>습도값</th>";
    echo "<th>업로드날짜</th>";
    echo "</tr>";
   while($row = mysqli_fetch_assoc($result)){
    echo "<tr>";
    echo "<td>".$row['num']."</td>";
    echo "<td>".$row['did']."</td>";
    echo "<td>".$row['temp']."</td>";
    echo "<td>".$row['humi']."</td>";
    echo "<td>".$row['date']."</td>";
    echo "</tr>";
  }

  echo "</table>";
   
?>
