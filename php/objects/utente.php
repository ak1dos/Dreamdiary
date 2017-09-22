<?php
class Utente{

    // database connection and table name
    private $conn;
    private $table_name = "utente";

    // object properties
    public $email;
    public $password;
    public $descrizione;
    public $nome;
    public $cognome;
    public $username;
    public $datai;
    public $residenza;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read utente
    function is_password_correct($username, $password){
      $query = "SELECT password
                FROM " . $this->table_name . "
                WHERE username = ?";
      // prepare query
      $stmt = $this->conn->prepare($query);
      // quote string
      $username=htmlspecialchars(strip_tags($username));
      // bind param
      $stmt->bindParam(1, $username);
      // execute query
      $stmt->execute();
      // get retrieved row
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if ($rows) {
        foreach ($rows as $row) {
          $hash = $row["password"];
          return password_verify($password, $hash);
        }
      } else {
        return FALSE;   # user not found
      }

    }
    //check if username is present in db
    function is_username_present($username){
      $query = "SELECT username
                FROM " . $this->table_name . "
                WHERE username = ?";
      // prepare query
      $stmt = $this->conn->prepare($query);
      // quote string
      $username=htmlspecialchars(strip_tags($username));
      // bind param
      $stmt->bindParam(1, $username);
      // execute query
      $stmt->execute();
      // get retrieved row
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if ($rows) {
        foreach ($rows as $row) {
          $present_username = $row["username"];
          /*
          $hashedPassword = password_hash($correct_password, PASSWORD_DEFAULT);
          return password_verify($password, $hashedPassword);
          */
          return $present_username === $username;
        }
      } else {
        return FALSE;   # user not found
      }
    }
    // insert user
    function insert_user($username, $password, $datai){
      $query = "INSERT INTO
                  " . $this->table_name . "
                SET
                    username=:username, password=:password, datai=:datai";
      $stmt = $this->conn->prepare($query);
      // sanitize
      $username=htmlspecialchars(strip_tags($username));
      $password=htmlspecialchars(strip_tags($password));
      $datai=htmlspecialchars(strip_tags($datai));
      // bind
      $stmt->bindParam(":username", $username);
      $stmt->bindParam(":password", $password);
      $stmt->bindParam(":datai", $datai);

      if($stmt->execute()){
          return TRUE;
      }else{
          return FALSE;
      }
    }
    function check_logged_in(){
      if (isset($_SESSION["username"])) {
        $this->redirect("./post/home.php", "Welcome back.");
      }
    }

    function ensure_logged_in(){
      if (!isset($_SESSION["username"])) {
        $this->redirect("../index.php", "You must log in before you can view that page.");
      }
    }
    # Redirects current page to the given URL and optionally sets flash message.
    function redirect($url, $flash_message = NULL) {
      if ($flash_message) {
        $_SESSION["flash"] = $flash_message;
      }
      # session_write_close();
      header("Location: $url");
      die;
    }

    function getInfo($username){
      $query = "SELECT username, email, descrizione, nome, cognome, datai, residenza
                FROM " . $this->table_name . "
                WHERE username=:username";
      $stmt = $this->conn->prepare($query);

      $username=htmlspecialchars(strip_tags($username));

      $stmt->bindParam(':username', $username);
      if($stmt->execute()){
        $user = array();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($rows) {
          foreach ($rows as $row) {
            $user_info = array(
              'username' => $row['username'],
              'email' => $row['email'],
              'descrizione' => $row['descrizione'],
              'nome' => $row['nome'],
              'cognome' => $row['cognome'],
              'datai' => $row['datai'],
              'residenza' => $row['residenza']
            );
            array_push($user, $user_info);
          }
          return $user;
        } else {
          return FALSE;
        }
      }else {
        return FALSE;
      }
    }

    function checkChanges($username, $email, $nome, $cognome, $descrizione, $residenza){
      $query = "SELECT
                    email, nome, cognome, descrizione, residenza
                FROM
                    " . $this->table_name . "
                WHERE username=:username";
      $stmt = $this->conn->prepare($query);
      $username=htmlspecialchars(strip_tags($username));
      $stmt->bindParam(":username", $username);
      if ($stmt->execute()) {
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($rows) {
          foreach ($rows as $row) {
            return $row['email'] == $email &&
              $row['descrizione'] == $descrizione &&
              $row['nome'] == $nome &&
              $row['cognome'] == $cognome &&
              $row['residenza'] == $residenza;
          }
        } else {
          return FALSE;   # posts not found
        }
      } else {
        return FALSE;
      }
    }

    function update_user($username, $email, $nome, $cognome, $descrizione, $residenza){
      $query = "UPDATE
                  " . $this->table_name . "
                SET
                    email = :email,
                    nome = :nome,
                    cognome = :cognome,
                    descrizione = :descrizione,
                    residenza = :residenza
                WHERE
                    username = :username";

      // prepare query statement
      $stmt = $this->conn->prepare($query);

      // sanitize
      $username=htmlspecialchars(strip_tags($username));
      $email=htmlspecialchars(strip_tags($email));
      $descrizione=htmlspecialchars(strip_tags($descrizione));
      $nome=htmlspecialchars(strip_tags($nome));
      $cognome=htmlspecialchars(strip_tags($cognome));
      $residenza=htmlspecialchars(strip_tags($residenza));

      // bind values
      $stmt->bindParam(":username", $username);
      $stmt->bindParam(":email", $email);
      $stmt->bindParam(":nome", $nome);
      $stmt->bindParam(":cognome", $cognome);
      $stmt->bindParam(":descrizione", $descrizione);
      $stmt->bindParam(":residenza", $residenza);

      // execute the query

      if($stmt->execute()){
          return TRUE;
      }else{
        echo "no execute";
          return FALSE;
      }
    }

    function validate($email, $nome, $cognome, $descrizione, $residenza){
      $nomeRegex = "/^[A-Za-z]{0,30}$/";
      $cognomeRegex = "/^[A-Za-z]{0,30}$/";
      $emailRegex = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";

      if(strlen($email) > 0 || strlen($nome) > 0 || strlen($cognome) > 0){
        if (!preg_match($emailRegex, $email) || strlen($email) > 70) {
          return FALSE;
        } else if (!preg_match($nomeRegex, $nome)){
          return FALSE;
        } else if(!preg_match($cognomeRegex, $cognome)){
          return FALSE;
        } else if (strlen($descrizione) > 500){
          return FALSE;
        } else if(strlen($residenza) > 100){
          return FALSE;
        } else {
          return TRUE;
        }
      } else if (strlen($descrizione) > 500){
        return FALSE;
      } else if(strlen($residenza) > 100){
        return FALSE;
      } else {
        return TRUE;
      }
      /*
      return strlen($email) < 70 && strlen($nome) < 30 && strlen($cognome) < 30 &&
             strlen($descrizione) < 500 && strlen($residenza) < 100;
     */
    }
    function read(){

        // select all query
        $query = "SELECT u.email, u.nickname, u.nome, u.cognome, u.descrizione, u.datai, u.residenza
                  FROM
                      " . $this->table_name . " u
                  ORDER BY
                      u.nickname";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // register
    function register(){

        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    email=:email, password=:password,
                    nome=:nome, cognome=:cognome, nickname=:nickname,
                    datan=:datan, datai=:datai, residenza=:residenza";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->nome=htmlspecialchars(strip_tags($this->nome));
        $this->cognome=htmlspecialchars(strip_tags($this->cognome));
        $this->nickname=htmlspecialchars(strip_tags($this->nickname));
        $this->datan=htmlspecialchars(strip_tags($this->datan));
        $this->datai=htmlspecialchars(strip_tags($this->datai));
        $this->residenza=htmlspecialchars(strip_tags($this->residenza));

        // bind values
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":cognome", $this->cognome);
        $stmt->bindParam(":nickname", $this->nickname);
        $stmt->bindParam(":datan", $this->datan);
        $stmt->bindParam(":datai", $this->datai);
        $stmt->bindParam(":residenza", $this->residenza);

        // execute query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    // used when filling up the update product form
    function readOne(){

        // query to read single record
        $query = "SELECT
                    u.email, u.descrizione, u.nome, u.cognome, u.nickname,u.datan, u.datai, u.residenza
                  FROM
                      " . $this->table_name . " u
                  WHERE
                      u.nickname = ?
                  LIMIT
                      0,1";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind id of product to be updated
        $stmt->bindParam(1, $this->nickname);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->email = $row['email'];
        $this->descrizione = $row['descrizione'];
        $this->nome = $row['nome'];
        $this->cognome = $row['cognome'];
        $this->nickname = $row['nickname'];
        $this->datan = $row['datan'];
        $this->datai = $row['datai'];
        $this->residenza = $row['residenza'];
    }

    // update the product
    function update(){

        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                  SET
                      email = :email,
                      descrizione = :descrizione,
                      nome = :nome,
                      cognome = :cognome,
                      datan = :datan,
                      residenza = :residenza
                  WHERE
                      nickname = :nickname";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->descrizione=htmlspecialchars(strip_tags($this->descrizione));
        $this->nome=htmlspecialchars(strip_tags($this->nome));
        $this->cognome=htmlspecialchars(strip_tags($this->cognome));
        $this->datan=htmlspecialchars(strip_tags($this->datan));
        $this->residenza=htmlspecialchars(strip_tags($this->residenza));
        $this->nickname=htmlspecialchars(strip_tags($this->nickname));
        // bind values

        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":descrizione", $this->descrizione);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":cognome", $this->cognome);
        $stmt->bindParam(":datan", $this->datan);
        $stmt->bindParam(":residenza", $this->residenza);
        $stmt->bindParam(":nickname", $this->nickname);

        // execute the query
        /*
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }*/
    }

    // delete the product
    function delete(){

        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE nickname = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->nickname=htmlspecialchars(strip_tags($this->nickname));

        // bind id of record to delete
        $stmt->bindParam(1, $this->nickname);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;

    }

    // search products
    function search($keywords){

        // select all query
        $query = "SELECT
                    u.nickname, u.descrizione, u.nome, u.cognome
                FROM
                    " . $this->table_name . " u
                WHERE
                    u.nickname LIKE ? OR u.cognome LIKE ? OR u.nome LIKE ?
                ORDER BY
                    u.nickname";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";

        // bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // read products with pagination
    public function readPaging($from_record_num, $records_per_page){

        // select query
        $query = "SELECT
                      u.email, u.nickname, u.nome, u.cognome, u.descrizione, u.datai, u.residenza
                  FROM
                      " . $this->table_name . " u
                  ORDER BY
                      u.nickname
                LIMIT ?, ?";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind variable values
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

        // execute query
        $stmt->execute();

        // return values from database
        return $stmt;
    }

    // used for paging users
    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }

    public function checkUser(){

      // query to read single record
      $query = "SELECT
                  u.email, u.nome, u.cognome, u.nickname
                FROM
                    " . $this->table_name . " u
                WHERE
                    u.email = ? AND u.password = ?";

      // prepare query statement
      $stmt = $this->conn->prepare( $query );

      // bind id of product to be updated
      $stmt->bindParam(1, $this->email);
      $stmt->bindParam(2, $this->password);

      // execute query
      $stmt->execute();

      // get retrieved row
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set values to object properties
      $this->email = null;
      $this->email = $row['email'];
      $this->nome = $row['nome'];
      $this->cognome = $row['cognome'];
      $this->nickname = $row['nickname'];
    }
}
