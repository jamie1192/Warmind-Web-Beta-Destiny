<?php include ("../database.php");
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $posts = array();
        //get posts from database
        $query="SELECT * FROM posts WHERE activityType = 'other' ORDER BY postTime DESC";
        
        $result = $connection->query($query);
        
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                
                $rowTime = $row["postTime"];
                // $now = new date("Y-m-d H:i:s");
                // $diff=$now->diff($rowTime);
                // $diff=date_diff($rowTime, $now);
                // $posts["age"] = $diff;
                $date = new DateTime($rowTime);
                $now = new DateTime();
                
                // $row["age"] = $date->diff($now)->format("%d days, %h hours and %i minutes");
                $row["ageD"] = $date->diff($now)->format("%d");
                $row["ageH"] = $date->diff($now)->format("%h");
                $row["ageM"] = $date->diff($now)->format("%i");
                // $posts["age"] = $interval->format('%h:%i:%s');
            array_push($posts,$row);
        }
            echo json_encode($posts);
        }
    }
?>