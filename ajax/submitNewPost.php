<?php

    include("./../database.php");
    include("./../key.php");
    
    session_start();
    
    $sessionID = $_SESSION['user']['uid'];
    $sessionUsername = $_SESSION['user']['username'];
    $sessionConsoleID = $_SESSION['user']['consoleID'];
    $sessionMembershipID = $_SESSION['user']['membershipID'];
    $activeTitanSlot = $_SESSION['user']['titanSlot'];
    $activeHunterSlot = $_SESSION['user']['hunterSlot'];
    $activeWarlock = $_SESSION['user']['warlockSlot'];
    
    $titanEmblemIcon = $_SESSION['user']['titanEmblem'];
    $hunterEmblemIcon = $_SESSION['user']['hunterEmblem'];
    $warlockEmblemIcon = $_SESSION['user']['warlockEmblem'];
    $titanEmblem = $_SESSION['user']['titanBackground'];
    $hunterEmblem = $_SESSION['user']['hunterBackground'];
    $warlockEmblem = $_SESSION['user']['warlockBackground'];
    $bungieURL = "https://bungie.net";
    
    $titanLightLevel = $_SESSION['user']['titanLightLevel'];
    $hunterLightLevel = $_SESSION['user']['hunterLightLevel'];
    $warlockLightLevel = $_SESSION['user']['warlockLightLevel'];
    $grimoire = $_SESSION['user']['grimoire'];
    
    
    //Submit post to database
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        
        // echo htmlspecialchars($_POST['sample5']);
        print_r($_POST);
        
        
        
        $errors = array();
        
        $activitySelection = $_POST['activitySelection'];
        $description = $_POST['description'];
        
        //TODO FILL THIS IN
        $characterSelection = $_POST[''];
        $hasMicrophone = $_POST[''];
        
        if($characterSelection == 0){
            $emblemIconPath = $titanEmblemIcon;
            $emblemBackgroundPath = $titanEmblem;
            $lightLevel = $titanLightLevel;
            $selectedCharacter = "Titan";
        }
        else if($characterSelection == 1){
            $emblemIconPath = $hunterEmblemIcon;
            $emblemBackgroundPath = $hunterEmblem;
            $lightLevel = $hunterLightLevel;
            $selectedCharacter = "Hunter";
        }
        else if($characterSelection == 2){
            $emblemIconPath = $warlockEmblemIcon;
            $emblemBackgroundPath = $titanEmblem;
            $lightLevel = $warlockLightLevel;
            $selectedCharacter = "Warlock";
        }
        else{
            //error
        }
    
        $errors["database"] = "Database error!";
        
        //if no errors
        if(count($errors)==0){
            $activitySelection = filter_var($activitySelection, FILTER_SANITIZE_STRING);
            $description = filter_var($description, FILTER_SANITIZE_STRING);
            $emblemIconPath = filter_var($emblemIconPath, FILTER_SANITIZE_URL);
            $emblemBackgroundPath = filter_var($emblemBackgroundPath, FILTER_SANITIZE_URL);
            
            //
            $query = "INSERT INTO posts (uid, username, selectedCharacter, consoleID, activity, description, emblemIcon, emblemBackground, lightLevel, 
                    grimoireScore, hasMic, postTime) VALUES ('$sessionID', '$sessionUsername', '$selectedCharacter', '$sessionConsoleID','$activitySelection',
                    '$description', '$bungieURL$emblemIconPath','$bungieURL$emblemBackgroundPath', '$lightLevel', '$grimoire', '$hasMicrophone', NOW() )";
            if(!$connection->query($query)){
                $errors["database"] = "Database error!";
            }
        }
        
    }
    
    
    
    
?>