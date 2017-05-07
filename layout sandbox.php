<?php
//wheels00769: 4611686018428911554
 //Jeewwbacca: 4611686018439307322
 
 $jew = "jeewwbacca";
 $tim = "tanky_tim12";
 $wheels = "wheels00769";
 $cosmic = "cosmicrichy";
 $ran="RannerzS12";
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
 curl_setopt($getMembershipId, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/SearchDestinyPlayer/'.$psn.'/'.$ran.'/');
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
 echo $result;
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
 // echo "<p>Trials Stats: <p>", $trialsTotalKills, " kills, Average per game: ", $trialsAverageKillsPerGame;
 // echo "<p>";
 // echo $trialsTotalDeaths, " deaths, Average per game: ", $trialsAverageDeathsPerGame;
 // echo "<p>Average K/D: ", $trialsKDRatio;
 
 
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
                <div class="rightSide">
                    <div class="playerLightLevel"><span id="lightLevelIcon">&#10022  </span><?= $lightLevel; ?></div>
                    <div class="playerGrimoire"><?= $grimoire; ?>
                        <img id="grimoireIcon" src="./assets/grimoireIcon.png"></img>
                    </div>
                </div>
            </div>
                <!--<div class="innerContainer">-->
                    <form id="playerStatsForm"> 
                        <input type="hidden" name="getStatsButton" value="<?= $displayName; ?>">
                            <button id="getStats">Get Player Stats</button>
                        </input>
                    </form>
                <!--</div>    -->
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
  
  .innerContainer{
      height:204px;
      width: inherit;
      position: absolute;
  }
  
  .postContainer{
     margin: 0 auto;
     position: relative;
      min-height: 300px;
      width:475px;
  }
  
  .postContent{
      position: absolute;
      /*border: 1px solid;*/
      width:475px;
      height: 300px;
  }
  .rightSide{
      height: 96px;
      width: 80px;
      float: right;
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
       position: relative;
       bottom: 0;
   }
   
   .trialsStatsRow{
       width: 475px;    
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
    top: 0;
    height: 28px;
    /*right: 20;*/
    width: inherit;
    font-size: 22px;
    font-family: Roboto;
    text-align: left;
    margin-top: 20px;
    color: rgb(255, 215, 0);
   }
   
   /*#lightLevelIcon{*/
   /* text-align: left;*/
   /*}*/
   
   .playerGrimoire{
    height: 28px;
    position: absolute;
    bottom: 0;
    margin-bottom: 20px;
    width: inherit;
    font-family: Roboto;
    color: white;
    text-align: center;
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
   
   
   
  </style>
  
<!--ENDS HERE-->


    
 </body>
 
</html>