<?php

    include("./../key.php");

    $consoleID = $_POST['console'];
    $activity = $_POST['activity'];
    $membershipID = $_POST['membershipID'];
    $characterID = $_POST['characterID'];

    $accountSummary = curl_init();
    curl_setopt($accountSummary, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/Stats/'.$consoleID.'/'.$membershipID.'/'.$characterID.'/?modes=IronBanner');
    curl_setopt($accountSummary, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($accountSummary, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $apiKey));
    $getAccountSummary = curl_exec($accountSummary);
    $json2 = json_decode($getAccountSummary);
 
 
 
    $ibKDRatio = $json2->Response->ironBanner->allTime->killsDeathsRatio->basic->displayValue;

 
    $ibAverageLifespan = $json2->Response->ironBanner->allTime->averageLifespan->basic->displayValue;
    
 
    $ibWinLossRatio = $json2->Response->ironBanner->allTime->winLossRatio->basic->displayValue;
 
 
    $ironBannerStats = array("kdRatio" => $ibKDRatio, "avgLifespan" => $ibAverageLifespan, "winLossRatio" => $ibWinLossRatio);
    
    echo json_encode($ironBannerStats);

?>