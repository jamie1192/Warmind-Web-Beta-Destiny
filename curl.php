<?php
//wheels00769: 4611686018428911554
 //Jeewwbacca: 4611686018439307322
 
 $jew = "jeewwbacca";
 $tim = "tanky_tim12";
 $wheels = "wheels00769";
 $cosmic = "cosmicrichy";
 $hunter = 0;
 $titan = 1;
 $warlock = 2;
 
 $selectedCharacter = 0;
 
 $psn = 2;
 $xbox = 3;
 
 if($selectedCharacter == 0)
 {
  $activeCharacter = "Titan";
 }
 elseif($selectedCharacter == 1)
 {
  $activeCharacter="Hunter";
 }
 else
  $activeCharacter = "Warlock";

 $apiKey = 'b7139c21a2114d17b538c7a53ceff70d';
 
// $membershipID = 4611686018439307322;
 
//  curl_setopt($ch, CURLOPT_URL, 'https://www.bungie.net/platform/Destiny/Manifest/InventoryItem/1274330687/');

//get memberships (test)>
// /SearchDestinyPlayer/{membershipType}/{displayName}/

//1. get membershipID and search by given username
 $getMembershipId = curl_init();
 //curl_setopt($getMembershipId, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/2/Stats/GetMembershipIdByDisplayName/'.$wheels.'/');
 
 //case insensitive PSN name search- THIS SPITS OUT AN ARRAY
 curl_setopt($getMembershipId, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/SearchDestinyPlayer/'.$psn.'/'.$cosmic.'/');
 curl_setopt($getMembershipId, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($getMembershipId, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $apiKey));
 $getMembershipResults = curl_exec($getMembershipId);
 $getMembershipResponse = json_decode($getMembershipResults);
 
 
 //
 $membershipID = $getMembershipResponse->Response[0]->membershipId;
 $displayName = $getMembershipResponse->Response[0]->displayName;;
//  echo "case insensitive test: ", $getMembershipResults;
 
//  echo "First membership ID: ", $membershipID;
 
 //Aggregate Stats
 // /Stats/AggregateActivityStats/{membershipType}/{destinyMembershipId}/{characterId}/
 
 //2. get Account Summary- Jeewwbacca
 //IF statement to determined correct array slot for character choice
 
  //error(?) //TODO
  
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/2/Account/'.$membershipID.'/Summary/');
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $apiKey));
 $result = curl_exec($ch);
 $json = json_decode($result);
 //echo $result;
 // $membershipID = $json->Response;
 //$counter = 0;
 $slot0 = $json->Response->data->characters[0]->characterBase->classType;
 $slot1 = $json->Response->data->characters[1]->characterBase->classType;
 $slot2 = $json->Response->data->characters[2]->characterBase->classType;
 if($selectedCharacter == $slot0){
     $characterArraySlot = $selectedCharacter;
     //echo "<p>slot 0";
 }
 elseif($selectedCharacter == $slot1){
     $characterArraySlot = $selectedCharacter;
    //  echo "<P>slot 1";
 }
 elseif($selectedCharacter == $slot2){
     $characterArraySlot = $selectedCharacter;
    //  echo "<P>slot 2";
 }
 else{
     //throw error or something //TODO
 }
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
 
 // $urlMissing2 = "https://bungie.net";
 
 $emblemPath = $json->Response->data->characters[$characterArraySlot]->emblemPath;
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
 
 
 
 
 //Get emblem/background paths
 // $emblemPath = $json->Response->data->characters[$hunter]->emblemPath;
 // $emblemBackgroundPath = $json->Response->data->characters[$hunter]->backgroundPath;
 // $completeEmblemIcon = $urlMissing1 .= $emblemPath;
 // $completeEmblemBackground = $urlMissing2 .= $emblemBackgroundPath;
 
 // $grimoire = $json->Response->data->characters[$hunter]->characterBase->grimoireScore;
 
 // echo "Hunter Emblem Icon Link: ", $completeEmblemIcon;
 // echo "<p> Emblem Background Path: ", $completeEmblemBackground;
 // echo "<p> Hunter Grimoire is: ", $grimoire;
 
 
 
 
 
 
 //echo $json->ErrorCode;//->data->inventoryItem->itemName; //Gjallarhorn
 //echo $json->ErrorStatus;
 //echo $json->Message;

?>

<!DOCTYPE html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <script src="node_modules/jquery/dist/jquery.js"></script>
    <link rel="stylesheet" href="/node_modules/material-design-lite/material.min.css">
    <script src="/node_modules/material-design-lite/material.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
 
</head>
 <html>
     <!--PASTE STARTS HERE-->
      <body>

    <!-- Layout Container with Fixed Header and Tabs -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header mdl-layout--fixed-tabs mdl-layout--fixed-drawer">
        <header class="mdl-layout__header">
            <div class="mdl-layout__header-row">
                <!-- Header Title -->
                <span class="mdl-layout-title">Material Design Layout Testing</span>
                <!-- Add spacer, to align navigation to the right -->
                <div class="mdl-layout-spacer"></div>
                <!-- Header Buttons -->
                <nav class="mdl-navigation">
                    <button id="login-dialog" type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Login</button>

                    <!--                            Start of MDL dialog new Login-->
                    <dialog class="mdl-dialog loginDialog">
                        <h4 class="mdl-dialog__title mdl-color-text--primary">Existing User Login</h4>
                        <!--                                <div class="mdl-dialog__content">-->

                        <!--                                Floating labels-->
                        <form action="#">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                <input class="mdl-textfield__input" type="text" id="username">
                                <label class="mdl-textfield__label" for="username">Username</label>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                <input class="mdl-textfield__input" type="password" id="password">
                                <label class="mdl-textfield__label" for="password">Password</label>

                            </div>
                            <span class="mdl-textfield__error">Incorrect email or password!</span>

                            <!--                                    Cancel Button-->
                            <div class="mdl-dialog__actions mdl-dialog__actions--full-width">
                                <button class="mdl-button close mdl-js-button mdl-js-ripple-effect mdl-dialog__actions--full-width">
  Cancel
</button>

                                <!--                                    Login Button-->
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary mdl-dialog__actions--full-width">
  Login
</button>
                            </div>
                        </form>
                        <!--                                </div>-->
                    </dialog>


                    <script>
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
                    </script>
                    <!--                            End of dialog-->

                    <!--                            jQuery for button-->


                    <!--                            end jQuery -->



                </nav>
            </div>

            <!-- Tab Container with Tab links -->
            <div class="mdl-layout__tab-bar mdl-js-ripple-effect">
                <!-- class is-active to show currently active tab -->
                <a href="#fixed-tab-1" class="mdl-layout__tab is-active">First Tab</a>
                <a href="#fixed-tab-2" class="mdl-layout__tab">Second Tab</a>
                <a href="#fixed-tab-3" class="mdl-layout__tab">Third Tab</a>
            </div>
        </header>

        <!--            Proper MDL sidebar-->

        <div class="mdl-layout__drawer mdl-layout__drawer">
            <span class="mdl-layout-title">Title</span>
<!--            User account header-->
            <header class="demo-drawer-header">
                <img src="http://lorempixel.com/40/40/people" class="demo-avatar">
                <div class="demo-avatar-dropdown">
                    <span>hello@example.com</span>
                <div class="mdl-layout-spacer"></div>
                    <button id="accbtn" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                        <i class="material-icons" role="presentation">arrow_drop_down</i>
                        <span class="visuallyhidden">Accounts</span>
                    </button>
                    <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="accbtn">
                        <li class="mdl-menu__item">hello@example.com</li>
                        <li class="mdl-menu__item">info@example.com</li>
                        <li class="mdl-menu__item"><i class="material-icons">add</i>Add another account...</li>
                    </ul>
                </div>
            </header>
        <nav class="mdl-navigation">
          <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>Home</a>
          <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">inbox</i>Inbox</a>
          <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">delete</i>Trash</a>
          <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">report</i>Spam</a>
          <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">forum</i>Forums</a>
          <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">flag</i>Updates</a>
          <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">local_offer</i>Promos</a>
          <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">shopping_cart</i>Purchases</a>
          <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">people</i>Social</a>
          <div class="mdl-layout-spacer"></div>
          <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">help_outline</i><span class="visuallyhidden">Help</span></a>
        </nav>
<!--            End user account header-->
            
            
        </div>
        <main class="mdl-layout__content">

            <section class="mdl-layout__tab-panel is-active" id="fixed-tab-1">
                <div class="page-content">
                    <div class="tab1container"><!--Tab 1-->

<!--LFG POST STARTS HERE-->
    <div class="postContainer">
        <div class="postContent mdl-card mdl-card--primary mdl-shadow--2dp ">
            <div class="emblemContainer">
                <div class="emblemIcon">
                    <img src="<?= $completeEmblemIcon; ?>"></img>
                </div>
                <div class="emblemBackground">
                    <img src="<?= $completeEmblemBackground; ?>"></img>
                </div>
                <div class="playerUsername"><?= $displayName; ?></div>
                <div class="playerCurrentClass"><?= $activeCharacter; ?></div>
                <div class="playerGrimoire"><?= $grimoire; ?>
                    <img id="grimoireIcon" src="./assets/grimoireIcon.png"></img>
                </div>
                <div class="playerLightLevel"><span id="lightLevelIcon">&#10022  </span><?= $lightLevel; ?></div>
            </div>
            <form id="playerStatsForm"> 
                <input type="hidden" name="getStatsButton" value="<?= $displayName; ?>">
                    <button id="getStats">Get Player Stats</button>
                </input>
            </form>
        </div>
        <div class="stats-row"></div>
        <template id="playerStats">
                <table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp trialsStatsRow">
                <thead>
                    <tr>
                        <th>K/D Ratio</th>
                        <th>Average Lifespan</th>
                        <th>Win/Loss Ratio</th>
                    </tr>
                </thead>
                    <tbody>
                        <!-- Row 1 -->
                        <tr>
                            <td class="playerKD"></td>
                            <td class="playerAverageLifespan"></td>
                            <td class="playerWinLossRatio"></td>
                        </tr>
                    </tbody>
                </table>
            </template>
        </div>
  
  <!--TrialsReport star icon : ✦ -->
  
  <script>
      $(document).ready(function(){
          //add listener for button click
          $("#playerStatsForm").on("submit", function(e){
              e.preventDefault();
              
              var playerName = {name:$("#playerStatsForm input").val()};
              var datasource = "ajax/getPlayerStats.php";
              $.ajax({
                  data:playerName, 
                  datatype: 'json',
                  url:datasource,
                  type: 'POST',
                  encode: true
              })
              .done(function(data){
                  //console.log(data);
                //if there is data
                var test = JSON.parse(data);
                console.log(test.Response.trialsOfOsiris.allTime.killsDeathsRatio.basic.displayValue);
                if(data.length > 0){
                    
                    var template = $("#playerStats").html().trim();
                    var clone = $(template);
                    //fill the data
                    //console.log(data.Response.trialsOfOsiris.allTime.killsDeathsRatio.basic.displayValue);
                    var playerKD = test.Response.trialsOfOsiris.allTime.killsDeathsRatio.basic.displayValue;
                    console.log("playerKD: ", playerKD);
                    
                    $(clone).find(".playerKD").html(playerKD);
                    $(".stats-row").append(clone);
                }
                
              })
              
              
          })
      })
      
  </script>
  
  <style>
  
  #getStats{
      position: absolute;
      bottom: 0;
      right: 0;
  }
  
  .postContent{
      position: relative;
      /*border: 1px solid;*/
      width:475px;
      height: 300px;
  }
  
  .postContainer{
     margin: 0 auto;
      min-height: 300px;
  }
   
   .emblemContainer{
    position: absolute;
    top: 0;
    /*left: 0;*/
     width:475px;
    height: 96px;
    
   }
   
   .emblemIcon, .emblemBackground{
    position: absolute;
    left:0;
    top: 0;
    /*border-radius: 3px;*/
   }
   
   .playerUsername{
    position: absolute;
    left: 106px;
    top: 20px;
    font-size: 20px;
    color: white;
    font-family: RobotoDraft,Roboto;
   }
   .stats-row{
       position: absolute;
       bottom: 0;
   }
   
   .trialsStatsRow{
       width: 475px;    
   }
   
   .page-content{
       min-height: 800px;
   }
   
   .playerCurrentClass{
       position: absolute;
       left: 106px;
       bottom: 0px;
       height: 48px;
       width: 60px;
       text-align: left;
       font-family: RobotoDraft, Roboto;
       color: white;
       font-size: 14px;
   }
   
   .playerLightLevel{
    position: absolute;
    top: 20;
    /*height: 48px;*/
    right: 20;
    width: 60px;
    font-size: 22px;
    font-family: Roboto;
    text-align: right;
    color: rgb(255, 215, 0);
   }
   
   /*#lightLevelIcon{*/
   /* text-align: left;*/
   /*}*/
   
   .playerGrimoire{
    height: 48px;
    position: absolute;
    bottom: 0;
    right:20;
    width: 60px;
    font-family: Roboto;
    color: white;
    text-align: right;
   }
   
   #grimoireIcon{
    position: absolute;
    left: 0;
    max-height: 16px;
   }
   
   .emblemIcon{
   z-index: 10;
   }
   
   .emblemBackground img{
    border-radius: 4px;
   }
   
   .emblemIcon img{
    border-radius: 4px;
   }
   
   .tab1container{
       min-height: 700px;
   }
   
  </style>
  
<!--ENDS HERE-->


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
  <!--PASTE ENDS HERE-->
  
 <!--<body>-->
    
 </body>
 
</html>