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
    
    include("head.php");
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
     
    //  echo "Session name: ",$sessionUsername;
     
    //  echo "session output consoleID: ", $sessionConsoleID;
    //  echo "session membershipID: ", $sessionMembershipID;
     
     $sessionTitanSlot = $_SESSION['user']['titanSlot'];
     $sessionHunterSlot = $_SESSION['user']['hunterSlot'];
     $sessionWarlockSlot = $_SESSION['user']['warlockSlot'];
     
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
 curl_setopt($getMembershipId, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/SearchDestinyPlayer/'.$psn.'/'.$tim.'/');
//  curl_setopt($getMembershipId, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/2/Stats/GetMembershipIdByDisplayName/'.$cosmic.'/');
 curl_setopt($getMembershipId, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($getMembershipId, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $apiKey));
 $getMembershipResults = curl_exec($getMembershipId);
 $getMembershipResponse = json_decode($getMembershipResults);
 
 
 //
 $membershipID = $getMembershipResponse->Response[0]->membershipId;
 $displayName = $getMembershipResponse->Response[0]->displayName;
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
 
 $emblemPath = $json->Response->data->characters[$characterArraySlot]->emblemPath;
 
 //TODO fix the if(isset) so doesn't JSON request every page load 
 
//  if(isset($_SESSION['user'])){
//      echo "just the tip ;)";
//      if (!isset($_SESSION["titanArray"])) {
    
        //  echo "<p>we got inside ;)";
        $titanEmblem = $_SESSION['user']['titanEmblem'];
        $hunterEmblem = $_SESSION['user']['hunterEmblem'];
        $warlockEmblem = $_SESSION['user']['warlockEmblem'];
        
        // $_SESSION["titanArray"]= $titanEmblem;
        // $_SESSION["hunterArray"] = $hunterEmblem;
        // $_SESSION["warlockArray"] = $warlockEmblem;
        
        // echo "titan emblem: ", $titanEmblem;
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
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <link rel="stylesheet" href="/customMDLstyling.css">
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="/iconSelectRadio.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

 <html>
     <!--PASTE STARTS HERE-->
      <body>
          
           <dialog class="mdl-dialog postDialog">
                <!--<h4 class="mdl-dialog__title">Submit LFG Post</h4>-->
                <div class="mdl-dialog__title mdl-color--homeBackground" 
                style="padding: 24px 24px 24px;
                        font-size: 2.5rem;
                        color: white;">Submit LFG Post</div>
                    <div class="mdl-dialog__content">
                       
                        <form id="submitPostForm" method="post" action="#">
                            <div class="class-selector lfgEmblemContainer">
                                
                                <input id="titan" type="radio" name="characterClass" value="Titan" checked/>
                                <label class="classEmblems" for="titan">
                                    <img class="emblemIcons" src=<?php echo htmlspecialchars("$bungieURL$titanEmblem");?>>
                                </label>
                                
                                <input id="hunter" type="radio" name="characterClass" value="Hunter" />
                                <label class="classEmblems"for="hunter">
                                    <img class="emblemIcons" src=<?php echo htmlspecialchars("$bungieURL$hunterEmblem");?>>
                                </label>
                                
                                <input id="warlock" type="radio" name="characterClass" value="Warlock" />
                                <label class="classEmblems"for="warlock">
                                    <img class="emblemIcons" src=<?php echo htmlspecialchars("$bungieURL$warlockEmblem");?>>
                                </label>
                                
                            </div>
                            
                            <div class="class-selector emblemLabels">
                                <!--<div>-->
                                <label id="titanLabel" class="classEmblems" for="titan">Titan</label>
                                <!--</div>-->
                                <!--<div>-->
                                <label id="hunterLabel" class="classEmblems" for="hunter">Hunter</label>
                                <!--</div>-->
                                <!--<div>-->
                                <label id="warlockLabel" class="classEmblems" for="warlock">Warlock</label>
                                <!--</div>-->
                            </div>

                            <div class="mdl-select mdl-js-select mdl-select--floating-label">
                                <select class="mdl-select__input" id="activitySelection" name="activitySelection">
                                    <option value=""></option>
                                        <optgroup label="Raid - Wrath of the Machine">
                                            <option value="Wrath of the Machine - Heroic (Fresh)">Heroic (Fresh)</option>
                                            <option value="Wrath of the Machine - Heroic (Vosik)">Heroic (Vosik)</option>
                                            <option value="Wrath of the Machine - Heroic (Siege Engine)">Heroic (Siege Engine)</option>
                                            <option value="Wrath of the Machine - Heroic (Aksis Ph 2)">Heroic (Aksis Ph 2)</option>
                                            <option value="Wrath of the Machine - Heroic (Aksis Ph 1)">Heroic (Aksis Ph 1)</option>
                                        <option value="%">---</option>
                                            <option value="Wrath of the Machine - Normal (Fresh)">Normal (Fresh)</option>
                                            <option value="Wrath of the Machine - Normal (Vosik)">Normal (Vosik)</option>
                                            <option value="Wrath of the Machine - Normal (Siege Engine)">Normal (Siege Engine)</option>
                                            <option value="Wrath of the Machine - Normal (Aksis Ph 2)">Normal (Aksis Ph 2)</option>
                                            <option value="Wrath of the Machine - Normal (Aksis Ph 1)">Normal (Aksis Ph 1)</option>
                                            <optgroup label="Raid - King's Fall">
                                                <option value="King's Fall - Heroic (Fresh)">Heroic (Fresh)</option>
                                                <option value="King's Fall - Heroic (Oryx)">Heroic (Oryx)</option>
                                                <option value="King's Fall - Heroic (Daughters)">Heroic (Daughters)</option>
                                                <option value="King's Fall - Heroic (Golgoroth)">Heroic (Golgoroth)</option>
                                                <option value="King's Fall - Heroic (Warpriest)">Heroic (Warpriest)</option>
                                                <option value="King's Fall - Heroic (Totems)">Heroic (Totems)</option>
                                            <option value="%">---</option>
                                                <option value="King's Fall - Normal (Fresh)">Normal (Fresh)</option>
                                                <option value="King's Fall - Normal (Oryx)">Normal (Oryx)</option>
                                                <option value="King's Fall - Normal (Daughters)">Normal (Daughters)</option>
                                                <option value="King's Fall - Normal (Golgoroth)">Normal (Golgoroth)</option>
                                                <option value="King's Fall - Normal (Warpriest)">Normal (Warpriest)</option>
                                                <option value="King's Fall - Normal (Totems)">Normal (Totems)</option>
                                            </optgroup>
                                            <optgroup label="Raid - Crota's End">
                                                <option value="Crota's End - Heroic (Fresh)">Heroic (Fresh)</option>
                                                <option value="Crota's End - Heroic (Crota)">Heroic (Crota)</option>
                                                <option value="Crota's End - Heroic (Deathsinger)">Heroic (Deathsinger)</option>
                                                <option value="Crota's End - Heroic (Thrallway)">Heroic (Thrallway)</option>
                                                <option value="Crota's End - Heroic (Bridge)">Heroic (Bridge)</option>
                                                <option value="%">---</option>
                                                <option value="Crota's End - Normal (Fresh)">Normal (Fresh)</option>
                                                <option value="Crota's End - Normal (Crota)">Normal (Crota)</option>
                                                <option value="Crota's End - Normal (Deathsinger)">Normal (Deathsinger)</option>
                                                <option value="Crota's End - Normal (Thrallway)">Normal (Thrallway)</option>
                                                <option value="Crota's End - Normal (Bridge)">Normal (Bridge)</option>
                                            </optgroup>
                                            <optgroup label="Raid - Vault of Glass">
                                                <option value="Vault of Glass - Heroic (Fresh)">Heroic (Fresh)</option>
                                                <option value="Vault of Glass - Heroic (Atheon)">Heroic (Atheon)</option>
                                                <option value="Vault of Glass - Heroic (Gatekeepers)">Heroic (Gatekeepers)</option>
                                                <option value="Vault of Glass - Heroic (Gorgons)">Heroic (Gorgons)</option>
                                                <option value="Vault of Glass - Heroic (Templar)">Heroic (Templar)</option>
                                                <option value="Vault of Glass - Heroic (Oracles)">Heroic (Oracles)</option>
                                                <option value="Vault of Glass - Heroic (Confluxes)">Heroic (Confluxes)</option>
                                                <option value="%">---</option>
                                                <option value="Vault of Glass - Normal (Fresh)">Normal (Fresh)</option>
                                                <option value="Vault of Glass - Normal (Atheon)">Normal (Atheon)</option>
                                                <option value="Vault of Glass - Normal (Gatekeepers)">Normal (Gatekeepers)</option>
                                                <option value="Vault of Glass - Normal (Gorgons)">Normal (Gorgons)</option>
                                                <option value="Vault of Glass - Normal (Templar)">Normal (Templar)</option>
                                                <option value="Vault of Glass - Normal (Oracles)">Normal (Oracles)</option>
                                                <option value="Vault of Glass - Normal (Confluxes)">Normal (Confluxes)</option>
                                                </optgroup>
                                            <optgroup label="Raid - Misc">
                                                <option value="Raid - Checkpoint Share">Checkpoint Share</option>
                                                <option value="Raid - Exploration">Exploration</option>
                                            </optgroup>
                                        </optgroup>
                                </select>
                                <label class="mdl-select__label" for="activitySelection">Select an Activity</label>
                            </div>
                        <!--</form>-->
    
        
                            <div class="mdl-textfield mdl-textfield-custom mdl-js-textfield">
                                <textarea class="mdl-textfield__input" type="text" rows= "5" id="description" name="description" ></textarea>
                                <label class="mdl-textfield__label" for="description">Description</label>
                            </div>
                        <!--</form>-->
                    </div>
                <div class="mdl-dialog__actions">
                        <button type="submit" id="submitLFGpost" name="submit" class="mdl-button">Submit</button>
                    <div class="mdl-spinner mdl-js-spinner is-active submitPostSpinner" id="submitPostLoading"></div>
                    <button type="button" name="cancel" id="cancelLFGpost" class="mdl-button close">Cancel</button>
                </div>
            </form>
            </dialog>
            <div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
                <div class="mdl-snackbar__text"></div>
                <button class="mdl-snackbar__action" type="button"></button>
            </div>
    
          
          
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
                      <?php if(isset($_SESSION['user'])){
                          echo "<button id=\"submit-dialog\" type=\"button\" class=\"mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent\">Submit</button>";
                      }?> 
                    <!--<button id="submit-dialog" type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Submit</button>-->
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
                    <div class="tab1container "><!--Tab 1-->
                        <!--<div class="mdl-grid">-->
                           <template id="playerPosts">
                                <div class="posts mdl-cell mdl-cell--1-offset-phone mdl-cell--6-col mdl-cell--2-offset-tablet">
                                <!--<div class="posts mdl-cell mdl-cell--6--phone mdl-cell--6-col-tablet mdl-cell--4-desktop">-->
                                    <div class="postCard mdl-card mdl-card--primary mdl-shadow--2dp">
                                        <div class="emblemContainer">
                                            <div class="emblemIcon">
                                                <img class="emblemIconImg">
                                            </div>
                                            <div class="emblemBackground">
                                                <img class="emblemBackgroundImg" src="">
                                            </div>
                                            <div class="playerUsername">
                                                <span class="playerUsernameOutput"></span>
                                                <img class="consoleIcon">
                                            </div>
                                            <div class="playerCurrentClass"></div>
                                            <div class="rightSide">
                                                <div class="playerLightLevel"></div>
                                                <div class="playerGrimoire"><span class="playerGrimoireOutput"></span>
                                                    <img class="grimoireImage">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mdl-spinner mdl-js-spinner is-active getStatsLoading statsLoading"></div>
                                        <div class="postActivity"><span class="postActivityText"></span>
                                            <div class="divider"></div>
                                        </div>
                                        <div class="postDescription">
                                            <span class="postDescriptionText"></span>
                                        </div>
                                        <span class="postAge">Test Text</span>
                                        <button class="btn btn-primary getStats" type="button">Get Player Stats</button>
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
                                                    <tr class="whiteText">
                                                        <td class="playerKD"></td>
                                                        <td class="playerAverageLifespan"></td>
                                                        <td class="playerWinLossRatio"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                    </template>
                                </div> <!-- /posts mdl cell-6 -->
                            </template>
                        <!--template    -->
                            <div class="postContainerTemplate mdl-grid">
                            
                            
                            </div>
                            
                             <!--Hard coded post-->
    
  
                            
                        <!--</div>-->
                        
                        
<!--LFG POST STARTS HERE-->
          
<!--LFG POST STARTS HERE-->


                    </div> <!--/tab1container-->
                </div> <!-- /pagecontent-->
                <!--</div>-->
            </section> <!-- /fixed tab 1-->

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
  
  <script async>
    
    function loadPosts(){
          console.log("hello");
          $(".postContainerTemplate").empty();
            var datasource = "ajax/getPostsData.php";
            // $(".postContainerTemplate").empty();
            //make an ajax request
            $.ajax({
                url:datasource,
                dataType:'json',
                type:'POST',
                encode:true
            })
            .done(function(data){
                console.log(data);
                //if there is data
                if(data.length > 0){
                    var len = data.length;
                    console.log(len);
                    
                    
                    for(i=0;i<len;i++){
                        var template = $("#playerPosts").html().trim();
                        var clone = $(template);
                        //fill the data
                        var username = data[i].username;
                        var selectedCharacter = data[i].selectedCharacter;
                        var consoleID = data[i].consoleID;
                        var activity = data[i].activity;
                        var description = data[i].description;
                        var emblemIcon = data[i].emblemIcon;
                        var emblemBackground = data[i].emblemBackground;
                        var lightLevel = data[i].lightLevel;
                        var grimoireScore = data[i].grimoireScore;
                        var hasMic = data[i].hasMic;
                        var postTimeD = data[i].ageD;
                        var postTimeH = data[i].ageH;
                        var postTimeM = data[i].ageM;
                        
                        var lightLevelIcon = "&#10022  ";
                        var grimoireImg = "./assets/grimoireIcon.png";
                        var buttonText = " Get Player Stats";
                        //TODO postTime = data[i].postTime;
                        // console.log("postTime: ", postTime);
                        // var a = new Date(Date.parse(postTime.replace('-','/','g')));
                        console.log("Row ", i, " D: ", postTimeD, " H: ",postTimeH, " M: ", postTimeM);
                        

                        // var b = new Date().getTime();
                        // console.log("b", b);
                        // var timeStart = new Date("Mon Jan 01 2007 11:00:00 GMT+0530").getTime();
                        // var timeEnd = new Date("Mon Jan 01 2007 11:30:00 GMT+0530").getTime();
                        // var hourDiff = b - a; //in ms
                        // var secDiff = hourDiff / 1000; //in s
                        // var minDiff = hourDiff / 60 / 1000; //in minutes
                        // var hDiff = hourDiff / 3600 / 1000; //in hours
                        // var humanReadable = {};
                        // humanReadable.hours = Math.floor(hDiff);
                        // humanReadable.minutes = minDiff - 60 * humanReadable.hours;
                        // console.log(humanReadable); //{hours: 0, minutes: 30}
                        
                        
                        // console.log("tets: ", nowTime);
                        // console.log("sql", mySQLpostTime);
                        
                        // var javascript_date = new Date(mySQLpostTime);
                        // console.log("js date:", javascript_date);
                        
                        // // var today = new Date.UTC();
                        // var today = new Date().getTime(); //local time
                        // console.log("today gettime", today);
                        // var d = Math.floor((new Date()).getTime() / 1000)
                        // // var milliseconds = new Date().getTime();
                        // // var n = d.getUTCDate();
                        // var s = new Date();
                        // s.setTime(d);
                        // //var date = new Date(today*1000);
                        // console.log("today: ", today);
                        // console.log("date", d);
                        // console.log("s", postTime);
                        // var diffMs = (today - javascript_date); // milliseconds between now & Christmas
                        // var diffDays = Math.floor(diffMs / 86400000); // days
                        // var diffHrs = Math.floor((diffMs % 86400000) / 3600000); // hours
                        // var diffMins = Math.round(((diffMs % 86400000) % 3600000) / 60000); // minutes
                        // //alert(diffDays + " days, " + diffHrs + " hours, " + diffMins + " minutes until Christmas 2009 =)");
                        // // console.log("Post ", milliseconds);
                        // console.log(diffDays, " days ago");                        
                        // console.log(diffHrs, " hours ago");
                        // console.log(diffMins, " mins ago");
                        
                        //TODO consoleID -> icon
                        if(consoleID == 1){
                          consoleChoice = "assets/xboxLogo.png"; //xbox icon
                        }
                        else if(consoleID == 2){
                          consoleChoice = "assets/psLogo.png"; //PS icon
                        }
                        
                        if(hasMic){
                          //var mic = "mic icon path"
                        }
                
                
                        $(clone).find(".playerUsernameOutput").html(username);
                        $(clone).find(".playerCurrentClass").html(selectedCharacter);
                        //console icon insert
                        $(clone).find(".consoleIcon").attr("src", consoleChoice);
                        $(clone).find(".postActivityText").html(activity);
                        $(clone).find(".postDescriptionText").html(description);
                        $(clone).find(".emblemIconImg").attr("src", emblemIcon);
                        $(clone).find(".emblemBackgroundImg").attr("src", emblemBackground);
                        $(clone).find(".playerLightLevel").html(lightLevelIcon+lightLevel);
                        
                        $(clone).find(".grimoireImage").attr("src", grimoireImg);
                        $(clone).find(".playerGrimoireOutput").html(grimoireScore);
                        
                        $(clone).find(".getStats").attr("data-name", username);
                        $(clone).find(".getStats").attr("data-console", consoleID);
                        // $(clone).find(".getStats").attr("value", buttonText);
                        $(clone).find(".getStats").attr("data-character", selectedCharacter);
                        
                        //   $(clone).find(".hasMic").html();
                        
                        $(".postContainerTemplate").append(clone);
                    }
                }
            });
            // componentHandler.upgradeDom();
          
        }
    
    //load posts from DB
    $(document).ready(function(){
    //     $("button").click(function(){
    //     alert("button");
    // });
        loadPosts();
    });
          
    setInterval("upgradeMDL();", 100);
    function upgradeMDL() {
        componentHandler.upgradeDom();
        //componentHandler.upgradeDom();
        componentHandler.upgradeAllRegistered();
    }
        // });
    
    
    //hide submit loader
    $('#submitPostLoading').hide();
    
    //Login dialog
    // var dialog = document.querySelector('dialog');
    // var showDialogButton = document.querySelector('#login-dialog');

    
    if ($('#submit-dialog').length){
        var dialog = document.querySelector('dialog');
        var showDialogButton = document.querySelector('#submit-dialog');
        if (!dialog.showModal) {
          dialogPolyfill.registerDialog(dialog);
        }
        showDialogButton.addEventListener('click', function() {
          dialog.showModal();
        });
        dialog.querySelector('.close').addEventListener('click', function() {
          dialog.close();
        });
    }
    
    //end login dialog
    
    //get player stats on LFG post
    $('.postContainerTemplate').on("click", ".getStats", clickHandler);
    // document('.getStats').addEventListener('click', function(clickHandler) {
    // var clickedButton = document.getElementsByClassName(".getStats");
    // $(clickedButton).on("click", clickHandler);
    // $(".btn").on("click", clickHandler);
    var clicks = 0;
    function clickHandler(e){
    
        // console.log(e);
    // console.log("Data exists log: ", $(e.target).attr("data-exists"));
        
    if($(e.target).attr("data-exists") == undefined){
        e.target;
        // var clickedBtn;
        
        var getName = $(e.target).data("name");
        // var getCharacter = $(e.target).parents(".mdl-button").data("character");
        var getCharacter = $(e.target).data("character");
        var getConsole = $(e.target).data("console");
        var datasource = "ajax/getPlayerStats.php";
        
        if(getName != undefined){
            $(e.target).siblings('.statsLoading').show();
            // $(clickedBtn).prop("disabled", true);
            // $(clickedBtn).parents(".mdl-button").html('Retrieving Stats..');
            clickedBtn =  $(e.target).parents(".getStats");
            $(e.target).html("Retrieving Stats..");
            $(e.target).attr("data-exists", "1");
        }
        else{
            // $(e.target).html("Error getting stats!");
        }
        
        
        // console.log("e target: ", e.target);
        // console.log("playerName: ", getName);
        // console.log("Character: ", getCharacter);    
        
        //TODO get console from post and pass to php
        var obj = {name: getName, character:getCharacter, console:getConsole};
        
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
                //   console.log(data);
                //if there is data
                //TODO removeChild after clicking hide stats
                // upgradeMDL();
                // componentHandler.upgradeDom(".mdl-button");
                $('.statsLoading').hide();
                $(e.target).html("Hide Stats");
                
                // $(".getStats").unbind("click", clickHandler);
                
                var jsonResponse = JSON.parse(data);
                // console.log(test.Response.trialsOfOsiris.allTime.killsDeathsRatio.basic.displayValue);
                if(typeof jsonResponse.Response.trialsOfOsiris.allTime === "undefined"){
                    console.log("ERROR");
                    $(e.target).html('Error: No stats found');
                    $(e.target).removeClass("btn-primary");
                    // $(e.target).addClass("getTrialsStatsError");
                    $(e.target).addClass("btn-danger");
                    $(e.target).attr("data-exists", null);
                    
                }
                else if(typeof jsonResponse.Response.trialsOfOsiris.allTime.killsDeathsRatio === "undefined"){
                    console.log("ERROR");
                    $(e.target).html('Error: No stats found');
                    $(e.target).removeClass("btn-primary");
                    // $(e.target).addClass("getTrialsStatsError");
                    $(e.target).addClass("btn-danger");
                    $(e.target).attr("data-exists", null);
                }
                //ELSEIF if response != 1, throw error if trial stats not found-->
                else if(typeof jsonResponse.Response.trialsOfOsiris.allTime.averageLifespan === "undefined"){
                    console.log("ERROR");
                    $(e.target).html('Error: No stats found');
                    $(e.target).removeClass("btn-primary");
                    // $(e.target).addClass("getTrialsStatsError");
                    $(e.target).addClass("btn-danger");
                    $(e.target).attr("data-exists", null);
                }
                else if(typeof jsonResponse.Response.trialsOfOsiris.allTime.winLossRatio === "undefined"){
                    console.log("ERROR");
                    $(e.target).html('Error: No stats found');
                    $(e.target).removeClass("btn-primary");
                    // $(e.target).addClass("getTrialsStatsError");
                    $(e.target).addClass("btn-danger");
                    $(e.target).attr("data-exists", null);
                }
                else{
                    clicks++;
                    // console.log(clicks);
                    // $(this).prop("disabled", false);
                    // $(clickedBtn).html('Hide Stats');
                    
                    var template = $("#playerStats").html().trim();
                    var clone = $(template);
                    //fill the data
                    //console.log(data.Response.trialsOfOsiris.allTime.killsDeathsRatio.basic.displayValue);
                    var playerKD = jsonResponse.Response.trialsOfOsiris.allTime.killsDeathsRatio.basic.displayValue;
                    var averageLifespan = jsonResponse.Response.trialsOfOsiris.allTime.averageLifespan.basic.displayValue;
                    var winLossRatio = jsonResponse.Response.trialsOfOsiris.allTime.winLossRatio.basic.displayValue;
                    // console.log("playerKD: ", playerKD);
                    // console.log("Avg Lifespan: ", averageLifespan);
                    // console.log("Response code: ", jsonResponse.Response);
                    
                    $(clone).find(".playerKD").html(playerKD);
                    $(clone).find(".playerAverageLifespan").html(averageLifespan);
                    $(clone).find(".playerWinLossRatio").html(winLossRatio);
                    // $(".stats-row").append(clone);
                    // $(".stats-row").append(clone);
                    // $(e.target).parent(".mdl-button").parent(".postCard").siblings(".stats-row").append(clone);
                    // console.log("btn :", clickedBtn);
                    $(e.target).parents(".postCard").siblings(".stats-row").append(clone);
                    //$(e.target).parents(".mdl-button").siblings('.statsLoading').show();
                }
                
              });
            //   timeout: 3000;
        
        // $(".getStats").unbind("click", hideStatsClick);
    
        // function hideStatsClick(e){
        //     console.log("Hide Test", e);
        //     e.target;
        // }
        
    }else if($(e.target).attr("data-exists") == 1){
        
        $(e.target).parents(".postCard").siblings(".stats-row").css("display", "none");
        $(e.target).html("Show Player Stats");
        // console.log("data = 1");
        $(e.target).attr("data-exists", "0");
        
        
    //     // $(e.target).parents(".mdl-button").parents(".postDescription").parents(".postCard").siblings(".stats-row").remove();
    //     // $(e.target).parent().siblings(".stats-row").attr("display", "none");
    //     $(e.target).parent(".mdl-button").parent(".postCard").siblings(".stats-row").attr("display", "none");
    //     clicks--;
    //     console.log("click- :", clicks);
    //     $(".getStats").html('Get Player Stats');
    }else if($(e.target).attr("data-exists") == "0"){
        $(e.target).html("Hide Stats");
        $(e.target).parents(".postCard").siblings(".stats-row").css("display", "");
        $(e.target).attr("data-exists", "1");
    }
      
      
    }
    
    
    //Hide shown stats
    //$("#btn2").unbind("click").click(function () {
    
    function showLoading() {
        console.log("showLoading fired");
        // remove existing loaders
        $('.loading-container').remove();
        $('<div id="orrsLoader" class="loading-container"><div><div class="mdl-spinner mdl-js-spinner is-active"></div></div></div>').appendTo("body");
    
        componentHandler.upgradeElements($('.mdl-spinner').get());
        setTimeout(function () {
            $('#orrsLoader').css({opacity: 1});
        }, 1);
    }
    
    function hideLoading() {
    $('#orrsLoader').css({opacity: 0});
    setTimeout(function () {
        $('#orrsLoader').remove();
    }, 400);
}
    
  
    //Submit LFG Post
    $("#submitPostForm").submit(function(e){
        
        showLoading();
        setTimeout(function () {
            hideLoading();
        }, 3000);
        
        $('#submitPostLoading').show();
        // <button id='btnAddProfile' type='button'>Add</button>
        $("#submitLFGpost").html('Submitting');
        
        var submitPHP = "ajax/submitNewPost.php";
        
        
        //disable buttons on submit
        $("#submitLFGpost").attr("disabled", "disabled");
        $("#cancelLFGpost").remove();
        
        $.ajax({
            type:"POST",
            url: submitPHP,
            data: $("#submitPostForm").serialize(),
            
            success: function(data){
                // alert(data);
                $('#submitPostLoading').show();
                dialog.close();
                
                var notification = document.querySelector('.mdl-js-snackbar');
                notification.MaterialSnackbar.showSnackbar(
                  {
                    message: 'Post Submitted!'
                  }
                );
                $("#submitLFGpost").html('Submit');
                $('#submitPostLoading').hide();
                loadPosts();
                upgradeMDL();
                
                // hideLoading();
                
                
                
                // var snackbarContainer = document.querySelector('#demo-toast-example');
                // var data = {message: 'Example Message '};
                // snackbarContainer.MaterialSnackbar.showSnackbar(data);
                //success message or something
                //hide loading animation
                //close dialog
            }
            
            
        });
        
        e.preventDefault();
    });
    
      
      
    
    
  </script>
  
  
  
<!--ENDS HERE-->


    
 </body>
 
</html>