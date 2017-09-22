<?php
class Post{

    // database connection and table name
    private $conn;
    private $table_name = "Post";

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    //insert new post
    function insert_post($titolo, $messaggio, $luogo, $username, $pubblico, $datac, $orac){
      $query = "INSERT INTO
                  " . $this->table_name . "
                SET
                    titolo=:titolo, messaggio=:messaggio, utente=:utente,
                    pubblico=:pubblico, luogo=:luogo, datac=:datac, orac=:orac";
      $stmt = $this->conn->prepare($query);
      // sanitize
      $titolo=htmlspecialchars(strip_tags($titolo));
      $messaggio=htmlspecialchars(strip_tags($messaggio));
      $username=htmlspecialchars(strip_tags($username));
      $luogo=htmlspecialchars(strip_tags($luogo));
      $pubblico=htmlspecialchars(strip_tags($pubblico));
      $datac=htmlspecialchars(strip_tags($datac));
      $orac=htmlspecialchars(strip_tags($orac));
      // bind
      $stmt->bindParam(":titolo", $titolo);
      $stmt->bindParam(":messaggio", $messaggio);
      $stmt->bindParam(":utente", $username);
      $stmt->bindParam(":pubblico", $pubblico);
      $stmt->bindParam(":luogo", $luogo);
      $stmt->bindParam(":datac", $datac);
      $stmt->bindParam(":orac", $orac);
      // execute query
      if($stmt->execute()){
        return TRUE;
      }else{
        return FALSE;
      }
    }

    // update the post
    function update_post($id, $titolo, $messaggio, $luogo, $pubblico, $datam, $oram){

        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                  SET
                      titolo = :titolo,
                      messaggio = :messaggio,
                      pubblico = :pubblico,
                      datam = :datam,
                      oram = :oram,
                      luogo = :luogo
                  WHERE
                      id = :id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $id=htmlspecialchars(strip_tags($id));
        $titolo=htmlspecialchars(strip_tags($titolo));
        $messaggio=htmlspecialchars(strip_tags($messaggio));
        $pubblico=htmlspecialchars(strip_tags($pubblico));
        $datam=htmlspecialchars(strip_tags($datam));
        $oram=htmlspecialchars(strip_tags($oram));
        $luogo=htmlspecialchars(strip_tags($luogo));

        // bind values
        $stmt->bindParam(":titolo", $titolo);
        $stmt->bindParam(":messaggio", $messaggio);
        $stmt->bindParam(":pubblico", $pubblico);
        $stmt->bindParam(":datam", $datam);
        $stmt->bindParam(":oram", $oram);
        $stmt->bindParam(":luogo", $luogo);
        $stmt->bindParam(":id", $id);

        // execute the query

        if($stmt->execute()){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    function validate($titolo, $messaggio, $luogo){
      return strlen($titolo) > 2 && strlen($titolo) < 50
            && strlen($messaggio) < 500 && strlen($messaggio) > 10
            && strlen($luogo) < 100;
    }

    function validateComment($messaggio){
      return strlen($messaggio) < 350;
    }

    function checkPost($id){
      $query = "SELECT id
                FROM " . $this->table_name . "
                WHERE id = ?";
      // prepare query
      $stmt = $this->conn->prepare($query);
      // quote string
      $username=htmlspecialchars(strip_tags($id));
      // bind param
      $stmt->bindParam(1, $id);
      // execute query
      $stmt->execute();
      // get retrieved row
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if (count($rows) > 0) {
        return TRUE;
      } else {
        return FALSE;   # user not found
      }
    }

    function checkChanges($id, $titolo, $messaggio, $luogo, $pubblico){
      $query = "SELECT
                    id, titolo, messaggio, pubblico, luogo
                FROM
                    " . $this->table_name . "
                WHERE id=:id";
      $stmt = $this->conn->prepare($query);
      $id=htmlspecialchars(strip_tags($id));
      $stmt->bindParam(":id", $id);
      if ($stmt->execute()) {
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($rows) {
          foreach ($rows as $row) {
            return $row['titolo'] == $titolo &&
              $row['messaggio'] == $messaggio &&
              $row['pubblico'] == $pubblico &&
              $row['luogo'] == $luogo;
          }
        } else {
          return FALSE;   # posts not found
        }
      } else {
        return FALSE;
      }
    }

    function getPost($id){
      $query = "SELECT
                    id, titolo, messaggio, utente, pubblico, datac, orac,
                    datam, oram, luogo
                FROM
                    " . $this->table_name . "
                WHERE id=:id";
      $stmt = $this->conn->prepare($query);
      $id=htmlspecialchars(strip_tags($id));
      $stmt->bindParam(":id", $id);
      if ($stmt->execute()) {
        $posts=array();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($rows) {
          foreach ($rows as $row) {
            $post_info=array(
              'id' => $row['id'],
              'titolo' => $row['titolo'],
              'messaggio' => $row['messaggio'],
              'utente' => $row['utente'],
              'pubblico' => $row['pubblico'],
              'datac' => $row['datac'],
              'orac' => $row['orac'],
              'datam' => $row['datam'],
              'oram' => $row['oram'],
              'luogo' => $row['luogo']
            );
            array_push($posts, $post_info);
          }
          return $posts;
        } else {
          return FALSE;   # posts not found
        }
      } else {
        return FALSE;
      }
    }

    function getRecent($username){
      $query = "SELECT id
                FROM " . $this->table_name . "
                WHERE utente=:utente
                ORDER BY datac DESC, orac DESC
                LIMIT 1";
      $stmt = $this->conn->prepare($query);
      $username=htmlspecialchars(strip_tags($username));
      $stmt->bindParam(":utente", $username);
      $stmt->execute();
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if($rows){
        $result=Array();
        foreach ($rows as $row) {
          $post_info=array(
            'id' => $row['id']
          );
          array_push($result, $post_info);
        }
        return $result;
      } else{
        return FALSE;
      }
    }

    function getLiked($username){
      $query = "SELECT p.id, COUNT(v.post) voti
                FROM post p JOIN voti v ON (p.id=v.post)
                WHERE p.utente = :utente
                GROUP BY p.ID
                ORDER BY voti DESC, datac DESC, orac DESC
                LIMIT 1";
      $stmt = $this->conn->prepare($query);
      $username=htmlspecialchars(strip_tags($username));
      $stmt->bindParam(":utente", $username);
      $stmt->execute();
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if($rows){
        $result=Array();
        foreach ($rows as $row) {
          $post_info=array(
            'id' => $row['id'],
            'voti' => $row['voti']
          );
          array_push($result, $post_info);
        }
        return $result;
      } else{
        return FALSE;
      }
    }

    function getMostCommented($username){
      $query = "SELECT p.id, COUNT(c.post) commenti
                FROM post p JOIN commento c ON (p.id=c.post)
                WHERE p.utente = :utente
                GROUP BY p.ID
                ORDER BY commenti DESC, datac DESC, orac DESC
                LIMIT 1";
      $stmt = $this->conn->prepare($query);
      $username=htmlspecialchars(strip_tags($username));
      $stmt->bindParam(":utente", $username);
      $stmt->execute();
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if($rows){
        $result=Array();
        foreach ($rows as $row) {
          $post_info=array(
            'id' => $row['id'],
            'commenti' => $row['commenti']
          );
          array_push($result, $post_info);
        }
        return $result;
      } else{
        return FALSE;
      }
    }

    function readAllPublic($username){
      $query = "SELECT idx as id, x.titolo, x.messaggio, x.utente, x.pubblico, x.datac, x.orac, x.datam, x.oram, x.luogo, voti, commenti
                FROM( (SELECT p.id as idx, p.titolo, p.messaggio, p.utente, pubblico, datac, orac, datam, oram, luogo, COUNT(v.post) as voti
                      FROM post p LEFT JOIN voti v ON (p.id = v.post)
                      WHERE p.utente=:utente OR pubblico = 1
                      GROUP BY p.id, titolo, messaggio, utente, pubblico, datac, orac, datam, oram, luogo ) x
                      JOIN
                      (SELECT p.id as idy, p.titolo, p.messaggio, p.utente, pubblico, datac, orac, datam, oram, luogo, COUNT(c.post) as commenti
                      FROM post p LEFT JOIN commento c ON (p.id = c.post)
                      WHERE p.utente=:utente OR pubblico = 1
                      GROUP BY p.id, titolo, messaggio, utente, pubblico, datac, orac, datam, oram, luogo)  y ON (x.idx = y.idy))
                ORDER BY x.datac DESC, x.Orac DESC";
      $stmt = $this->conn->prepare($query);
      $username=htmlspecialchars(strip_tags($username));
      $stmt->bindParam(":utente", $username);
      if ($stmt->execute()) {
        $posts=array();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($rows) {
          foreach ($rows as $row) {
            $post_info=array(
              'id' => $row['id'],
              'titolo' => $row['titolo'],
              'messaggio' => $row['messaggio'],
              'utente' => $row['utente'],
              'pubblico' => $row['pubblico'],
              'datac' => $row['datac'],
              'orac' => $row['orac'],
              'datam' => $row['datam'],
              'oram' => $row['oram'],
              'luogo' => $row['luogo'],
              'voti' => $row['voti'],
              'commenti' => $row['commenti']
            );
            array_push($posts, $post_info);
          }
          return $posts;
        } else {
          return FALSE;   # posts not found
        }
      } else {
        return FALSE;
      }
    }

    function readAll($username){
      $query = "SELECT idx as id, x.titolo, x.messaggio, x.utente, x.pubblico, x.datac, x.orac, x.datam, x.oram, x.luogo, voti, commenti
                FROM( (SELECT p.id as idx, p.titolo, p.messaggio, p.utente, pubblico, datac, orac, datam, oram, luogo, COUNT(v.post) as voti
                      FROM post p LEFT JOIN voti v ON (p.id = v.post)
                      WHERE p.utente=:utente
                      GROUP BY p.id, titolo, messaggio, utente, pubblico, datac, orac, datam, oram, luogo ) x
                      JOIN
                      (SELECT p.id as idy, p.titolo, p.messaggio, p.utente, pubblico, datac, orac, datam, oram, luogo, COUNT(c.post) as commenti
                      FROM post p LEFT JOIN commento c ON (p.id = c.post)
                      WHERE p.utente=:utente
                      GROUP BY p.id, titolo, messaggio, utente, pubblico, datac, orac, datam, oram, luogo)  y ON (x.idx = y.idy))
                ORDER BY x.datac DESC, x.Orac DESC";
      $stmt = $this->conn->prepare($query);
      $username=htmlspecialchars(strip_tags($username));
      $stmt->bindParam(":utente", $username);
      if ($stmt->execute()) {
        $posts=array();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($rows) {
          foreach ($rows as $row) {
            $post_info=array(
              'id' => $row['id'],
              'titolo' => $row['titolo'],
              'messaggio' => $row['messaggio'],
              'utente' => $row['utente'],
              'pubblico' => $row['pubblico'],
              'datac' => $row['datac'],
              'orac' => $row['orac'],
              'datam' => $row['datam'],
              'oram' => $row['oram'],
              'luogo' => $row['luogo'],
              'voti' => $row['voti'],
              'commenti' => $row['commenti']
            );
            array_push($posts, $post_info);
          }
          return $posts;
        } else {
          return FALSE;   # posts not found
        }
      } else {
        return FALSE;
      }
    }

    function redirect($url, $flash_message = NULL) {
      if ($flash_message) {
        $_SESSION["flash"] = $flash_message;
      }
      # session_write_close();
      header("Location: $url");
      die;
    }

    //comments function
    function insert_comment($post, $messaggio, $username, $data, $ora){
      $query = "INSERT INTO commento
                SET
                    post=:post, messaggio=:messaggio, utente=:utente,
                    data=:data, ora=:ora";
      $stmt = $this->conn->prepare($query);
      // sanitize
      $post=htmlspecialchars(strip_tags($post));
      $messaggio=htmlspecialchars(strip_tags($messaggio));
      $username=htmlspecialchars(strip_tags($username));
      $data=htmlspecialchars(strip_tags($data));
      $ora=htmlspecialchars(strip_tags($ora));
      // bind
      $stmt->bindParam(":post", $post);
      $stmt->bindParam(":messaggio", $messaggio);
      $stmt->bindParam(":utente", $username);
      $stmt->bindParam(":data", $data);
      $stmt->bindParam(":ora", $ora);
      // execute query
      if($stmt->execute()){
        return TRUE;
      }else{
        return FALSE;
      }
    }

    function getComments($post){
      $query = "SELECT
                    id, messaggio, utente, data, ora
                FROM commento
                WHERE post=:post
                ORDER BY
                    data DESC, ora DESC";
      $stmt = $this->conn->prepare($query);
      $post=htmlspecialchars(strip_tags($post));
      $stmt->bindParam(":post", $post);
      if ($stmt->execute()) {
        $comments['records'] = array();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($rows) {
          foreach ($rows as $row) {
            $comment_info = array(
              'id' => $row['id'],
              'messaggio' => $row['messaggio'],
              'utente' => $row['utente'],
              'data' => $row['data'],
              'ora' => $row['ora'],
            );
            array_push($comments['records'], $comment_info);
          }
          return $comments;
        } else {
          return FALSE;   # posts not found
        }
      } else {
        return FALSE;
      }
    }

    function deleteCommentsOf($post){
      $query = "DELETE FROM commento WHERE post = ?";

      $stmt = $this->conn->prepare($query);

      $post=htmlspecialchars(strip_tags($post));

      $stmt->bindParam(1, $post);

      if($stmt->execute()){
          return TRUE;
      }else{
          return FALSE;
      }
    }
    // function for like
    function checkLike($post, $username){
      $query = "SELECT post, utente
                FROM voti
                WHERE post = :post AND utente = :utente";
      // prepare query
      $stmt = $this->conn->prepare($query);
      // quote string
      $post=htmlspecialchars(strip_tags($post));
      $username=htmlspecialchars(strip_tags($username));
      // bind param
      $stmt->bindParam(':post', $post);
      $stmt->bindParam(':utente', $username);
      // execute query
      $stmt->execute();
      // get retrieved row
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if (count($rows) > 0) {
        $this->deleteLike($post, $username);
        return TRUE;
      } else {
        $this->addLike($post, $username);
        return FALSE;
      }
    }

    function addLike($post, $username){
      $query = "INSERT INTO voti
                SET
                    post=:post, utente=:utente";
      $stmt = $this->conn->prepare($query);
      // sanitize
      $post=htmlspecialchars(strip_tags($post));
      $username=htmlspecialchars(strip_tags($username));
      // bind
      $stmt->bindParam(":post", $post);
      $stmt->bindParam(":utente", $username);

      $stmt->execute();
    }

    function deleteLike($post, $username){
      $query = "DELETE FROM voti WHERE post = :post AND utente = :utente";

      $stmt = $this->conn->prepare($query);

      $post=htmlspecialchars(strip_tags($post));
      $username=htmlspecialchars(strip_tags($username));

      $stmt->bindParam(":post", $post);
      $stmt->bindParam(":utente", $username);

      $stmt->execute();
    }
    function getLikeInfo($post){
      $query = "SELECT utente
                FROM voti
                WHERE post=:post";
      $stmt = $this->conn->prepare($query);
      // sanitize
      $post=htmlspecialchars(strip_tags($post));
      // bind
      $stmt->bindParam(":post", $post);

      if ($stmt->execute()) {
        $users['records'] = array();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($rows) {
          foreach ($rows as $row) {
            $user_info = array(
              'utente' => $row['utente'],
            );
            array_push($users['records'], $user_info);
          }
          return $users;
        } else {
          return FALSE;   # posts not found
        }
      } else {
        return FALSE;
      }
    }

    // delete the product
    function delete($id){

        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $$id=htmlspecialchars(strip_tags($this->$id));

        // bind id of record to delete
        $stmt->bindParam(1, $this->nickname);

        // execute query
        if($stmt->execute()){
            return TRUE;
        }

        return FALSE;

    }

    // search products
    function searchSimpleInfo($keywords, $username){

        // select all query
        $query = "SELECT
                    id, titolo, utente, pubblico, luogo, datac
                  FROM
                      " . $this->table_name . "
                  WHERE
                      titolo LIKE ? OR utente LIKE ? OR luogo LIKE ?
                  ORDER BY
                      datac DESC";

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
        if($stmt->execute()){
          $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
          if($rows){
            $result=Array();
            foreach ($rows as $row) {
              $post_info=array(
                'id' => $row['id'],
                'titolo' => $row['titolo'],
                'utente' => $row['utente'],
                'luogo' => $row['luogo'],
                'pubblico' => $row['pubblico']
              );
              array_push($result, $post_info);
            }
            return $result;
          } else{
            return FALSE;
          }
        }
    }
}
