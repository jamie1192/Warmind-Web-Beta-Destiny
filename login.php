<?php 
    
    include("database.php");
    include("head.php");

    include("key.php");

    
    session_start();
    
    if(isset($_SESSION['user'])){
        header("location:layout sandbox2.1.php");  
    }
    
    if($_SERVER["REQUEST_METHOD"]=="POST"){
          
        $errors=array();
        $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
        //   $password = $_POST["password"];
        
        //get user account using the email
        //   , consoleID, membershipID, titanID, hunterID, warlockID,

        $query = "SELECT uid, username, password, consoleID, membershipID, titanID, hunterID, warlockID FROM accounts WHERE username='$username'";

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
            $activeTitanID = $userdata["titanID"];
            // $activeTitanSlot = $userdata["titanSlot"];
            $activeHunterID = $userdata["hunterID"];
            // $activeHunterSlot = $userdata["hunterSlot"];
            $activeWarlockID = $userdata["warlockID"];
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
         $slot0 = $json->Response->data->characters[0]->characterBase->classType; //wheels = 1, jew = 0
        //  echo "<p>slot 0, json: ", $slot0;
         $slot1 = $json->Response->data->characters[1]->characterBase->classType; //wheels = 0, jew = 1
        //  echo "<p>slot 1, json: ", $slot1;
         $slot2 = $json->Response->data->characters[2]->characterBase->classType; //wheels = 2, jew = 2
        //  echo "<p>slot 2, json: ", $slot2;
         
         $titan = 0;
         $hunter = 1;
         $warlock = 2;
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
        $titanLightLevel = $json->Response->data->characters[$titanSlot]->characterBase->powerLevel;
        $hunterLightLevel = $json->Response->data->characters[$hunterSlot]->characterBase->powerLevel;
        $warlockLightLevel = $json->Response->data->characters[$warlockSlot]->characterBase->powerLevel;
        $grimoire = $json->Response->data->characters[$titanSlot]->characterBase->grimoireScore;

         //ends here
            //end JSON
            

            $password = $_POST["password"];
            if(password_verify($password, $stored_pw)){
                //get user data etc
                session_start();
                // $_SESSION['user'] = array('id' => '...', name => '...', ...);

                // $_SESSION['user'] = array('uid' => $id, 'username' => $username, 'consoleID' => $console, 'membershipID' => $activeMembershipID, 'titanID' => $activeTitanID, 'titanSlot' =>$activeTitanSlot, 'titanEmblem', 'hunterID' => $activeHunterID, 'hunterSlot' => $activeHunterSlot, 'hunterEmblem', 'warlockID' => $activeWarlockID, 'warlockSlot' => $activeWarlockSlot, 'warlockEmblem');
                $_SESSION['user'] = array('uid' => $id, 'username' => $stored_username, 'consoleID' => $consoleID, 'membershipID' => $activeMembershipID, 
                    'titanID' => $activeTitanID, 'titanSlot' => $titanSlot, 'titanEmblem' => $titanEmblem, 'titanBackground' => $titanBackground, 
                    'titanLightLevel' => $titanLightLevel, 'hunterID' => $activeHunterID, 'hunterSlot' => $hunterSlot, 'hunterEmblem' => $hunterEmblem, 
                    'hunterBackground' => $hunterBackground, 'hunterLightLevel' => $hunterLightLevel, 'warlockID' => $activeWarlockID, 'warlockSlot' => $warlockSlot, 
                    'warlockEmblem' => $warlockEmblem, 'warlockBackground' => $warlockBackground, 'warlockLightLevel' => $warlockLightLevel, 'grimoire' => $grimoire);

               

                // $_SESSION["uid"] = $id;
                // $_SESSION["username"] = $username;
                // $_SESSION["consoleID"] = $console;
                // $_SESSION["membershipID"] = $activeMembershipID;
                // $_SESSION["titanID"] = $activeTitanID;
                // $_SESSION["hunterID"] = $activeHunterID;
                // $_SESSION["warlockID"] = $activeWarlockID;
                
                //redirect to accounts.php page
                header("location:homeSandbox.php");
            }
            else{
                $errors["password"]="Incorrect username or password.";
            }
        }
              
        else{
            //throw error (can't find user?)
            $errors["username"]="Incorrect username or password";
            
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
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <form id="login-form" method="post" action="login.php">
                                <?php 
                                    if($errors["username"]){
                                        $username_error = $errors["username"];
                                        $username_error_class = "has-error";
                                    }
                                ?>
                                <!--Username field-->
                                <div class="form-group <?php echo $username_error_class; ?> mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="form-control mdl-textfield__input" type="text" id="username" name="username" value="<?php echo $username; ?>">
                                        <label class="mdl-textfield__label mdl-text-color--accent" for="username">Username</label>
                                    <!--<span class=" errorCode mdl-textfield__error"><?php echo $username_error; ?></span>-->
                                </div>
                             
                                <!--Password field-->
                                 <?php 
                                    if($errors["password"]){
                                        $pw_error = $errors["password"];
                                        $pw_error_class = "has-error";
                                    }
                                ?>
                                <div class="form-group <?php echo $pw_error_class;?> mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="form-control mdl-textfield__input" type="password" id="password" name="password">
                                    <label class="mdl-textfield__label" for="password">Password</label>
                                    <span class="errorCode mdl-textfield__error"><?php echo $pw_error; ?></span>
                                </div>
                            <!--login button-->
                            <div class="mdl-dialog__actions mdl-dialog__actions--full-width">
                                <!--<div class="mdl-dialog__actions mdl-dialog__actions--full-width">-->
                                <button class="mdl-button close mdl-js-button mdl-js-ripple-effect mdl-button--primary " type="submit" name="submit">Login</button>
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
                                    <a class="mdl-button close mdl-js-button mdl-js-ripple-effect mdl-button--primary mdl-dialog__actions--full-width" href="register.php">Sign Up</a>
                                    <!--<a href="register.php"></a>-->
                                <!--</form>-->
                                <!--</div>-->
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            </main>
        </div>
     <!--</div>-->
    </body>
</html>


