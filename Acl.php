<!DOCTYPE html>
<?php

class Db
{
  private $user = "root";
  private $password = "";
  private $path = "localhost";
  private $db = "admin_login";
  private $sql ="";
  private $con;

  function __construct()
  {
      // Conexao com o Mysql - retorna erro se não bem sucedida
      $this->con = mysqli_connect($this->path, $this->user, $this->password) or die("Conexao com o banco de dados " . $this->db . " falhou!" . mysqli_error($this->con));
      // Conexao com o banco de dados esplicitado em $db - retorna erro se nao bem sucedida
      mysqli_select_db($this->con, $this->db) or die("Selecao do banco de dados " . $this->db . " falhou!" . mysqli_error($this->con));
      return $this->con;
  }

  public function getCon()
  {
    return $this->con;
  }

  // Check existence of records based on the $sql
  public function query($type,$sql){
    $this->sql = $sql;
    $result = mysqli_query(Db::getCon(), $this->sql);
    $count = mysqli_num_rows($result);
    if ($result){
        switch ($type) {
          case '0':
              $respostas = array('count' => $count);
              break;
          case '1':
              if ($count > 0){
                 for ($i = 0; $i < mysqli_num_rows($result); $i++){
                   $linha = mysqli_fetch_array($result);
                   $respostas = array(
                     'count' => $count,
                     'pid' => $linha['pid'],
                     'permission_name' => $linha['permission_name'],
                     'permission_type' => $linha['permission_type'],
                     'group_id' => $linha['group_id'],
                     'obs' => $linha['obs']
                   );
                 }
             }else {
               return FALSE;
             }
             break;
            case '2':
                if ($count > 0){
                   for ($i = 0; $i < mysqli_num_rows($result); $i++){
                     $linha = mysqli_fetch_array($result);
                     $respostas = array(
                       'count' => $count,
                       'pid' => $linha['pid'],
                       'permission_name' => $linha['permission_name'],
                       'permission_type' => $linha['permission_type'],
                       'userid' => $linha['userid'],
                       'obs' => $linha['obs']
                     );
                   }
               }else {
                 return FALSE;
               }
               break;

        }
        //var_dump($respostas);
        return $respostas;
      }
    }

}

class Acl {

   private $db;
   private $user_empty = false;
   //initialize the database object here
   function __construct() {
     $this->db = new Db;
   }

   function check($permission,$userid,$group_id)
   {
       //we check the user permissions first
       If(!$this->user_permissions($permission,$userid))
       {
            return false;
       }
       // then check the group permissions and if user exists
       if(!$this->group_permissions($permission,$group_id) & $this->IsUserEmpty())
       {
          return false;
       }

       return true;

   }

   function user_permissions($permission,$userid) {
      $f = $this->db->query(0,"SELECT COUNT(*) AS count FROM user_permissions WHERE permission_name='$permission' AND userid='$userid' ");

      If($f['count'] >0)
      {
          $this->setUserEmpty('false');

          $f = $this->db->query(2,"SELECT * FROM user_permissions WHERE permission_name='$permission' AND userid='$userid' ");

          If($f['permission_type']==0)
          {
              return false;
          }

          return true;

     }
     //There is no user as specified
     $this->setUserEmpty('true');

     return true;

   }

   function group_permissions($permission,$group_id)
   {

        $f = $this->db->query(0,"SELECT COUNT(*) AS count FROM group_permissions WHERE permission_name='$permission' ");//AND group_id='$group_id' ");

        if($f['count']>0)
        {
            $f = $this->db->query(1,"SELECT * FROM group_permissions WHERE permission_name='$permission'"); //AND group_id='$group_id' ");

              //$f = $this->db->fetch();

              If($f['permission_type']==0)
              {
                  return false;
              }
              return true;
       }
       return true;
   }


   function setUserEmpty($val)
   {
     $this->userEmpty = $val;
   }

   function isUserEmpty()
   {
     return $this->userEmpty;
   }


}

$acl = new Acl();
If(!$acl->check("view_admin_dashboard",1,1)) {
// user doesn't have permission to execute the following action
//do something here
}else {
  echo "User approved to access Admin dashboard.";
}



?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Class and Form</title>
    <style>


    </style>
    <script>


    </script>
  </head>
  <body>

  </body>
</html>
