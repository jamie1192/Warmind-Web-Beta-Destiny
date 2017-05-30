<?php

    include("./../key.php");
    include("raidHashes.php");
    
    // $playerName = $_POST['name'];
    // $selectedCharacter = $_POST['character'];
    $consoleID = 2;
    $activity = "Wrath of the Machine - Heroic";
    // $characterID = $_POST['characterID'];
    $characterID = 2305843009251928979;
    
    $membershipID = 4611686018437514161;
    
    echo $membershipID;
    echo $characterID;
    //ben
    // $membershipID = "4611686018439307322";
    
    //webby
    // $membershipID = "4611686018437514161";
    // $membershipID = $_POST['membershipID'];
    
    $hashToGet = 0;

        if (strpos($activity, 'Wrath') !== false) {
            if (strpos($activity, 'Heroic') !== false) {
                $hashToGet = $wotmH;
                // $hashToGet = $vogN;
                echo "asda";
                echo $hashToGet;
            }
            else{
                $hashToGet = $wotmN;
            }
        
            // echo "<p>inside: ", $hashToGet;
            
        }
        else if (strpos($activity, 'Vault') !== false) {
            if (strpos($activity, 'Heroic') !== false) {
                $hashToGet = $vogH;
            }
            else{
                $hashToGet = $vogN;
            }
        
            // echo "<p>inside: VoG ", $hashToGet;
            
        }
        else if (strpos($activity, 'King') !== false) {
            if (strpos($activity, 'Heroic') !== false) {
                $hashToGet = $kfH;
            }
            else{
                $hashToGet = $kfN;
            }
        
            // echo "<p>inside: ", $hashToGet;
            
        }
        else if (strpos($activity, 'Crota') !== false) {
            if (strpos($activity, 'Heroic') !== false) {
                $hashToGet = $ceH;
            }
            else{
                $hashToGet = $ceN;
            }
        
            // echo "<p>inside: ", $hashToGet;
            
        }
        // else if((strpos($activityStr, 'Weeklies') !== false) || (strpos($activityStr, 'Strike') !== false)){
        //     $activityType = "strikes";
        //     // echo 'strikes';
        // }
        // else if((strpos($activityStr, 'Arena') !== false) || (strpos($activityStr, 'Patrol') !== false)){
        //     $activityType = "other";
        //     // echo 'other';
        // }





    // //TESTING BELOW- Trials stats
    $accountSummary = curl_init();
    
    //ALL TIME STATS HERE
    //  curl_setopt($accountSummary, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/Stats/'.$consoleID.'/'.$membershipID.'/'.$characterId.'/?modes=TrialsOfOsiris');
    curl_setopt($accountSummary, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/Stats/AggregateActivityStats/2/4611686018437514161/2305843009251928979/');
    curl_setopt($accountSummary, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($accountSummary, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $apiKey));
    $getAccountSummary = curl_exec($accountSummary);
    $json2 = json_decode($getAccountSummary);
    
    echo $getAccountSummary;
    
    
    // // $slotCount = count($json2->Response->data->activities);
    
    
    // $i = 0;
    // $thisSlotHash = 0;
    
    //     for($i = 0; $hashToGet != $thisSlotHash; $i++){
            
    //         $thisSlotHash = $json2->Response->data->activities[$i]->activityHash;
    //         // echo "<p>thisSlotHash: [",$i,"] ", $thisSlotHash;
    //     }
        
    //     $actualSlot = ($i - 1);
        
    // //get the values for correct activity    
    // $completions = $json2->Response->data->activities[$actualSlot]->values->activityCompletions->basic->displayValue;
    // $fastest = $json2->Response->data->activities[$actualSlot]->values->fastestCompletionSecondsForActivity->basic->displayValue;
    // $totalTime = $json2->Response->data->activities[$actualSlot]->values->activitySecondsPlayed->basic->displayValue;
    
    // // echo "<p> slots: ", $actualSlot;
     
    
    
    // // echo "<P>comp: ", $completions;
    // // echo "<P>";
    // // $valuesArr = array('completions: ' . $completions, 'fastest: ' . $fastest, 'totalTime: ' . $totalTime);
    // $valuesArr = array("completions" => $completions, "fastest" => $fastest, "totalTime" => $totalTime);
    // // echo $valuesArr;
    
    // echo json_encode($valuesArr);
    // // echo $valuesArr["completions"];
    // // echo $getAccountSummary;

?>