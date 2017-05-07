<?php


    include("database.php");
    include("key.php");
    include("head.php");
    
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        
        $errors = array();
        $username = $_POST["username"];
        $password = $_POST["password"];
        $consoleID = $_POST["options"];
        
        $titan = 0;
        $hunter = 1;
        $warlock = 2;
        
        //TODO more error checking
        //1. get membershipID and search by given username
         $getMembershipId = curl_init();
         //case insensitive PSN name search- THIS SPITS OUT AN ARRAY
         curl_setopt($getMembershipId, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/SearchDestinyPlayer/'.$consoleID.'/'.$username.'/');
         curl_setopt($getMembershipId, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($getMembershipId, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $apiKey));
         $getMembershipResults = curl_exec($getMembershipId);
         $getMembershipResponse = json_decode($getMembershipResults);
         
         $membershipID = $getMembershipResponse->Response[0]->membershipId;
         $displayName = $getMembershipResponse->Response[0]->displayName;
         
         //2. Character summary to get all 3 character info
         
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/'.$consoleID.'/Account/'.$membershipID.'/Summary/');
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $apiKey));
         $result = curl_exec($ch);
         $json = json_decode($result);
         
         //INSERT CHARACTER SELECTION ALGORITHM TO GET ALL 3 CHARACTER ID's
         $slot0 = $json->Response->data->characters[0]->characterBase->classType; //wheels = 1, jew = 0
        //  echo "<p>slot 0, json: ", $slot0;
         $slot1 = $json->Response->data->characters[1]->characterBase->classType; //wheels = 0, jew = 1
        //  echo "<p>slot 1, json: ", $slot1;
         $slot2 = $json->Response->data->characters[2]->characterBase->classType; //wheels = 2, jew = 2
        //  echo "<p>slot 2, json: ", $slot2;
         
         //get Titan Slot
         if($titan == $slot0){
             $titanSlot = 0;
         }
         elseif($titan == $slot1){
             $titanSlot = 1;
         }
         elseif($titan == $slot2){
             $titanSlot = 2;
         }
         
         echo "Titan slot: ", $titanSlot;
         
        //  get Hunter slot
        if($hunter == $slot0){
             $hunterSlot = 0;
         }
         elseif($hunter == $slot1){
             $hunterSlot = 1;
         }
         elseif($hunter == $slot2){
             $hunterSlot = 2;
         }
         
         echo "Hunter slot: ", $hunterSlot;
         
         //get warlock slot
         if($warlock == $slot0){
             $warlockSlot = 0;
         }
         elseif($warlock == $slot1){
             $warlockSlot = 1;
         }
         elseif($warlock == $slot2){
             $warlockSlot = 2;
         }
         
         echo "Warlock slot: ", $warlockSlot;
         
         $titanID = $json->Response->data->characters[$titanSlot]->characterBase->characterId;
         $hunterID = $json->Response->data->characters[$hunterSlot]->characterBase->characterId;
         $warlockID = $json->Response->data->characters[$warlockSlot]->characterBase->characterId;
             
             
         
        
            if(strlen($_POST["password"]) < 8){
                $errors["password"] = "Password should be 8 characters or more.";
            }
            
            if($getMembershipResponse->Response == null){
                $errors["username"] = "Username does not exist on Bungie servers.";
            }
            
            if(count($errors)==0){
                $username = filter_var($username, FILTER_SANITIZE_STRING);
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $query = "INSERT INTO accounts (username, password, consoleID, membershipID, titanID, hunterID, warlockID, creation_date, last_update, last_login) VALUES ('$displayName', '$hashed','$consoleID','$membershipID','$titanID', '$hunterID','$warlockID',NOW(),NOW(),NOW())";
                if(!$connection->query($query)){
                    $errors["database"] = "Database error!";
                }
            }
        
    }



?>