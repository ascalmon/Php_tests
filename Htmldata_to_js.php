<!DOCTYPE html>
<?php

class Table{

      private $arrayData;
      private $columns;
      private $lines;
      private $header;
      private $aux;

      function __construct($columns = 0, $lines = 0, $header = true, $arrayData = null){
        $this->arrayData = $arrayData;
        $this->columns = $columns;
        $this->lines = $lines;
        $this->header = $header;
      }

      public function createTable($columns,$lines,$header,$arrayData){
        echo "<table style='width:100%'>";
        if ($header){
            echo "<tr>";
            foreach ($arrayData[0] as $key => $value){
              echo "<th>";
              echo $key;
              echo "</th>";
            }
            echo "</tr>";
        }
        //echo "<tr>";
        for ($i=0; $i <= $lines - 1; $i++){
            echo "<tr>";
            $size = 100/$columns;
            foreach ($arrayData[$i] as $key => $value){
              echo "<td width='" . (int)$size ."%'>";
              echo $value;
              echo "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
      }

}

function connect_db(){
    header('Content-Type: text/html; charset=utf-8');               // Caracters Latinos
        $servername = "localhost";                                  // Uso para teste no servidor local
        $username = "root";
        $password = "";
        $dbname = "admin_login";

    $dbc = new mysqli($servername, $username, $password, $dbname);
    mysqli_select_db($dbc,$dbname);
    mysqli_query($dbc,"SET NAMES 'utf8'");
    mysqli_query($dbc,'SET character_set_connection=utf8');
    mysqli_query($dbc,'SET character_set_client=utf8');
    mysqli_query($dbc,'SET character_set_results=utf8');

    if ($dbc->connect_error) {
         die('Connection failed: ' . $dbc->connect_error);
    }
    return $dbc;
  }

  function get_medidores($dbc,$cidade){
      if ($cidade == ""){
          $sql = "SELECT id, cidade, latitude, longitude FROM `medidores` WHERE 1";
      }else{
        $sql = "SELECT id, cidade, latitude, longitude FROM `medidores` WHERE cidade ='$cidade'";
      }
        //echo $sql;
        $result = mysqli_query($dbc, $sql);                       // Connecta com o DB e verifica se usuario existe
        if ($result != false){
            $count = mysqli_num_rows($result);
            if ($count == 0) {
                return false;
            }else{
                for ($i = 0; $i <= $count - 1; $i++){
                  $array[$i] = mysqli_fetch_assoc($result );
                }
                return $array;
            }
        } else {
          echo "Acesso ao Banco abas falhou!";
        }
    }

?>
<html lang="en">
<head>
  <meta charset="UTF-8">

  <title>HTML data to Javascript</title>

  <style>
      body{
        background-color: lightblue;
        width: 1000px;
      }
      table {
        width: 100%;
        border: solid 1px white;
      }
      tr,th {
        border: solid 1px white;
        color:navy;
        text-align:center;
        font-family: verdana;
        font-size: 15px;
        display:inline-block;

      }
      td {
        border: solid 1px white;
        color:navy;
        text-align:center;
        font-family: verdana;
        font-size: 15px;
        display:inline-block;
      }

  </style>
</head>


<body>
    <h1>Passing Variables from HTML to Javascript</h1>


    <?php

    if(isset($_GET['city'])){
      $cidade = $_GET['city'];
      //echo $cidade;
    }else{
      $cidade = "Brasilia";
    }

    $dbc = connect_db();
    $array = get_medidores($dbc,$cidade);

    ?>

    <form method="get">
      <label>Cidade:</label>
      <input type="text" name="city" placeholder="Entre nome cidade"/>
      <input type="hidden" id="data1" name="lat" value ="<?php echo $array[0]['latitude'];?>"/>
      <input type="hidden" id="data2" name="lng" value ="<?php echo $array[0]['longitude'];?>"/>
      <input type="submit" value="Submit"/>
      <br>
      <br>
    </form>

    <?php
    $table = new Table;
    $columns = sizeof($array[0]);
    $lines = sizeof($array);
    //echo $columns . " - " . $lines;
    //echo "<pre>" . print_r($array, true) . "</pre>";
    $table->createTable($columns,$lines,true,$array);
    ?>
    <br>
    <br>
    <div id="data1"></div>
    <div id="data2"></div>

    <script language="JavaScript">
      function processForm()
      {
        var parameters = location.search.substring(1).split("&");
        var temp = parameters[0].split("=");
        lat = unescape(temp[1]);
        var temp1 = parameters[1].split("=");
        lng = unescape(temp1[1]);
        document.getElementById("data1").innerHTML = "Latitude - " + lat;
        document.getElementById("data2").innerHTML = "Longitude - " + lng;
      }
      processForm();
    </script>
  </body>
</html>
