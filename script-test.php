<script>
   var apiKey = "b7139c21a2114d17b538c7a53ceff70d";
        // function test1(){
        //var apiKey = "b7139c21a2114d17b538c7a53ceff70d";
        
        //        document.getElementById("testArea").innerHTML = myObj.Response.data.membershipId;
        
        // xhr.open("GET", "https://www.bungie.net/Platform/Destiny/2/Stats/GetMembershipIdByDisplayName/wheels00769/", true);
        
        //1. Get membershipID
       var xhr = new XMLHttpRequest();
        
        xhr.open("GET", "https://www.bungie.net/Platform/Destiny/SearchDestinyPlayer/2/jeewwbacca/", true);
        xhr.setRequestHeader("X-API-Key", apiKey);

        xhr.onreadystatechange = function(){
            if(this.readyState === 4 && this.status === 200){
                var myObj = JSON.parse(this.responseText);
                
                console.log(myObj);
                console.log("Membership ID: ", myObj.Response[0].membershipId);
                var membershipID = myObj.Response[0].membershipId;
            }
        }
        xhr.send();
        
        //2.get summary based on membershipID
        
        var xhr = new XMLHttpRequest();
        
        xhr.open("GET", "https://www.bungie.net/Platform/Destiny/2/Account/,membershipID,/Summary/", true);
        xhr.setRequestHeader("X-API-Key", apiKey);

        xhr.onreadystatechange = function(){
            if(this.readyState === 4 && this.status === 200){
                var myObj = JSON.parse(this.responseText);
                
                console.log(myObj);
                // console.log("Membership ID: ", myObj.Response[0].membershipId);
            }
        }
        xhr.send();
        
        </script>
       