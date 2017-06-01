<?php 

// http://www.bungie.net/Platform/Destiny/Stats/ActivityHistory/{membershipType}/{destinyMembershipId}/{characterId}/

    include("key.php");
    include("./ajax/raidHashes.php");
    
    $raidName = "Wrath of the Machine";
    
    $hashToGet = 0;
    
    if (strpos($raidName, 'Wrath') !== false) {
            $hashToGet = $vogN;
            
            echo "vog: ", $vogN;
            
            echo "<p>inside: ", $hashToGet;
            
        }
        // else if(strpos($activityStr, 'PvP') !== false){
        //     // if(strpos($))
        //     // echo 'pvp';
        //     $activityType = "pvp";
        // }
        // else if((strpos($activityStr, 'Weeklies') !== false) || (strpos($activityStr, 'Strike') !== false)){
        //     $activityType = "strikes";
        //     // echo 'strikes';
        // }
        // else if((strpos($activityStr, 'Arena') !== false) || (strpos($activityStr, 'Patrol') !== false)){
        //     $activityType = "other";
        //     // echo 'other';
        // }
    
    
    $accountSummary = curl_init();
    // curl_setopt($accountSummary, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/Stats/2/4611686018428911554/2305843009259744176/');
    
    //wheels
    // curl_setopt($accountSummary, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/Stats/AggregateActivityStats/2/4611686018428911554/2305843009259744176/?definitions=true');
    
    //jew hunter
    // curl_setopt($accountSummary, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/Stats/2/4611686018439307322/2305843009271315861/?definitions=true');
    // curl_setopt($accountSummary, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/Advisors/V2/');
    
    //full account wide aggregate stats for all activities
    // curl_setopt($accountSummary, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/Stats/Account/2/4611686018439307322/');
    // curl_setopt($accountSummary, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/Manifest/raid/1733556769/');
    
    //Iron Banana stats
    curl_setopt($accountSummary, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/Stats/2/4611686018428678434/2305843009241542501/?modes=IronBanner');
    
    // https://www.bungie.net/Platform/Destiny/Stats/AggregateActivityStats/2/4611686018428911554/2305843009259744176/
    // 'https://www.bungie.net/Platform/Destiny/Stats/'.$consoleID.'/'.$membershipID.'/'.$characterId.'/?modes=TrialsOfOsiris');
    curl_setopt($accountSummary, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($accountSummary, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $apiKey));
    $getAccountSummary = curl_exec($accountSummary);
    $json2 = json_decode($getAccountSummary);
    
    $slotCount = count($json2->Response->data->activities);
    
    echo $getAccountSummary;
    // $i = 0;
    // $thisSlotHash = 0;
    
    //     for($i = 0; $hashToGet != $thisSlotHash; $i++){
            
    //         $thisSlotHash = $json2->Response->data->activities[$i]->activityHash;
    //         echo "<p>thisSlotHash: [",$i,"] ", $thisSlotHash;
    //     }
        
    //     $actualSlot = ($i - 1);
        
    // //get the values for correct activity    
    // $completions = $json2->Response->data->activities[$actualSlot]->values->activityCompletions->basic->displayValue;
    // $fastest = $json2->Response->data->activities[$actualSlot]->values->fastestCompletionSecondsForActivity->basic->displayValue;
    // $totalTime = $json2->Response->data->activities[$actualSlot]->values->activitySecondsPlayed->basic->displayValue;
    
    // echo "<p> slots: ", $actualSlot;
     
    
    
    // // echo "<P>comp: ", $completions;
    // // echo "<P>";
    // $valuesArr = array('completions: ' . $completions, 'fastest: ' . $fastest, 'totalTime: ' . $totalTime);
    // echo json_encode($valuesArr);
    
    
    
    
    // echo "Json: ", $getAccountSummary;
    
    
 
 ?>