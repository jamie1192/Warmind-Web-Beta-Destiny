<?php 
    
    include("database.php");
    include("head.php");
    
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
        $query = "SELECT uid, username, password, consoleID, membershipID, titanID, titanSlot, hunterID, hunterSlot, warlockID, warlockSlot FROM accounts WHERE username='$username'";
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
            $console = $userdata["consoleID"];
            $activeMembershipID = $userdata["membershipID"];
            $activeTitanID = $userdata["titanID"];
            $activeTitanSlot = $userdata["titanSlot"];
            $activeHunterID = $userdata["hunterID"];
            $activeHunterSlot = $userdata["hunterSlot"];
            $activeWarlockID = $userdata["warlockID"];
            $activeWarlockSlot = $userdata["warlockSlot"];
              
            //   if($username != $stored_username){
            //       $errors["username"] = "Username does not exist on Bungie servers.";
            //   }
            $password = $_POST["password"];
            if(password_verify($password, $stored_pw)){
                //get user data etc
                session_start();
                // $_SESSION['user'] = array('id' => '...', name => '...', ...);
                $_SESSION['user'] = array('uid' => $id, 'username' => $username, 'consoleID' => $console, 'membershipID' => $activeMembershipID, 'titanID' => $activeTitanID, 'titanSlot' =>$activeTitanSlot, 'titanEmblem', 'hunterID' => $activeHunterID, 'hunterSlot' => $activeHunterSlot, 'hunterEmblem', 'warlockID' => $activeWarlockID, 'warlockSlot' => $activeWarlockSlot, 'warlockEmblem');
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


