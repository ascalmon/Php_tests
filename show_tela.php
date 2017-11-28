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
        echo "<tr>";
        for ($i=0; $i <= $lines - 1; $i++){
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
      header('Content-Type: text/html; charset=utf-8');
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

    function get_medidores($dbc){
        $sql = "SELECT * FROM `medidores` WHERE 1";
          //$array = array();
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

    function cria_tela($columns,$lines,$header, $array){
      echo "<table style='width:100%'>";
      if ($header){
          echo "<tr>";
          foreach ($array[0] as $key => $value){
          //for($i=0; $i<= $columns; $i++){
            echo "<th>";
            //echo "Header " . $i;
            echo $key;
            echo "</th>";
          }
          echo "</tr>";
      }
      //echo "<tr>";
      for($i=0; $i<= $lines - 1; $i++){
        echo "<tr>";
        $size = 100/$columns;
        for ($j=0; $j<= $columns -1; $j++){
          echo "<td width='" . (int)$size ."%'>";
          echo "Dados " . $j;
          echo "</td>";
        }
        echo "</tr>";
      }
      //echo "</tr>";
      echo "</table>";
    }

?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Show Tela</title>
    <style>
        body{
          background-color: lightblue;
        }
        table {
          width: 800px;
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
    <script>


    </script>
  </head>
  <body>
    <h1> Teste de Apresentacao de telas </h1>

    <?php
    $dbc = connect_db();
    $array = get_medidores($dbc);
    $table = new Table;
    $columns = sizeof($array[0]);
    $lines = sizeof($array);
    //echo $columns . " - " . $lines;
    //echo "<pre>" . print_r($array, true) . "</pre>";
    $table->createTable($columns,$lines,true,$array);
    ?>
  </body>
</html>
