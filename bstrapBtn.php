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
        $titanEmblem = $getEmblemsResult->Response->data->characters[$_SESSION['user']['titanSlot']]->emblemPath;
        $hunterEmblem = $getEmblemsResult->Response->data->characters[$_SESSION['user']['hunterSlot']]->emblemPath;
        $warlockEmblem = $getEmblemsResult->Response->data->characters[$_SESSION['user']['warlockSlot']]->emblemPath;
        
        $_SESSION["titanArray"]= $titanEmblem;
        $_SESSION["hunterArray"] = $hunterEmblem;
        $_SESSION["warlockArray"] = $warlockEmblem;
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
                                    <option value="option1">option 1</option>
                                    <option value="option2">option 2</option>
                                    <option value="option3">option 3</option>
                                    <option value="option4">option 4</option>
                                    <option value="option5">option 5</option>
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
                    <button type="button" id="cancelLFGpost" class="mdl-button close">Cancel</button>
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
                           
                        <!--template    -->
                            <div class="postContainerTemplate mdl-grid">
                            <template id="playerPosts">
                                <div class="posts mdl-cell mdl-cell--3-offset-phone mdl-cell--6-col mdl-cell--3-offset-phone">
                                    <div class="postCard mdl-card mdl-card--primary mdl-shadow--2dp">
                                        <div class="emblemContainer">
                                            <div class="emblemIcon">
                                                <img class="emblemIconImg">
                                            </div>
                                            <div class="emblemBackground">
                                                <img class="emblemBackgroundImg" src="">
                                            </div>
                                            <div class="playerUsername"></div>
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
                                        <div class="postDescription"><span class="postDescriptionText"></span></div>
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
                            </template></div>
                            
                             <!--Hard coded post-->
    <div class="postContainer mdl-cell mdl-cell--6-col">
        <div class="postCard mdl-card mdl-card--primary mdl-shadow--2dp">
            <div class="emblemContainer">
                <div class="emblemIcon">
                    <img src="<= htmlspecialchars($completeEmblemIcon); ?>"></img>
                </div>
                <div class="emblemBackground">
                    <img src="<= htmlspecialchars($completeEmblemBackground); ?>"></img>
                </div>
                <div class="playerUsername"><= $displayName; ?></div>
                <div class="playerCurrentClass"><= $activeCharacter; ?></div>
                <div class="rightSide">
                    <div class="playerLightLevel"><span id="lightLevelIcon">&#10022  </span><= $lightLevel; ?></div>
                    <div class="playerGrimoire"><= $grimoire; ?>
                        <img class="grimoireImage" src="./assets/grimoireIcon.png"></img>
                    </div>
                </div>
            </div>
            <div class="mdl-spinner mdl-js-spinner is-active getStatsLoading statsLoading"></div>
                <div class="innerContainer">
            <div class="postActivity"><span class="postActivityText">Trials of Osiris</span>
                <div class="divider"></div>
            </div>
           
            <div class="postDescription"><span class="postDescriptionText">LF 1 more, must have K/D above 1.5, have mic and be over the age of 18.</span></div>
                <button class="getStats mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" data-name="<?=$displayName;?>" data-character="<?=$activeCharacter;?>" >Get Player Stats</button>
        </div>
        
        
        <div class="stats-row whiteText ?= $displayName; ?>"></div>
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
                         Row 1 
                        <tr class="whiteText">
                            <td class="playerKD"></td>
                            <td class="playerAverageLifespan"></td>
                            <td class="playerWinLossRatio"></td>
                        </tr>
                    </tbody>
                </table>
        </template>
    </div>
    
    <!--end hardcoded post-->
    
    
    <div class="mdl-cell mdl-cell--6-col">6</div>
    
<!--FIRST LFG POST ENDS HERE-->
    
   
<!--SECOND LFG POST ENDS HERE-->

<!--  TrialsReport star icon : ✦ -->
  </div>
  
                            
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
  
  <script>
    
    function loadPosts(){
          console.log("hello");
            var datasource = "ajax/getPostsData.php";
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
                        
                        var lightLevelIcon = "&#10022  ";
                        var grimoireImg = "./assets/grimoireIcon.png";
                        var buttonText = " Get Player Stats";
                        //TODO postTime = data[i].postTime;
                        
                        //TODO consoleID -> icon
                        if(consoleID == 1){
                          consoleChoice = ""; //xbox icon
                        }
                        else if(consoleID == 2){
                          consoleChoice = ""; //PS icon
                        }
                        
                        if(hasMic){
                          //var mic = "mic icon path"
                        }
                
                
                        $(clone).find(".playerUsername").html(username);
                        $(clone).find(".playerCurrentClass").html(selectedCharacter);
                        //console icon insert
                        //   $(clone).find(".console").html(consoleChoice);
                        $(clone).find(".postActivityText").html(activity);
                        // $(clone).find(".postDescription").html(description);
                        $(clone).find(".emblemIconImg").attr("src", emblemIcon);
                        $(clone).find(".emblemBackgroundImg").attr("src", emblemBackground);
                        $(clone).find(".playerLightLevel").html(lightLevelIcon+lightLevel);
                        
                        $(clone).find(".grimoireImage").attr("src", grimoireImg);
                        $(clone).find(".playerGrimoireOutput").html(grimoireScore);
                        
                        $(clone).find(".getStats").attr("data-name", username);
                        
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
        $("button").click(function(){
        alert("button");
    });
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
    
    //end login dialog
    
    //get player stats on LFG post
    $('.postContainerTemplate').on("click", ".getStats", clickHandler);
    // document('.getStats').addEventListener('click', function(clickHandler) {
    // var clickedButton = document.getElementsByClassName(".getStats");
    // $(clickedButton).on("click", clickHandler);
    // $(".btn").on("click", clickHandler);
    var clicks = 0;
    function clickHandler(e){
    
        console.log(e);
    // console.log("Data exists log: ", $(e.target).attr("data-exists"));
        
    if($(e.target).attr("data-exists") == undefined){
        e.target;
        // var clickedBtn;
        
        var getName = $(e.target).data("name");
        // var getCharacter = $(e.target).parents(".mdl-button").data("character");
        var getCharacter = $(e.target).data("character");
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
                // upgradeMDL();
                // componentHandler.upgradeDom(".mdl-button");
                $('.statsLoading').hide();
                $(e.target).html("Hide Stats");
                
                // $(".getStats").unbind("click", clickHandler);
                
                var jsonResponse = JSON.parse(data);
                // console.log(test.Response.trialsOfOsiris.allTime.killsDeathsRatio.basic.displayValue);
                if(typeof jsonResponse.Response.trialsOfOsiris.allTime === "undefined"){
                    console.log("ERROR");
                    $(".getStats").html('Error: No stats found');
                    $(".getStats").removeClass("mdl-button--accent");
                    $(".getStats").addClass("getTrialsStatsError");
                    
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
                    clicks++;
                    console.log(clicks);
                    // $(this).prop("disabled", false);
                    // $(clickedBtn).html('Hide Stats');
                    
                    var template = $("#playerStats").html().trim();
                    var clone = $(template);
                    //fill the data
                    //console.log(data.Response.trialsOfOsiris.allTime.killsDeathsRatio.basic.displayValue);
                    var playerKD = jsonResponse.Response.trialsOfOsiris.allTime.killsDeathsRatio.basic.displayValue;
                    var averageLifespan = jsonResponse.Response.trialsOfOsiris.allTime.averageLifespan.basic.displayValue;
                    var winLossRatio = jsonResponse.Response.trialsOfOsiris.allTime.winLossRatio.basic.displayValue;
                    console.log("playerKD: ", playerKD);
                    console.log("Avg Lifespan: ", averageLifespan);
                    console.log("Response code: ", jsonResponse.Response);
                    
                    $(clone).find(".playerKD").html(playerKD);
                    $(clone).find(".playerAverageLifespan").html(averageLifespan);
                    $(clone).find(".playerWinLossRatio").html(winLossRatio);
                    // $(".stats-row").append(clone);
                    // $(".stats-row").append(clone);
                    // $(e.target).parent(".mdl-button").parent(".postCard").siblings(".stats-row").append(clone);
                    console.log("btn :", clickedBtn);
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
        console.log("data = 1");
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
      
      e.preventDefault();  
    }
    
    
    //Hide shown stats
    //$("#btn2").unbind("click").click(function () {
    
//     function showLoading() {
//         console.log("showLoading fired");
//         // remove existing loaders
//         $('.loading-container').remove();
//         $('<div id="orrsLoader" class="loading-container"><div><div class="mdl-spinner mdl-js-spinner is-active"></div></div></div>').appendTo("body");
    
//         componentHandler.upgradeElements($('.mdl-spinner').get());
//         setTimeout(function () {
//             $('#orrsLoader').css({opacity: 1});
//         }, 1);
//     }
    
//     function hideLoading() {
//     $('#orrsLoader').css({opacity: 0});
//     setTimeout(function () {
//         $('#orrsLoader').remove();
//     }, 400);
// }
    
  
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
                
                // hideLoading();
                loadPosts();
                
                
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