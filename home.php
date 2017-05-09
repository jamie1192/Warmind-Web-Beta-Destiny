<?php
//wheels00769: 4611686018428911554
//Jeewwbacca: 4611686018439307322
    
    session_start();
    
    // print_r ($_SESSION['user']["membershipID"]);
    // echo $_SESSION([1]);
    //check if user is logged in via session variable "account_id"
    // if(!$_SESSION["account_id"]){
    //     header("location:login.php");
    //     exit();
    // }
    // else{
    //     echo "Hello user, your account id is ".$_SESSION["account_id"];
    //     echo "To log out, go to <a href=\"logout.php\">Log Out</a> page";
    // }
    
    
     include("key.php");
     
     $jew = "jeewwbacca";
     $tim = "tanky_tim12";
     $wheels = "wheels00769";
     $cosmic = "cosmicrichy";
     $pip = "PippinMitch007";
     $ran="RannerzS12";
     $test = "a";
     $xboxName = "The1 and only35";
     $xboxName2 = "DrearFlounder88";
     
    $sessionUsername = $_SESSION['user']['username'];
    $sessionConsoleID = $_SESSION['user']['consoleID'];
    $sessionMembershipID = $_SESSION['user']['membershipID'];
     
    // echo "session output consoleID: ", $sessionConsoleID;
    // echo "session membershipID: ", $sessionMembershipID;
     
    $sessionTitanSlot = $_SESSION['user']['titanSlot'];
    $sessionHunterSlot = $_SESSION['user']['hunterSlot'];
    $sessionWarlockSlot = $_SESSION['user']['warlockSlot'];
     
    echo $_SESSION['user']['titanSlot']; 
    echo $_SESSION['user']['hunterSlot'];
    echo $_SESSION['user']['warlockSlot'];
     
    $titanEmblem = $_SESSION['user']['titanEmblem']; 
    $hunterEmblem = $_SESSION['user']['hunterEmblem'];
    $warlockEmblem = $_SESSION['user']['warlockEmblem'];
    
    // echo "Titan: ", $titanEmblem;
    // echo "<P>Hunter: ", $hunterEmblem;
    // echo "<p> Warlock: ", $warlockEmblem;
    
    $titanBackground = $_SESSION['user']['titanBackground'];
    $hunterBackground = $_SESSION['user']['hunterBackground'];
    $warlockBackground = $_SESSION['user']['warlockBackground'];
     
     $titan = 0;
     $hunter = 1;
     $warlock = 2;
     
     $selectedCharacter = 1;
     
     $psn = 2;
     $xbox = 1;
     
     if($selectedCharacter == 0)
     {
      $activeCharacter = "Titan";
     }
     elseif($selectedCharacter == 1)
     {
      $activeCharacter="Hunter";
     }
     elseif($selectedCharacter == 2){
        $activeCharacter = "Warlock";   
     }
     else{
         //throw error? iunno
     }
 
 
 
// $membershipID = 4611686018439307322;
 
//  curl_setopt($ch, CURLOPT_URL, 'https://www.bungie.net/platform/Destiny/Manifest/InventoryItem/1274330687/');

//get memberships (test)>
// /SearchDestinyPlayer/{membershipType}/{displayName}/

//1. get membershipID and search by given username
 $getMembershipId = curl_init();
 //curl_setopt($getMembershipId, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/2/Stats/GetMembershipIdByDisplayName/'.$wheels.'/');
 
 //case insensitive PSN name search- THIS SPITS OUT AN ARRAY
 curl_setopt($getMembershipId, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/SearchDestinyPlayer/'.$psn.'/'.$jew.'/');
//  curl_setopt($getMembershipId, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/2/Stats/GetMembershipIdByDisplayName/'.$cosmic.'/');
 curl_setopt($getMembershipId, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($getMembershipId, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $apiKey));
 $getMembershipResults = curl_exec($getMembershipId);
 $getMembershipResponse = json_decode($getMembershipResults);
 
 
 //
 $membershipID = $getMembershipResponse->Response[0]->membershipId;
 $displayName = $getMembershipResponse->Response[0]->displayName;;
//  echo "xbox wut: ", $getMembershipResults;
 
//  echo "First membership ID: ", $membershipID;
 
 //Aggregate Stats
 // /Stats/AggregateActivityStats/{membershipType}/{destinyMembershipId}/{characterId}/
 
 //2. get Account Summary- Jeewwbacca
 //IF statement to determined correct array slot for character choice
 
  //error(?) //TODO
  
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/'.$psn.'/Account/'.$membershipID.'/Summary/');
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $apiKey));
 $result = curl_exec($ch);
 $json = json_decode($result);
 //echo $result;
 // $membershipID = $json->Response;
 //$counter = 0;
//  echo $result;
 
 $slot0 = $json->Response->data->characters[0]->characterBase->classType; //wheels = 1, jew = 0
//  echo "<p>slot 0, json: ", $slot0;
 $slot1 = $json->Response->data->characters[1]->characterBase->classType; //wheels = 0, jew = 1
//  echo "<p>slot 1, json: ", $slot1;
 $slot2 = $json->Response->data->characters[2]->characterBase->classType; //wheels = 2, jew = 2
//  echo "<p>slot 2, json: ", $slot2;
 
 if($selectedCharacter == $slot0){
     $characterArraySlot = 0;
    //  echo "<p>IF slot 0";
 }
 elseif($selectedCharacter == $slot1){
     $characterArraySlot = 1;
    //  echo "<P>IF slot 1";
 }
 elseif($selectedCharacter == $slot2){
     $characterArraySlot = 2;
    //  echo "<P>IF slot 2";
 }
 else{
     //throw error or something //TODO
 }
//  echo "<p> Active Char: ", $activeCharacter;
//  echo "<p>Character array slot: ". $characterArraySlot;
 //$json->Response->data->characters[$selectedCharacter]->characterBase->classType
 $characterId = $json->Response->data->characters[$characterArraySlot]->characterBase->characterId;
 $lightLevel = $json->Response->data->characters[$characterArraySlot]->characterBase->powerLevel;
 $grimoire = $json->Response->data->characters[$characterArraySlot]->characterBase->grimoireScore;
 
//  echo "<p>User DisplayName: ", $displayName;
//  echo "<p>Membership ID: ", $membershipID;
//  echo "<P>Character ID: ", $characterId;
//  echo "<p>Character: ", $activeCharacter;
//  echo "<p>Light Level: ", $lightLevel;
//  echo "<p>Grimoire: ", $grimoire;
 $bungieURL = "https://bungie.net";
 
 
//  GET EMBLEMS FOR LOGGED IN USER
$getEmblems = curl_init();
 curl_setopt($getEmblems, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/'.$sessionConsoleID.'/Account/'.$sessionMembershipID.'/Summary/');
 curl_setopt($getEmblems, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($getEmblems, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $apiKey));
 $getEmblemsJSON = curl_exec($getEmblems);
 $getEmblemsResult = json_decode($getEmblemsJSON);

// END GET EMBLEMS
 
 
 
 // $urlMissing2 = "https://bungie.net";
 
 $emblemPath = $getEmblemsResult->Response->data->characters[$characterArraySlot]->emblemPath;
 
 //TODO fix the if(isset) so doesn't JSON request every page load 
 //GET ALL THE SESSION DATA
 //INSERT CHARACTER SELECTION ALGORITHM TO GET ALL 3 CHARACTER ID's
         $slot0 = $getEmblemsResult->Response->data->characters[0]->characterBase->classType; //wheels = 1, jew = 0
        //  echo "<p>slot 0, json: ", $slot0;
         $slot1 = $getEmblemsResult->Response->data->characters[1]->characterBase->classType; //wheels = 0, jew = 1
        //  echo "<p>slot 1, json: ", $slot1;
         $slot2 = $getEmblemsResult->Response->data->characters[2]->characterBase->classType; //wheels = 2, jew = 2
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
         
 
//  if(isset($_SESSION['user'])){
//      echo "just the tip ;)";
//      if (!isset($_SESSION["titanArray"])) {
    
        //  echo "<p>we got inside ;)";
        //Emblems
        // $titanEmblem = $getEmblemsResult->Response->data->characters[$_SESSION['user']['titanSlot']]->emblemPath;
        // $hunterEmblem = $getEmblemsResult->Response->data->characters[$_SESSION['user']['hunterSlot']]->emblemPath;
        // $warlockEmblem = $getEmblemsResult->Response->data->characters[$_SESSION['user']['warlockSlot']]->emblemPath;
        
        //commenting out here
        // $titanEmblem = $getEmblemsResult->Response->data->characters[$titanSlot]->emblemPath;
        // $hunterEmblem = $getEmblemsResult->Response->data->characters[$hunterSlot]->emblemPath;
        // $warlockEmblem = $getEmblemsResult->Response->data->characters[$warlockSlot]->emblemPath;
        
        
        // $titanBackground = $getEmblemsResult->Response->data->characters[$titanSlot]->backgroundPath;
        // $hunterBackground = $getEmblemsResult->Response->data->characters[$hunterSlot]->backgroundPath;
        // $warlockBackground = $getEmblemsResult->Response->data->characters[$warlockSlot]->backgroundPath;
        
        // $_SESSION["titanEmblemIconPath"]= $titanEmblem;
        // $_SESSION["hunterEmblemIconPath"] = $hunterEmblem;
        // $_SESSION["warlockEmblemIconPath"] = $warlockEmblem;
        
        // echo "slot test :",$_SESSION['user']['titanSlot'];
        
        // $_SESSION["titanEmblemBackground"] = $titanEmblemBackground;
        // $_SESSION["hunterEmblemBackground"] = $hunterEmblemBackground;
        // $_SESSION["warlockEmblemBackground"] = $warlockEmblemBackground;
        
        // //Light Level
        // $lightLevel = $json->Response->data->characters[$characterArraySlot]->characterBase->powerLevel;
        // $titanLightLevel = $getEmblemsResult->Response->data->characters[$_SESSION['user']['titanSlot']]->characterBase->powerLevel;
        // $hunterLightLevel = $getEmblemsResult->Response->data->characters[$_SESSION['user']['hunterSlot']]->characterBase->powerLevel;
        // $warlockLightLevel = $getEmblemsResult->Response->data->characters[$_SESSION['user']['warlockSlot']]->characterBase->powerLevel;
        // $grimoire = $getEmblemsResult->Response->data->characters[$_SESSION['user']['titanSlot']]->characterBase->grimoireScore;
        
        // $_SESSION["titanLightLevel"] = $titanLightLevel;
        // $_SESSION["hunterLightLevel"] = $hunterLightLevel;
        // $_SESSION["warlockLightLevel"] = $warlockLightLevel;
        // $_SESSION["grimoire"] = $grimoire;
        
        
        //to here
//      }
//  }
 
    // array_push($_SESSION['titanEmblem'], $titanEmblem);
    // array_push($_SESSION['hunterEmblem'],$hunterEmblem);
    // array_push($_SESSION['warlockEmblem'], $warlockEmblem);
//  array_push($_SESSION['titanEmblem'],$titanEmblem);
//  array_push($_SESSION['hunterEmblem'],$hunterEmblem);
//  array_push($_SESSION['warlockEmblem'],$warlockEmblem);
 
 $emblemBackgroundPath = $json->Response->data->characters[$characterArraySlot]->backgroundPath;
 
 // echo "<p>emblem: ", $emblemPath;
 // echo "<p>background: ", $emblemBackgroundPath;
 
 $completeEmblemIcon = "$bungieURL$emblemPath";
 $completeEmblemBackground = "$bungieURL$emblemBackgroundPath";
 
 // echo "<p>emblem: ", $completeEmblemIcon;
 // echo "<p>background: ", $completeEmblemBackground;
 
 // $grimoire = $json->Response->data->characters[$hunter]->characterBase->grimoireScore;
 
 // echo "Hunter Emblem Icon Link: ", $completeEmblemIcon;
 // echo "<p> Emblem Background Path: ", $completeEmblemBackground;
 // echo "<p> Hunter Grimoire is: ", $grimoire;
 
 
 //TODO GET RID OF THIS (BELOW) LATER 
 
 
 //TESTING BELOW- Trials stats
 $accountSummary = curl_init();
 // curl_setopt($accountSummary, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/2/Account/'.$membershipID.'/Summary/');
 // curl_setopt($accountSummary, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/Stats/ActivityHistory/2/'.$membershipID.'/'.$characterId.'/?mode=TrialsOfOsiris');
 // curl_setopt($accountSummary, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/Stats/AggregateActivityStats/2/'.$membershipID.'/'.$characterId.'/?defintions=true');
 // curl_setopt($accountSummary, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/Stats/Definition/');
 // curl_setopt($accountSummary, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/2/Account/'.$membershipID.'/Triumphs/');
 
 //ALL TIME STATS HERE
 curl_setopt($accountSummary, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/Stats/2/'.$membershipID.'/'.$characterId.'/?modes=TrialsOfOsiris');






 // curl_setopt($accountSummary, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/Stats/AggregateActivityStats/2/'.$membershipID.'/'.$characterId.'/');
 // www.bungie.net/Platform/Destiny/Stats/ActivityHistory/{membershipType}/{destinyMembershipId}/{characterId}/
 curl_setopt($accountSummary, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($accountSummary, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $apiKey));
 $getAccountSummary = curl_exec($accountSummary);
 $json2 = json_decode($getAccountSummary);
 
 //Get Warlock Light Level 
 //echo "<p>Light Level: ", $json2->Response->data->characters[$hunter]->characterBase->powerLevel;//->characterBase->minutesPlayedTotal;
 
 
 $trialsKDRatio = $json2->Response->trialsOfOsiris->allTime->killsDeathsRatio->basic->displayValue;
 $trialsTotalKills = $json2->Response->trialsOfOsiris->allTime->kills->basic->displayValue;
 $trialsAverageKillsPerGame = $json2->Response->trialsOfOsiris->allTime->kills->pga->displayValue;
 $trialsTotalDeaths = $json2->Response->trialsOfOsiris->allTime->deaths->basic->displayValue;
 $trialsAverageDeathsPerGame = $json2->Response->trialsOfOsiris->allTime->deaths->pga->displayValue;
 $trialsAverageLifespan = $json2->Response->trialsOfOsiris->allTime->averageLifespan->basic->displayValue;
 $trialsWinLossRatio = $json2->Response->trialsOfOsiris->allTime->winLossRatio->basic->displayValue;
 $trialsLongestKillSpree = $json2->Response->trialsOfOsiris->allTime->longestKillSpree->basic->displayValue;
 
 
 
 // echo "<p>Trials test: ", $getAccountSummary;
//  echo "<p>Trials Stats: <p>", $trialsTotalKills, " kills, Average per game: ", $trialsAverageKillsPerGame;
//  echo "<p>";
//  echo $trialsTotalDeaths, " deaths, Average per game: ", $trialsAverageDeathsPerGame;
//  echo "<p>Average K/D: ", $trialsKDRatio;
 
 
 //Aggregate Stats
 //Stats/AggregateActivityStats/{membershipType}/{destinyMembershipId}/{characterId}/
 // www.bungie.net/Platform/Destiny/Stats/AggregateActivityStats/{membershipType}/{destinyMembershipId}/{characterId}/
 
 // http://www.bungie.net/Platform/Destiny/Stats/Account/{membershipType}/{destinyMembershipId}/   ??
 
 // $getActivityStats = curl_init();
 // //IF (to decide which character we get stats for and pass into URL?)
 // curl_setopt($getActivityStats, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/Stats/Account/2/'.$membershipId.'/');
 // curl_setopt($getActivityStats, CURLOPT_RETURNTRANSFER, true);
 // curl_setopt($getActivityStats, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $apiKey));
 // $activityResults = curl_exec($getActivityStats);
 // $jsonActivityResults = json_decode($activityResults);
 
 // echo "<p>Activity Results: ", $jsonActivityResults;
 //print whole array
 //print_r($json);
 
 
 //prints whole json also


 //TODO condense these two into one variable
 
 $urlMissing2 = "https://bungie.net";
 

?>

<!DOCTYPE html>
<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">
    
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <script src="node_modules/jquery/dist/jquery.js" type="text/javascript"></script>
    <!--<link rel="stylesheet" href="/node_modules/material-design-lite/material.min.css">-->
    <!--<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.red-yellow.min.css" />-->
    <script src="/node_modules/material-design-lite/material.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="node_modules/dialog-polyfill/dialog-polyfill.js"></script>
    <link rel="stylesheet" type="text/css" href="node_modules/dialog-polyfill/dialog-polyfill.css" />
    
    <link rel="stylesheet" href="/customMDLstyling.css">
    <link rel="stylesheet" href="/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

 <html>
     <!--PASTE STARTS HERE-->
      <body>
          
          <dialog class="mdl-dialog loginDialog">
                        <h1 class="mdl-dialog__title mdl-color-text--primary">Existing User Login</h1>
                        <!--                                <div class="mdl-dialog__content">-->

                        <!--                                Floating labels-->
                        <form action="#" id="login-form" method="post" action="layout sandbox2.1.php">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-group">
                                <?php 
                            if($errors["username"]){
                                $username_error = $errors["username"];
                                $username_error_class = "has-error";
                            }
                        ?>
                                <input class="mdl-textfield__input form-control" type="text" id="username">
                                <label class="mdl-textfield__label" for="username">Username</label>
                            </div>
                            
                            <!--password field-->
                            <?php 
                            if($errors["password"]){
                                $pw_error = $errors["password"];
                                $pw_error_class = "has-error";
                            }
                        ?>
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-group">
                                <input class="mdl-textfield__input form-control" type="password" id="password">
                                <label class="mdl-textfield__label" for="password">Password</label>

                            </div>
                            <span class="mdl-textfield__error">Incorrect email or password!</span>

                            <!--                                    Cancel Button-->
                            <div class="mdl-dialog__actions mdl-dialog__actions--full-width">
                                <button class="mdl-button close mdl-js-button mdl-js-ripple-effect mdl-dialog__actions--full-width">
  Cancel
</button>

                                <!--                                    Login Button-->
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary mdl-dialog__actions--full-width" type="submit" name="submit">
  Login
</button>
                            </div>
                        </form>
                        <!--                                </div>-->
                    </dialog>
          
    <!-- Layout Container with Fixed Header and Tabs -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header mdl-layout--fixed-tabs mdl-layout--fixed-drawer">
        <header class="mdl-layout__header darkColour">
            <div class="mdl-layout__header-row">
                <!-- Header Title -->
                <span class="mdl-layout-title">Warmind for Destiny</span>
                <!-- Add spacer, to align navigation to the right -->
                <div class="mdl-layout-spacer"></div>
                <!-- Header Buttons -->
                <nav class="mdl-navigation">
                    <!--<button id="login-dialog" type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Submit</button>-->
                    <a class="mdl-button close mdl-js-button mdl-js-ripple-effect mdl-button--accent " href="submitDialog.php">Submit</a>
                    <!--                            Start of MDL dialog new Login-->
<!--                    <dialog class="mdl-dialog loginDialog">-->
<!--                        <h1 class="mdl-dialog__title mdl-color-text--primary">Existing User Login</h1>-->
                        <!--                                <div class="mdl-dialog__content">-->

                        <!--                                Floating labels-->
<!--                        <form action="#">-->
<!--                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">-->
<!--                                <input class="mdl-textfield__input" type="text" id="username">-->
<!--                                <label class="mdl-textfield__label" for="username">Username</label>-->
<!--                            </div>-->
<!--                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">-->
<!--                                <input class="mdl-textfield__input" type="password" id="password">-->
<!--                                <label class="mdl-textfield__label" for="password">Password</label>-->

<!--                            </div>-->
<!--                            <span class="mdl-textfield__error">Incorrect email or password!</span>-->

                            <!--                                    Cancel Button-->
<!--                            <div class="mdl-dialog__actions mdl-dialog__actions--full-width">-->
<!--                                <button class="mdl-button close mdl-js-button mdl-js-ripple-effect mdl-dialog__actions--full-width">-->
<!--  Cancel-->
<!--</button>-->

                                <!--                                    Login Button-->
<!--                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary mdl-dialog__actions--full-width">-->
<!--  Login-->
<!--</button>-->
<!--                            </div>-->
<!--                        </form>-->
                        <!--                                </div>-->
<!--                    </dialog>-->
                    <!--<script>-->
                    <!--    var dialog = document.querySelector('dialog');-->
                    <!--    var showDialogButton = document.querySelector('#login-dialog');-->


                    <!--    if (!dialog.showModal) {-->
                    <!--        dialogPolyfill.registerDialog(dialog);-->
                    <!--    }-->
                    <!--    showDialogButton.addEventListener('click', function() {-->
                    <!--        dialog.showModal();-->
                    <!--    });-->
                    <!--    dialog.querySelector('.close').addEventListener('click', function() {-->
                    <!--        dialog.close();-->
                    <!--    });-->
                    <!--</script>-->
                    <!--                            End of dialog-->

                    <!--                            jQuery for button-->


                    <!--                            end jQuery -->



                </nav>
            </div>

            <!-- Tab Container with Tab links -->
            <div class="mdl-layout__tab-bar mdl-js-ripple-effect darkColour">
                <!-- class is-active to show currently active tab -->
                <a href="#fixed-tab-1" class="mdl-layout__tab is-active">Trials of Osiris</a>
                <a href="#fixed-tab-2" class="mdl-layout__tab">Raids</a>
                <a href="#fixed-tab-3" class="mdl-layout__tab">Iron Banner</a>
            </div>
        </header>

        <!--            Proper MDL sidebar-->

        <div class="mdl-layout__drawer drawerStyling">
            
            
<!--            User account header-->
            <header class="demo-drawer-header">
                <?php 
                    if(isset($_SESSION['user'])){
                        
                        echo "<div class=\"iconTestBox\">";
                        echo "<img src=\"$bungieURL$titanEmblem\" class=\"demo-avatar titanEmblemIcon\">";
                        echo "<img src=\"$bungieURL$hunterEmblem\" class=\"demo-avatar\">";
                        echo "<img src=\"$bungieURL$warlockEmblem\" class=\"demo-avatar warlockEmblemIcon\">";
                        echo "</div>";
                        echo "<span class=\"headerLoggedUser\">$sessionUsername</span>";
                    }
                    else{
                        echo "<i class=\"material-icons\" role=\"presentation\">account_circle</i>Not Logged In</a>";    
                    }
                ?>
                    <!--<span>?= $_SESSION['user']['username'] ;?></span>-->
                    <!--<span>?= $_SESSION['user']['titanSlot'] ;?></span>-->
                    <!--<span>?= $_SESSION['user']['consoleID'] ;?></span>-->
                    <!--<span>?= $_SESSION['user']['membershipID'] ;?></span>-->
                    <div class="demo-avatar-dropdown">
                        
                        <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="accbtn">
                            <li class="mdl-menu__item">Titan</li>
                            <li class="mdl-menu__item">Hunter</li>
                            <li class="mdl-menu__item">Warlock</li>
                            <!--<li class="mdl-menu__item"><i class="material-icons">add</i>Add another account...</li>-->
                        </ul>
                    </div>
            </header>  
        <nav class="demo-navigation mdl-navigation navStyling">
            <a class="mdl-navigation__link mdl-color-text--white" href="#">
                <i class="material-icons mdl-color-text--white" role="presentation">person_add</i>LFG Feed</a>
            <?php 
            if(isset($_SESSION['user'])){
                echo "<a class=\"mdl-navigation__link mdl-color-text--white\" href=\"#\">";
                    echo "<i class=\"material-icons mdl-color-text--white\" role=\"presentation\">chat </i>My Posts</a>";
                echo "<a class=\"mdl-navigation__link mdl-color-text--white\" href=\"#\">";
                    echo "<i class=\"material-icons mdl-color-text--white\" role=\"presentation\">assessment </i>My Stats</a>";
            }?>
            <div class="mdl-layout-spacer"></div>
            <?php 
            if(isset($_SESSION['user'])){
                echo "<a class=\"mdl-navigation__link mdl-color-text--white\" href=\"logout.php\">";
                echo "<i class=\"material-icons mdl-color-text--white\" role=\"presentation\">power_settings_new</i>Log Out</a>";
            }else{
                echo "<a class=\"mdl-navigation__link mdl-color-text--white\" href=\"login.php\">";
                echo "<i class=\"material-icons mdl-color-text--white\" role=\"presentation\">account_circle</i>Log In</a>";
            }?>
        </nav>
<!--            End sidebar-->
            
            
        </div>
        <main class="mdl-layout__content">

            <section class="mdl-layout__tab-panel is-active" id="fixed-tab-1">
                <div class="page-content">
                    <div class="tab1container"><!--Tab 1-->

<!--LFG POST STARTS HERE-->
          
<!--LFG POST STARTS HERE-->
<!--<div class="mdl-grid">-->
  <!--<div class="mdl-cell mdl-cell--1-col">1</div>-->
  <!--<div class="mdl-cell mdl-cell--6-col">6</div>-->
    <div class="postContainer">
        <div class="postCard mdl-card mdl-card--primary mdl-shadow--2dp">
            <div class="emblemContainer">
                <div class="emblemIcon">
                    <img src="<?= $completeEmblemIcon; ?>"></img>
                </div>
                <div class="emblemBackground">
                    <img src="<?= $completeEmblemBackground; ?>"></img>
                </div>
                <div class="playerUsername"><?= $displayName; ?></div>
                <div class="playerCurrentClass"><?= $activeCharacter; ?></div>
                <div class="rightSide">
                    <div class="playerLightLevel"><span id="lightLevelIcon">&#10022  </span><?= $lightLevel; ?></div>
                    <div class="playerGrimoire"><?= $grimoire; ?>
                        <img id="grimoireIcon" src="./assets/grimoireIcon.png"></img>
                    </div>
                </div>
            </div>
            <div class="mdl-spinner mdl-js-spinner is-active getStatsLoading" id="statsLoading"></div>
                <!--<div class="innerContainer">-->
            <div class="postActivity"><span class="postActivityText">Trials of Osiris</span>
                <div class="divider"></div>
            </div>
           
            <div class="postDescription"><span class="postDescriptionText">LF 1 more, must have K/D above 1.5, have mic and be over the age of 18.</span></div>
                    <!--<form id="playerStatsForm"> -->
                        <!--<input type="hidden" name="getStatsButton" value=" //$displayName; ?>">-->
                            <button id="getStats" data-name="<?=$displayName;?>" data-character="<?=$activeCharacter;?>" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent ">Get Player Stats</button>
                        <!--</input>-->
                    <!--</form>-->
                <!--</div>    -->
        </div>
        
        
        <div class="stats-row whiteText"></div>
        <template id="playerStats">
                <table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp trialsStatsRow postColour">
                <thead>
                    <tr class="goldColour">
                        <th>K/D Ratio</th>
                        <th>Average Lifespan</th>
                        <th>Win/Loss Ratio</th>
                    </tr>
                </thead>
                    <tbody>
                         <!--Row 1 -->
                        <tr>
                            <td class="playerKD"></td>
                            <td class="playerAverageLifespan"></td>
                            <td class="playerWinLossRatio"></td>
                        </tr>
                    </tbody>
                </table>
            </template>
            
    </div>
    <!--<div class="mdl-cell mdl-cell--6-col">6</div>-->
    
<!--FIRST LFG POST ENDS HERE-->
    
   
<!--SECOND LFG POST ENDS HERE-->

  <!--TrialsReport star icon : ✦ -->
  
  </div>
                </div>
            </section>

            <section class="mdl-layout__tab-panel" id="fixed-tab-2">
                <div class="page-content">
                    <div class="tab2container">Tab 2

                    </div>
                </div>
            </section>

            <section class="mdl-layout__tab-panel" id="fixed-tab-3">
                <div class="page-content">
                    <div class="tab3container">Tab 3</div>
                </div>
            </section>
        </main>
    </div>
  
  <script>
    
    //Login dialog
    var dialog = document.querySelector('dialog');
    var showDialogButton = document.querySelector('#login-dialog');


    if (!dialog.showModal) {
        dialogPolyfill.registerDialog(dialog);
    }
    showDialogButton.addEventListener('click', function() {
        dialog.showModal();
    });
    dialog.querySelector('.close').addEventListener('click', function() {
        dialog.close();
    });
    
    //end login dialog
    
    
    $(".postContainer").on("click", clickHandler);
    
    function clickHandler(e){
        e.target;
        var getName = $(e.target).parents(".mdl-button").data("name");
        var getCharacter = $(e.target).parents(".mdl-button").data("character");
        var datasource = "ajax/getPlayerStats.php";
        
        if(getName != null){
            $('#statsLoading').show();
        }
        
        console.log("e target: ", e.target);
        console.log("playerName: ", getName);
        console.log("Character: ", getCharacter);    
        
        //TODO get console from post and pass to php
        var obj = {name: getName, character:getCharacter};
        
        //TODO how to get more than one value from LFG post (need character)
            //   var playerName = {name:$("#playerStatsForm input").val(), characterName:$};
              
              
              $.ajax({
                  data:obj, 
                  datatype: 'json',
                  url:datasource,
                  type: 'POST',
                  encode: true
              })
              .done(function(data){
                  console.log(data);
                //if there is data
                //TODO removeChild after clicking hide stats
                
                $('#statsLoading').hide();
                
                var jsonResponse = JSON.parse(data);
                // console.log(test.Response.trialsOfOsiris.allTime.killsDeathsRatio.basic.displayValue);
                if(typeof jsonResponse.Response.trialsOfOsiris.allTime === "undefined"){
                    console.log("ERROR");
                    $("#getStats").html('Error: No stats found');
                    $("#getStats").removeClass("mdl-button--accent");
                    $("#getStats").addClass("getTrialsStatsError");
                    
                }
                else if(typeof jsonResponse.Response.trialsOfOsiris.allTime.killsDeathsRatio === "undefined"){
                    console.log("ERROR");
                }
                //ELSEIF if response != 1, throw error if trial stats not found-->
                else if(typeof jsonResponse.Response.trialsOfOsiris.allTime.averageLifespan === "undefined"){
                    console.log("ERROR");
                }
                else if(typeof jsonResponse.Response.trialsOfOsiris.allTime.winLossRatio === "undefined"){
                    console.log("ERROR");
                }
                else{
                    $("#getStats").html('Hide Stats');
                    
                    var template = $("#playerStats").html().trim();
                    var clone = $(template);
                    //fill the data
                    //console.log(data.Response.trialsOfOsiris.allTime.killsDeathsRatio.basic.displayValue);
                    var playerKD = jsonResponse.Response.trialsOfOsiris.allTime.killsDeathsRatio.basic.displayValue;
                    var averageLifespan = jsonResponse.Response.trialsOfOsiris.allTime.averageLifespan.basic.displayValue;
                    var winLossRatio = jsonResponse.Response.trialsOfOsiris.allTime.winLossRatio.basic.displayValue;
                    console.log("playerKD: ", playerKD);
                    console.log("Avg Lifespan: ", averageLifespan);
                    console.log("Respone code: ", jsonResponse.Response);
                    
                    $(clone).find(".playerKD").html(playerKD);
                    $(clone).find(".playerAverageLifespan").html(averageLifespan);
                    $(clone).find(".playerWinLossRatio").html(winLossRatio);
                    $(".stats-row").append(clone);
                }
                
              })
            //   timeout: 3000;
    }
  
  
    //   $(document).ready(function(){
    //       //add listener for button click
    //       $("#playerStatsForm").on("submit", function(e){
    //           e.preventDefault();
    //           $('#statsLoading').show();
              
    //           //TODO how to get more than one value from LFG post (need character)
    //           var playerName = {name:$("#playerStatsForm input").val(), characterName:$};
    //           var datasource = "ajax/getPlayerStats.php";
    //           $.ajax({
    //               data:playerName, 
    //               datatype: 'json',
    //               url:datasource,
    //               type: 'POST',
    //               encode: true
    //           })
    //           .done(function(data){
    //               console.log(data);
    //             //if there is data
    //             $('#statsLoading').hide();
                
    //             var jsonResponse = JSON.parse(data);
    //             // console.log(test.Response.trialsOfOsiris.allTime.killsDeathsRatio.basic.displayValue);
    //             if(typeof jsonResponse.Response.trialsOfOsiris.allTime === "undefined"){
    //                 console.log("ERROR");
    //                 $("#getStats").html('Error: No stats found');
    //                 $("#getStats").removeClass("mdl-button--accent");
    //                 $("#getStats").addClass("getTrialsStatsError");
                    
    //             }
    //             else if(typeof jsonResponse.Response.trialsOfOsiris.allTime.killsDeathsRatio === "undefined"){
    //                 console.log("ERROR");
    //             }
    //             //ELSEIF if response != 1, throw error if trial stats not found
    //             else if(typeof jsonResponse.Response.trialsOfOsiris.allTime.averageLifespan === "undefined"){
    //                 console.log("ERROR");
    //             }
    //             else if(typeof jsonResponse.Response.trialsOfOsiris.allTime.winLossRatio === "undefined"){
    //                 console.log("ERROR");
    //             }
    //             else{
    //                 var template = $("#playerStats").html().trim();
    //                 var clone = $(template);
    //                 //fill the data
    //                 //console.log(data.Response.trialsOfOsiris.allTime.killsDeathsRatio.basic.displayValue);
    //                 var playerKD = jsonResponse.Response.trialsOfOsiris.allTime.killsDeathsRatio.basic.displayValue;
    //                 var averageLifespan = jsonResponse.Response.trialsOfOsiris.allTime.averageLifespan.basic.displayValue;
    //                 var winLossRatio = jsonResponse.Response.trialsOfOsiris.allTime.winLossRatio.basic.displayValue;
    //                 console.log("playerKD: ", playerKD);
    //                 console.log("Avg Lifespan: ", averageLifespan);
    //                 console.log("Respone code: ", jsonResponse.Response);
                    
    //                 $(clone).find(".playerKD").html(playerKD);
    //                 $(clone).find(".playerAverageLifespan").html(averageLifespan);
    //                 $(clone).find(".playerWinLossRatio").html(winLossRatio);
    //                 $(".stats-row").append(clone);
    //             }
                
    //           })
              
              
    //       })
    //   })
      
  </script>
  
  
  
<!--ENDS HERE-->


    
 </body>
 
</html>