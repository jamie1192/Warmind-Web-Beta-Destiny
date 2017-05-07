<?php

    include("./../key.php");

    $playerName = $_POST['name'];
    $selectedCharacter = $_POST['character'];

     $psn = 2;
     $xbox = 3;
 
     if($selectedCharacter == "Titan")
     {
      $activeCharacter = 0;
     }
     elseif($selectedCharacter == "Hunter")
     {
      $activeCharacter= 1;
     }
     elseif($selectedCharacter == "Warlock")
     { 
        $activeCharacter = 2;
     }
     else{
         //throw error or something, iunno
     }
    
 
//1. get membershipID and search by given username
 $getMembershipId = curl_init();
 
 //case insensitive PSN name search- THIS SPITS OUT AN ARRAY
 curl_setopt($getMembershipId, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/SearchDestinyPlayer/'.$psn.'/'.$playerName.'/');
 curl_setopt($getMembershipId, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($getMembershipId, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $apiKey));
 $getMembershipResults = curl_exec($getMembershipId);
 $getMembershipResponse = json_decode($getMembershipResults);
 
 //
 $membershipID = $getMembershipResponse->Response[0]->membershipId;
 $displayName = $getMembershipResponse->Response[0]->displayName;
 
 //Aggregate Stats
 // /Stats/AggregateActivityStats/{membershipType}/{destinyMembershipId}/{characterId}/
 
 //2. get Account Summary- Jeewwbacca
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/2/Account/'.$membershipID.'/Summary/');
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $apiKey));
 $result = curl_exec($ch);
 $json = json_decode($result);
 
 $slot0 = $json->Response->data->characters[0]->characterBase->classType; //wheels = 1, jew = 0
//  echo "<p>slot 0, json: ", $slot0;
 $slot1 = $json->Response->data->characters[1]->characterBase->classType; //wheels = 0, jew = 1
//  echo "<p>slot 1, json: ", $slot1;
 $slot2 = $json->Response->data->characters[2]->characterBase->classType; //wheels = 2, jew = 2
//  echo "<p>slot 2, json: ", $slot2;
 
 if($activeCharacter == $slot0){
     $characterArraySlot = 0;
    //  echo "<p>IF slot 0";
 }
 elseif($activeCharacter == $slot1){
     $characterArraySlot = 1;
    //  echo "<P>IF slot 1";
 }
 elseif($activeCharacter == $slot2){
     $characterArraySlot = 2;
    //  echo "<P>IF slot 2";
 }
 else{
     //throw error or something //TODO
 }
 // $membershipID = $json->Response;
 $characterId = $json->Response->data->characters[$characterArraySlot]->characterBase->characterId;
//  $lightLevel = $json->Response->data->characters[$characterArraySlot]->characterBase->powerLevel;
//  $grimoire = $json->Response->data->characters[$characterArraySlot]->characterBase->grimoireScore;
 

 //TESTING BELOW- Trials stats
 $accountSummary = curl_init();

 //ALL TIME STATS HERE
 curl_setopt($accountSummary, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/Stats/2/'.$membershipID.'/'.$characterId.'/?modes=TrialsOfOsiris');
 curl_setopt($accountSummary, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($accountSummary, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $apiKey));
 $getAccountSummary = curl_exec($accountSummary);
 $json2 = json_decode($getAccountSummary);
 
 //Get Warlock Light Level 
 //echo "<p>Light Level: ", $json2->Response->data->characters[$hunter]->characterBase->powerLevel;//->characterBase->minutesPlayedTotal;
 
 
//  $trialsKDRatio = $json2->Response->trialsOfOsiris->allTime->killsDeathsRatio->basic->displayValue;
//  $trialsTotalKills = $json2->Response->trialsOfOsiris->allTime->kills->basic->displayValue;
//  $trialsAverageKillsPerGame = $json2->Response->trialsOfOsiris->allTime->kills->pga->displayValue;
//  $trialsTotalDeaths = $json2->Response->trialsOfOsiris->allTime->deaths->basic->displayValue;
//  $trialsAverageDeathsPerGame = $json2->Response->trialsOfOsiris->allTime->deaths->pga->displayValue;
//  $trialsAverageLifespan = $json2->Response->trialsOfOsiris->allTime->averageLifespan->basic->displayValue;
//  $trialsWinLossRatio = $json2->Response->trialsOfOsiris->allTime->winLossRatio->basic->displayValue;
//  $trialsLongestKillSpree = $json2->Response->trialsOfOsiris->allTime->longestKillSpree->basic->displayValue;
 
 
 
 // echo "<p>Trials test: ", $getAccountSummary;
//  echo "<p>Trials Stats: <p>", $trialsTotalKills, " kills, Average per game: ", $trialsAverageKillsPerGame;
 echo $getAccountSummary;

?>