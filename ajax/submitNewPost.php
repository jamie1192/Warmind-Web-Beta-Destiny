<?php

    include("database.php");
    include("./../key.php");
    
    session_start();
    
    $sessionID = $_SESSION['user']['uid'];
    $sessionUsername = $_SESSION['user']['username'];
    $sessionConsoleID = $_SESSION['user']['consoleID'];
    $sessionMembershipID = $_SESSION['user']['membershipID'];
    $activeTitanSlot = $_SESSION['user']['titanSlot'];
    $activeHunterSlot = $_SESSION['user']['hunterSlot'];
    $activeWarlock = $_SESSION['user']['warlockSlot'];
    
    $titanEmblemIcon = $_SESSION["titanEmblemIconPath"];
    $hunterEmblemIcon = $_SESSION["hunterEmblemIconPath"];
    $warlockEmblemIcon = $_SESSION["warlockEmblemIconPath"];
    $titanEmblem = $_SESSION["titanEmblemBackground"];
    $hunterEmblem = $_SESSION["hunterEmblemBackground"];
    $warlockEmblem = $_SESSION["warlockEmblemBackground"];
    $bungieURL = "https://bungie.net";
    
    $titanLightLevel = $_SESSION["titanLightLevel"];
    $hunterLightLevel = $_SESSION["hunterLightLevel"];
    $warlockLightLevel = $_SESSION["warlockLightLevel"];
    $grimoire = $_SESSION["grimoire"];
    
    
    //Submit post to database
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        
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
        }
        else if($characterSelection == 1){
            $emblemIconPath = $hunterEmblemIcon;
            $emblemBackgroundPath = $hunterEmblem;
            $lightLevel = $hunterLightLevel;
        }
        else if($characterSelection == 2){
            $emblemIconPath = $warlockEmblemIcon;
            $emblemBackgroundPath = $titanEmblem;
            $lightLevel = $warlockLightLevel;
        }
        else{
            //error
        }
    
    
        
        //if no errors
        if(count($errors)==0){
            $activitySelection = filter_var($activitySelection, FILTER_SANITIZE_STRING);
            $description = filter_var($description, FILTER_SANITIZE_STRING);
            
            //
            $query = "INSERT INTO posts (uid, username, selectedCharacter, consoleID, activity, description, emblemIcon, emblemBackground, lightLevel, 
                    grimoireScore, hasMic, postTime) VALUES ('$sessionID', '$sessionUsername', '$characterSelection', '$sessionConsoleID','$activitySelection',
                    '$description', '$emblemIconPath','$emblemBackgroundPath', '$lightLevel', '$grimoire', '$hasMicrophone', NOW() )";
            if(!$connection->query($query)){
                $errors["database"] = "Database error!";
            }
        }
        
    }
    
    
    
    
?>