<?php

    //TODO error for if account already exists


    include("database.php");
    include("key.php");
    include("head.php");
    include("homeHeader.php");
    
    
    
    if(isset($_SESSION['user'])){
        header("location:home.php");  
    }
    
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        
        $errors = array();
        $username = $_POST["username"];
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirmPassword"];
        $consoleID = $_POST["options"];
        
        
        //1. get membershipID and search by given username
         $getMembershipId = curl_init();
         //case insensitive PSN name search- THIS SPITS OUT AN ARRAY
         curl_setopt($getMembershipId, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/SearchDestinyPlayer/'.$consoleID.'/'.$username.'/');
         curl_setopt($getMembershipId, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($getMembershipId, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $apiKey));
         $getMembershipResults = curl_exec($getMembershipId);
         $getMembershipResponse = json_decode($getMembershipResults);
         

         
         $activeMembershipID = $getMembershipResponse->Response[0]->membershipId;
         $displayName = $getMembershipResponse->Response[0]->displayName;
         
         //2. Character summary to get all 3 character info
         
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/'.$consoleID.'/Account/'.$activeMembershipID.'/Summary/');
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $apiKey));
         $result = curl_exec($ch);
         $json = json_decode($result);
         
        //INSERT CHARACTER SELECTION ALGORITHM TO GET ALL 3 CHARACTER ID's
         $slot0character = $json->Response->data->characters[0]->characterBase->classType; //wheels = 1, jew = 0
        //  echo "<p>slot 0, json: ", $slot0;
         $slot1character = $json->Response->data->characters[1]->characterBase->classType; //wheels = 0, jew = 1
        //  echo "<p>slot 1, json: ", $slot1;
         $slot2character = $json->Response->data->characters[2]->characterBase->classType; //wheels = 2, jew = 2
        //  echo "<p>slot 2, json: ", $slot2;
         
         $titan = 0;
         $hunter = 1;
         $warlock = 2;
         
        //character in first slot
        if($slot0character == $titan){
            $firstCharacterClass = "Titan";
        }
        elseif($slot0character == $hunter){
            $firstCharacterClass = "Hunter";
        }
        elseif($slot0character == $warlock){
            $firstCharacterClass = "Warlock";
        }
         
        //  echo "<p>Titan slot: ", $titanSlot;
         
        //  get second character
        if($slot1character == $titan){
            $secondCharacterClass = "Titan";
        }
        elseif($slot1character == $hunter){
            $secondCharacterClass = "Hunter";
        }
        elseif($slot1character == $warlock){
            $secondCharacterClass = "Warlock";
        }
         
        //  echo "Hunter slot: ", $hunterSlot;
         
         //third character slot
        if($slot2character == $titan){
            $thirdCharacterClass = "Titan";
        }
        elseif($slot2character == $hunter){
            $thirdCharacterClass = "Hunter";
        }
        elseif($slot2character == $warlock){
            $thirdCharacterClass = "Warlock";
        }
         
        //  echo "Warlock slot: ", $warlockSlot;
        
        $firstCharacterID = $json->Response->data->characters[0]->characterBase->characterId;
        $secondCharacterID = $json->Response->data->characters[1]->characterBase->characterId;
        $thirdCharacterID = $json->Response->data->characters[2]->characterBase->characterId;
         
        //emblems
        $firstCharacterEmblem = $json->Response->data->characters[0]->emblemPath;
        $secondCharacterEmblem = $json->Response->data->characters[1]->emblemPath;
        $thirdCharacterEmblem = $json->Response->data->characters[2]->emblemPath;
        
        
        $firstCharacterBackground = $json->Response->data->characters[0]->backgroundPath;
        $secondCharacterBackground = $json->Response->data->characters[1]->backgroundPath;
        $thirdCharacterBackground = $json->Response->data->characters[2]->backgroundPath;
         
         //ends here
         
         //light level, grimoire
        $firstCharacterLight = $json->Response->data->characters[0]->characterBase->powerLevel;
        $secondCharacterLight = $json->Response->data->characters[1]->characterBase->powerLevel;
        $thirdCharacterLight = $json->Response->data->characters[2]->characterBase->powerLevel;
        $grimoire = $json->Response->data->characters[0]->characterBase->grimoireScore;

         //ends here
             
             
            if(count($getMembershipResponse->Response)==null){
                $errors["username"] = "Username does not exist on Bungie servers.";
            }
        
            if(strlen($_POST["password"]) < 8){
                $errors["password"] = "Password should be 8 characters or more.";
            }
            
            if($_POST["password"] != $_POST["confirmPassword"]){
                $errors["password"] = "Password mismatch.";
            }
            
            print_r($errors);
            
            if(count($errors)==0){
                $username = filter_var($username, FILTER_SANITIZE_STRING);
                $hashed = password_hash($password, PASSWORD_DEFAULT);
               
                
                
                // $selectQuery
                $query = "SELECT membershipID FROM accounts WHERE membershipID='$activeMembershipID'";

        // $query = "SELECT uid, username, password, consoleID, membershipID, titanID, titanSlot, hunterID, hunterSlot, warlockID, warlockSlot FROM accounts WHERE username='$username'";

        //   echo $query;
        if(!$connection->query($query)){
                $errors["database"] = "Database error!";
        }
        $result = $connection->query($query);
        if($result->num_rows > 0){
            $errors["username"] = "Bungie membershipID already registered!";
        }
        
        else{
                
                $query = "INSERT INTO accounts (username, password, consoleID, membershipID,  
                    creation_date, last_update, last_login) 
                    VALUES ('$displayName', '$hashed','$consoleID','$activeMembershipID', NOW(),NOW(),NOW())";
                
                
                // $uid = $db->lastInsertId();
                // $_SESSION['user'] = array('uid' => $id, 'username' => $displayName, 'consoleID' => $consoleID, 'membershipID' => $membershipID, 
                //     'titanID' => $activeTitanID, 'titanSlot' => $titanSlot, 'titanEmblem' => $titanEmblem, 'titanBackground', 'hunterID' => $activeHunterID, 
                //     'hunterSlot' => $activeHunterSlot, 
                //     'hunterEmblem' => $hunterEmblem, 'hunterBackground' => $hunterBackground, 'warlockID' => $activeWarlockID, 'warlockSlot' => $activeWarlockSlot, 
                //     'warlockEmblem' => $warlockEmblem, 'warlockBackground' => $warlockBackground, 'lightLevel' => $lightLevel, 'grimoire' => $grimoire);
                
                
                // print_r($_SESSION);
                
                // exit();

                if(!$connection->query($query)){
                    $errors["database"] = "Database error!";
                }
                $uid = mysqli_insert_id($connection);
                session_start();
                $_SESSION['user'] = array('uid' => $uid, 'username' => $displayName, 'consoleID' => $consoleID, 'membershipID' => $activeMembershipID, 
                    'firstCharacterID' => $firstCharacterID, 'firstCharacter' => $firstCharacterClass,'firstCharacterEmblem' => $firstCharacterEmblem, 'firstCharacterBackground' => $firstCharacterBackground, 'firstLightLevel' => $firstCharacterLight, 
                    'secondCharacterID' => $secondCharacterID,'secondCharacter' => $secondCharacterClass,'secondCharacterEmblem' => $secondCharacterEmblem, 'secondCharacterBackground' => $secondCharacterBackground, 'secondLightLevel' => $secondCharacterLight, 
                    'thirdCharacterID' => $thirdCharacterID, 'thirdCharacter' => $thirdCharacterClass, 'thirdCharacterEmblem' => $thirdCharacterEmblem, 'thirdCharacterBackground' => $thirdCharacterBackground, 'thirdLightLevel' => $thirdCharacterLight, 
                    'grimoire' => $grimoire);
                    
                    header("location:home.php");
            }
        }
    }



?>

<!doctype html>
<html>
    <body>
        <div class="mdl-layout mdl-js-layout">
            <main class="loginCard mdl-layout__content">
            <div class="mdl-card mdl-shadow--2dp">
                <div class="mdl-card__title mdl-color--accent mdl-color-text--black">
                    <h2 class="mdl-card__title-text">Sign Up</h2>
                </div>
                <div class="mdl-card__supporting-text ">
                    <!--<div class="row ">-->
                        <!--<div class="col-md-4 cold-md-offset-4">-->
                            <form id="register-form" method="post" action="register.php">
                                <?php
                                    if($errors["username"]){
                                        $username_error = $errors["username"];
                                        $username_error_class = "has-error";
                                    }
                                ?>
                                
                                <!--Username field-->
                                <div class="<?php echo $username_error_class; ?> mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" name="username" value="<?php echo $username; ?>">
                                    <label class="mdl-textfield__label" for="username">PSN Name/Xbox Gamertag</label>

                                    <span class = "errorCode mdl-textfield__error"><?php echo $username_error; ?></span>

                                </div>
                                
                                <!--Password field-->
                                <?php 
                                    if($errors["password"]){
                                        $pw_error = $errors["password"];
                                        $pw_error_class = "has-error";
                                    }
                                ?>
                                <div class = "<?php echo $pw_error_class;?> mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="password" id="password" name="password">
                                    <label class="mdl-textfield__label" for="password">Password (min. 8 characters)</label>
                                    <!--<span class="errorCode mdl-textfield__error"> ?php echo $pw_error; ?></span>-->
                                </div>
                                
                                <!--//confirm password-->
                                <div class = "<?php echo $pw_error_class;?> mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="form-control mdl-textfield__input" type="password" id="confirmPassword" name="confirmPassword">
                                    <label class="mdl-textfield__label mdl-text-color--accent" for="confirmPassword">Confirm Password</label>
                                    
                                    <span class="errorCode mdl-textfield__error"><?php echo $pw_error; ?></span>
                                </div>
                                
                                <!--<select>-->
                                <!--    <option value="2">PlayStation</option>-->
                                <!--    <option value="3">Xbox</option>-->
                                <!--</select>-->
                                
                                <!--full width card action for radio?-->
                                <div class="mdl-dialog__actions mdl-dialog__action--full-width">
                                    <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-1">
                                        <input type="radio" id="option-1" class="mdl-radio__button" name="options" value="1" checked>
                                            <span class="mdl-radio__label">Xbox</span>
                                    </label>
                                    <div class="mdl-layout-spacer"></div>
                                    <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-2">
                                        <input type="radio" id="option-2" class="mdl-radio__button" name="options" value="2">
                                            <span class="mdl-radio__label">PlayStation</span>
                                    </label>
                                </div>
                                
                                <!--Sign Up button-->
                                <div class="mdl-dialog__actions mdl-dialog__actions--full-width">
                                    <button class="mdl-button close mdl-js-button mdl-js-ripple-effect mdl-button--primary mdl-dialog__actions--full-width" type="submit" name="submit">Sign Up</button>
                                </div>
                            </form>
                        <!--</div>-->
                    <!--</div>-->
                </div>
            </div>
            </main>
        </div>
    </body>
</html>