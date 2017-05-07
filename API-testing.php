<?php
        $apiKey = 'b7139c21a2114d17b538c7a53ceff70d';
 
         $ch = curl_init();
         // curl_setopt($ch, CURLOPT_URL, 'https://www.bungie.net/platform/Destiny/Manifest/InventoryItem/1274330687/');
         curl_setopt($ch, CURLOPT_URL, 'http://www.bungie.net/Platform/Destiny/2/Stats/GetMembershipIdByDisplayName/wheels00769/');
         // curl_setopt($ch, CURLOPT_URL, 'http://www.bungie.net/Platform/Destiny/1/Account/4588817/Summary/');
         //http://www.bungie.net/Platform/Destiny/{membershipType}/Account/{destinyMembershipId}/Summary/
         //4588817
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $apiKey));

         $json = json_decode(curl_exec($ch));
         echo $json->Response->ErrorCode;//->data->inventoryItem->itemName;//;//->ErrorCode;
         //->Response->data;
         //->inventoryItem->itemName; 
         //Gjallarhorn
        
        ?>
        
        

