<?php 
    
    include("database.php");
    include("head.php");

    include("key.php");

    
    session_start();
    
    if(isset($_SESSION['user'])){
        header("location:home.php");  
    }
    
    if($_SERVER["REQUEST_METHOD"]=="POST"){
          
        $errors=array();
        $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
        //   $password = $_POST["password"];
        
        //get user account using the email
        //   , consoleID, membershipID, titanID, hunterID, warlockID,

        $query = "SELECT uid, username, password, consoleID, membershipID FROM accounts WHERE username='$username'";

        // $query = "SELECT uid, username, password, consoleID, membershipID, titanID, titanSlot, hunterID, hunterSlot, warlockID, warlockSlot FROM accounts WHERE username='$username'";

        //   echo $query;
        if(!$connection->query($query)){
            $errors["database"] = "Database error!";
        }
        $result = $connection->query($query);
        if($result->num_rows > 0){
            //the user exists
            $userdata = $result->fetch_assoc();
            $stored_pw = $userdata["password"];
            $stored_username = $userdata["username"];
            $id = $userdata["uid"];

            $consoleID = $userdata["consoleID"];
            $activeMembershipID = $userdata["membershipID"];
            
            
            $query = "UPDATE accounts
                    SET last_login=NOW()
                    WHERE username = '$username'";
                    
            if(!$connection->query($query)){
                $errors["database"] = "Database error!";
            }        
            // "SELECT username, last_login FROM accounts WHERE username='$stored_username' UPDATE last_login='NOW()'";
            // "UPDATE accounts SET last_login='NOW()' WHERE username = '$stored_username'";
            // "UPDATE last_login SET `LAST_LOGIN` = now() WHERE `ACCOUNT_id` = `LoggedInUser`");
            
            // UPDATE table SET user_last_login='$date' WHERE user_name='$name' AND user_pass='$password'";"
            // $activeTitanID = $userdata["titanID"];
            // $activeTitanSlot = $userdata["titanSlot"];
            // $activeHunterID = $userdata["hunterID"];
            // $activeHunterSlot = $userdata["hunterSlot"];
            // $activeWarlockID = $userdata["warlockID"];
            // $activeWarlockSlot = $userdata["warlockSlot"];
              
            //   if($username != $stored_username){
            //       $errors["username"] = "Username does not exist on Bungie servers.";
            //   }

            
        //JSON requests
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
            //end JSON
            

            $password = $_POST["password"];
            if(password_verify($password, $stored_pw)){
                //get user data etc
                session_start();
                // $_SESSION['user'] = array('id' => '...', name => '...', ...);

                // $_SESSION['user'] = array('uid' => $id, 'username' => $username, 'consoleID' => $console, 'membershipID' => $activeMembershipID, 'titanID' => $activeTitanID, 'titanSlot' =>$activeTitanSlot, 'titanEmblem', 'hunterID' => $activeHunterID, 'hunterSlot' => $activeHunterSlot, 'hunterEmblem', 'warlockID' => $activeWarlockID, 'warlockSlot' => $activeWarlockSlot, 'warlockEmblem');
                $_SESSION['user'] = array('uid'=> $id, 'username' => $stored_username, 'consoleID' => $consoleID, 'membershipID' => $activeMembershipID, 
                    'firstCharacterID' => $firstCharacterID, 'firstCharacter' => $firstCharacterClass,'firstCharacterEmblem' => $firstCharacterEmblem, 'firstCharacterBackground' => $firstCharacterBackground, 'firstLightLevel' => $firstCharacterLight, 
                    'secondCharacterID' => $secondCharacterID,'secondCharacter' => $secondCharacterClass,'secondCharacterEmblem' => $secondCharacterEmblem, 'secondCharacterBackground' => $secondCharacterBackground, 'secondLightLevel' => $secondCharacterLight, 
                    'thirdCharacterID' => $thirdCharacterID, 'thirdCharacter' => $thirdCharacterClass, 'thirdCharacterEmblem' => $thirdCharacterEmblem, 'thirdCharacterBackground' => $thirdCharacterBackground, 'thirdLightLevel' => $thirdCharacterLight, 
                    'grimoire' => $grimoire);

               

                // $_SESSION["uid"] = $id;
                // $_SESSION["username"] = $username;
                // $_SESSION["consoleID"] = $console;
                // $_SESSION["membershipID"] = $activeMembershipID;
                // $_SESSION["titanID"] = $activeTitanID;
                // $_SESSION["hunterID"] = $activeHunterID;
                // $_SESSION["warlockID"] = $activeWarlockID;
                
                //redirect to accounts.php page
                header("location:home.php");
            }
            else{
                $errors["password"]="Incorrect username or password.";
            }
        }
              
        else{
            //throw error (can't find user?)
            $errors["password"]="Incorrect username or password";
            
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
                    <h2 class="mdl-card__title-text">Existing User Login</h2>
                </div>
                <div class="mdl-card__supporting-text">
                    <!--<div class="row">-->
                        <!--<div class="col-md-4 col-md-offset-4">-->
                            <form id="login-form" method="post" action="login.php">
                                <?php 
                                    if($errors["username"]){
                                        $username_error = $errors["username"];
                                        $username_error_class = "has-error";
                                    }
                                ?>
                                <!--Username field-->
                                <div class="<?php echo $username_error_class; ?> mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" type="text" id="username" name="username" value="<?php echo $username; ?>">
                                        <label class="mdl-textfield__label mdl-text-color--accent" for="username">Username</label>
                                    <!--<span class=" errorCode mdl-textfield__error">?php echo $username_error; ?></span>-->
                                </div>
                             
                                <!--Password field-->
                                 <?php 
                                    if($errors["password"]){
                                        $pw_error = $errors["password"];
                                        $pw_error_class = "has-error";
                                    }
                                ?>
                                <div class="<?php echo $pw_error_class;?> mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="password" id="password" name="password">
                                    <label class="mdl-textfield__label" for="password">Password</label>
                                    <span class="errorCode mdl-textfield__error"><?php echo $pw_error; ?></span>
                                </div>
                            <!--login button-->
                            <div class="mdl-dialog__actions mdl-dialog__actions--full-width">
                                <!--<div class="mdl-dialog__actions mdl-dialog__actions--full-width">-->
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary " type="submit" name="submit">Login</button>
                                <!--</div>-->
                                <!--or divider-->
                                <div class="mdl-dialog__actions  mdl-dialog__actions--full-width">
                                    <!--<div class="mdl-layout-spacer"></div>-->
                                    <button type="button" class="mdl-button" disabled>OR</button>
                                </div>
                                <!--</form>-->
                                <!--Sign up button-->
                                <!--<div class="mdl-dialog__actions mdl-dialog__actions--full-width">-->
                                <!--<form action="register.php">-->
                                    <!--<div class="mdl-layout-spacer"></div>-->
                                    <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary mdl-dialog__actions--full-width" href="register.php">Sign Up</a>
                                    <!--<a href="register.php"></a>-->
                                <!--</form>-->
                                <!--</div>-->
                            </div>
                        </form>
                        <!--</div>-->
                    <!--</div>-->
                </div>
            </div>
            </main>
        </div>
     <!--</div>-->
    </body>
</html>


