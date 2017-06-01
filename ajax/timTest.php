<?php

    include("./../key.php");

    $playerName = $_POST['name'];
    $selectedCharacter = $_POST['character'];
    $consoleID = 2;
    $activity = "Iron";
    $membershipID = 4611686018428678434;
    $characterID = 2305843009241542501;

     
     
    if (strpos($activity, 'Crucible') !== false) {
        $statsMode = "AllPvP";
            // echo "<p>inside: ", $hashToGet;
    }
    else if (strpos($activity, 'Iron') !== false) {
        $statsMode = "IronBanner";
    }
    else if (strpos($activity, 'Trials') !== false) {
        $statsMode = "TrialsOfOsiris";
    }
    
    echo "statsmode: ", $statsMode;
     
 $accountSummary = curl_init();

 //ALL TIME STATS HERE
 curl_setopt($accountSummary, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/Stats/'.$consoleID.'/'.$membershipID.'/'.$characterID.'/?modes='.$statsMode.'');
 curl_setopt($accountSummary, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($accountSummary, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $apiKey));
 $getAccountSummary = curl_exec($accountSummary);
 $json2 = json_decode($getAccountSummary);
 
    if($statsMode == "IronBanner"){
        $modeSlot = "ironBanner";
    }
    else if($statsMode == "AllPvP"){
        $modeSlot = "allPvP";
    }
    else if($statsMode == "TrialsOfOsiris"){
        $modeSlot = "trialsOfOsiris";
    }
    
    echo "modeslot: ", $modeSlot;
 
    
    $ibKDRatio = $json2->Response->$modeSlot->allTime->killsDeathsRatio->basic->displayValue;

 
    $ibAverageLifespan = $json2->Response->$modeSlot->allTime->averageLifespan->basic->displayValue;
    
 
    $ibWinLossRatio = $json2->Response->$modeSlot->allTime->winLossRatio->basic->displayValue;
 
 
    $ironBannerStats = array("kdRatio" => $ibKDRatio, "avgLifeSpan" => $ibAverageLifespan, "winLossRatio" => $ibWinLossRatio);
    
    
    echo json_encode($ironBannerStats);


?>