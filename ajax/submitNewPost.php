<?php

    include("./../database.php");
    include("./../key.php");
    
    session_start();
    
    $sessionID = $_SESSION['user']['uid'];
    $sessionUsername = $_SESSION['user']['username'];
    $sessionConsoleID = $_SESSION['user']['consoleID'];
    $sessionMembershipID = $_SESSION['user']['membershipID'];
    $sessionFirstCharacter = $_SESSION['user']['firstCharacter'];
    $sessionSecondCharacter = $_SESSION['user']['secondCharacter'];
    $sessionThirdCharacter = $_SESSION['user']['thirdCharacter'];
    
    $firstCharacterEmblem = $_SESSION['user']['firstCharacterEmblem'];
    $secondCharacterEmblem = $_SESSION['user']['secondCharacterEmblem'];
    $thirdCharacterEmblem = $_SESSION['user']['thirdCharacterEmblem'];
    
    $firstCharacterBackground = $_SESSION['user']['firstCharacterBackground'];
    $secondCharacterBackground = $_SESSION['user']['secondCharacterBackground'];
    $thirdCharacterBackground = $_SESSION['user']['thirdCharacterBackground'];
    $bungieURL = "https://bungie.net";
    
    $firstCharacterLight = $_SESSION['user']['firstLightLevel'];
    $secondCharacterLight = $_SESSION['user']['secondLightLevel'];
    $thirdCharacterLight = $_SESSION['user']['thirdLightLevel'];
    $grimoire = $_SESSION['user']['grimoire'];
    

     
    
    //Submit post to database
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        
        // echo htmlspecialchars($_POST['sample5']);
        // echo $_POST['description'];
        // print_r($_POST);
        
        
        
        $errors = array();
        
        //list selections
        $characterName = $_POST['characterName'];
        $activitySelection = $_POST['activitySelection'];
        $activityStr = $_POST['dropdownSelection'];
        // $pvp = $_POST['PvP'];
        // $strikes = $_POST['strikes'];
        // $other = $_POST['other'];
        
        $description = $_POST['description'];
        
        //TODO FILL THIS IN
        $characterSelection = $_POST['characterSlot'];
        $characterID = $_POST['characterID'];
        
        $className = $_POST['className'];
        
        $hasMic = $_POST['micCheckbox'];
        if($hasMic){
            $micOutput = "mic";
        }
        
        //checkbox
        // $activityChoice = $_POST['activity'];
        // if($activityChoice == "Raid"){
            // $a = 'How are you?';
        if (strpos($activityStr, 'Raid') !== false) {
            $activityType = "raid";
            
        }
        else if(strpos($activityStr, 'PvP') !== false){
            // if(strpos($))
            // echo 'pvp';
            $activityType = "pvp";
        }
        else if((strpos($activityStr, 'Weeklies') !== false) || (strpos($activityStr, 'Strike') !== false)){
            $activityType = "strikes";
            // echo 'strikes';
        }
        else if((strpos($activityStr, 'Arena') !== false) || (strpos($activityStr, 'Patrol') !== false)){
            $activityType = "other";
            // echo 'other';
        }
        else if(strpos($activityStr, 'Iron') !== false){
            $activityType = "Iron pvp";
            // echo 'other';
        }
        else if(strpos($activityStr, 'Crucible') !== false){
            $activityType = "Crucible pvp";
            // echo 'other';
        }
        else if(strpos($activityStr, 'Trials') !== false){
            $activityType = "Trials pvp";
            // echo 'other';
        }
        
        
        
        //Character assignment and checking
        if($characterSelection == "0"){
            $emblemIconPath = $firstCharacterEmblem;
            $emblemBackgroundPath = $firstCharacterBackground;
            $lightLevel = $firstCharacterLight;
            // $selectedCharacter = "Titan";
        }
        else if($characterSelection == "1"){
            $emblemIconPath = $secondCharacterEmblem;
            $emblemBackgroundPath = $secondCharacterBackground;
            $lightLevel = $secondCharacterLight;
            // $selectedCharacter = "Hunter";
        }
        else if($characterSelection == "2"){
            $emblemIconPath = $thirdCharacterEmblem;
            $emblemBackgroundPath = $thirdCharacterBackground;
            $lightLevel = $thirdCharacterLight;
            // $selectedCharacter = "Warlock";
        }
        else{
            $errors["character"] = "Character not found.";
        }
        
        
    
        // echo $lightLevel;
        // echo "<p> ",$characterSelection;
        // $errors["database"] = "Database error!";
        
        //if no errors
        
        if(count($errors)==0){ 
            $activitySelection = filter_var($activitySelection, FILTER_SANITIZE_STRING);
            $description = filter_var($description, FILTER_SANITIZE_STRING);
            $emblemIconPath = filter_var($emblemIconPath, FILTER_SANITIZE_URL);
            $emblemBackgroundPath = filter_var($emblemBackgroundPath, FILTER_SANITIZE_URL);
            
            //
            // echo "act var: ", $activityType;
            $query = "INSERT INTO posts (uid, username, membershipID, selectedCharacter, characterID, consoleID, activity, activityType, description, emblemIcon, emblemBackground, lightLevel, grimoireScore, hasMic, postTime) 
                    VALUES ('$sessionID', '$sessionUsername', '$sessionMembershipID', '$className', '$characterID', '$sessionConsoleID', '$activitySelection', '$activityType', '$description', '$bungieURL$emblemIconPath','$bungieURL$emblemBackgroundPath', '$lightLevel', '$grimoire', '$hasMicrophone', NOW() ) 
                    ON DUPLICATE KEY UPDATE selectedCharacter='$className', membershipID='$sessionMembershipID', characterID='$characterID', activity='$activitySelection', activityType='$activityType', description='$description', 
                    emblemIcon='$bungieURL$emblemIconPath', emblemBackground='$bungieURL$emblemBackgroundPath', lightLevel='$lightLevel', grimoireScore='$grimoire', hasMic='$micOutput', postTime=NOW()";
                    
                    // print_r($query);
            if(!$connection->query($query)){
                $errors["database"] = "Database error!";
            }
        }
        
    }
    
    
    
    
?>