<?php

    //TODO error for if account already exists


    include("database.php");
    include("key.php");
    include("head.php");
    
    session_start();
    
    if(isset($_SESSION['user'])){
        header("location:home.php");  
    }
    
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        
        $errors = array();
        $username = $_POST["username"];
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirmPassword"];
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
         
        //  echo "Error status: ", $getMembershipResults;
        //  echo "Error Response: ", $getMembershipResponse;
         
         
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
         
        //  echo "<p>Titan slot: ", $titanSlot;
         
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
         
        //  echo "Hunter slot: ", $hunterSlot;
         
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
         
        //  echo "Warlock slot: ", $warlockSlot;
         
        $titanID = $json->Response->data->characters[$titanSlot]->characterBase->characterId;
        $hunterID = $json->Response->data->characters[$hunterSlot]->characterBase->characterId;
        $warlockID = $json->Response->data->characters[$warlockSlot]->characterBase->characterId;
         
         //emblems
        $titanEmblem = $json->Response->data->characters[$titanSlot]->emblemPath;
        $hunterEmblem = $json->Response->data->characters[$hunterSlot]->emblemPath;
        $warlockEmblem = $json->Response->data->characters[$warlockSlot]->emblemPath;
        
        
        $titanBackground = $json->Response->data->characters[$titanSlot]->backgroundPath;
        $hunterBackground = $json->Response->data->characters[$hunterSlot]->backgroundPath;
        $warlockBackground = $json->Response->data->characters[$warlockSlot]->backgroundPath;
         
         //ends here
         
         //light level, grimoire
        $titanLightLevel = $getEmblemsResult->Response->data->characters[$titanSlot]->characterBase->powerLevel;
        $hunterLightLevel = $getEmblemsResult->Response->data->characters[$hunterSlot]->characterBase->powerLevel;
        $warlockLightLevel = $getEmblemsResult->Response->data->characters[$warlock]->characterBase->powerLevel;
        $grimoire = $getEmblemsResult->Response->data->characters[$titanSlot]->characterBase->grimoireScore;

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
            
            // print_r($errors);
            
            if(count($errors)==0){
                $username = filter_var($username, FILTER_SANITIZE_STRING);
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $query = "INSERT INTO accounts (username, password, consoleID, membershipID, titanID, hunterID, warlockID, 
                    creation_date, last_update, last_login) 
                    VALUES ('$displayName', '$hashed','$consoleID','$membershipID','$titanID', '$hunterID', '$warlockID', NOW(),NOW(),NOW())";
                
                $_SESSION['user'] = array('uid' => $id, 'username' => $displayName, 'consoleID' => $consoleID, 'membershipID' => $membershipID, 
                    'titanID' => $activeTitanID, 'titanSlot' => $titanSlot, 'titanEmblem' => $titanEmblem, 'titanBackground', 'hunterID' => $activeHunterID, 
                    'hunterSlot' => $activeHunterSlot, 
                    'hunterEmblem' => $hunterEmblem, 'hunterBackground' => $hunterBackground, 'warlockID' => $activeWarlockID, 'warlockSlot' => $activeWarlockSlot, 
                    'warlockEmblem' => $warlockEmblem, 'warlockBackground' => $warlockBackground, 'lightLevel' => $lightLevel, 'grimoire' => $grimoire);
                header("location:home.php");
                exit();
                if(!$connection->query($query)){
                    $errors["database"] = "Database error!";
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
                    <div class="row ">
                        <div class="col-md-4 cold-md-offset-4">
                            <form id="register-form" method="post" action="register.php">
                                <?php
                                    if($errors["username"]){
                                        $username_error = $errors["username"];
                                        $username_error_class = "has-error";
                                    }
                                ?>
                                
                                <!--Username field-->
                                <div class="form-group <?php echo $username_error_class; ?> mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="form-control mdl-textfield__input" name="username" value="<?php echo $username; ?>">
                                    <label class="mdl-textfield__label" for="username">PSN Name/Xbox Gamertag</label>
                                    <span class = "errorCode mdl-textfield__error"> <?php echo $username_error; ?></span>
                                </div>
                                
                                <!--Password field-->
                                <?php 
                                    if($errors["password"]){
                                        $pw_error = $errors["password"];
                                        $pw_error_class = "has-error";
                                    }
                                ?>
                                <div class = "form-group <?php echo $pw_error_class;?> mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="form-control mdl-textfield__input" type="password" id="password" name="password">
                                    <label class="mdl-textfield__label" for="password">Password (min. 8 characters)</label>
                                    <!--<span class="errorCode mdl-textfield__error"> ?php echo $pw_error; ?></span>-->
                                </div>
                                
                                <!--//confirm password-->
                                <div class = "form-group <?php echo $pw_error_class;?> mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
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
                        </div>
                    </div>
                </div>
            </div>
            </main>
        </div>
    </body>
</html>