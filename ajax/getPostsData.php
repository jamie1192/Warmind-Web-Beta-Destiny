<?php include ("../database.php");
  if($_SERVER["REQUEST_METHOD"]=="POST"){
      $posts = array();
      //get posts from database
      $query="SELECT * FROM posts";
      
      $result = $connection->query($query);
      
      if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
          array_push($posts,$row);
        }
        echo json_encode($posts);
      }
  }
?>