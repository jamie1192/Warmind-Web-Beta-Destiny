<?php

    session_start();
    
    include("head.php");
    include("key.php");
     
//      $xboxName2 = "DrearFlounder88";
     
    $sessionUsername = $_SESSION['user']['username'];
    $sessionConsoleID = $_SESSION['user']['consoleID'];
    $sessionMembershipID = $_SESSION['user']['membershipID'];
    // $sessionTitanSlot = $_SESSION['user']['titanSlot'];
    // $sessionHunterSlot = $_SESSION['user']['hunterSlot'];
    // $sessionWarlockSlot = $_SESSION['user']['warlockSlot'];
    
    $firstCharacterID = $_SESSION['user']['firstCharacterID'];
    $secondCharacterID = $_SESSION['user']['secondCharacterID'];
    $thirdCharacterID = $_SESSION['user']['thirdCharacterID'];
    // echo $firstCharacterID;
    
    $sessionFirstCharacter = $_SESSION['user']['firstCharacter'];
    $sessionSecondCharacter = $_SESSION['user']['secondCharacter'];
    $sessionThirdCharacter = $_SESSION['user']['thirdCharacter'];
    
    $firstCharacterEmblem = $_SESSION['user']['firstCharacterEmblem'];
    $secondCharacterEmblem = $_SESSION['user']['secondCharacterEmblem'];
    $thirdCharacterEmblem = $_SESSION['user']['thirdCharacterEmblem'];
    
    $firstCharacterBackground = $_SESSION['user']['firstCharacterBackground'];
    $secondCharacterBackground = $_SESSION['user']['secondCharacterBackground'];
    $thirdCharacterBackground = $_SESSION['user']['thirdCharacterBackground'];
     
    //  echo "first: ", $firstCharacterEmblem;

    $bungieURL = "https://bungie.net";
 
//  GET EMBLEMS FOR LOGGED IN USER

    $getEmblems = curl_init();
    curl_setopt($getEmblems, CURLOPT_URL, 'https://www.bungie.net/Platform/Destiny/'.$sessionConsoleID.'/Account/'.$sessionMembershipID.'/Summary/');
    curl_setopt($getEmblems, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($getEmblems, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $apiKey));
    $getEmblemsJSON = curl_exec($getEmblems);
    $getEmblemsResult = json_decode($getEmblemsJSON);

// END GET EMBLEMS
 
 
 
        
        
 
 $completeEmblemIcon = "$bungieURL$emblemPath";
 $completeEmblemBackground = "$bungieURL$emblemBackgroundPath";
 
 // echo "<p>emblem: ", $completeEmblemIcon;
 // echo "<p>background: ", $completeEmblemBackground;
 

//  $trialsKDRatio = $json2->Response->trialsOfOsiris->allTime->killsDeathsRatio->basic->displayValue;
//  $trialsTotalKills = $json2->Response->trialsOfOsiris->allTime->kills->basic->displayValue;
//  $trialsAverageKillsPerGame = $json2->Response->trialsOfOsiris->allTime->kills->pga->displayValue;
//  $trialsTotalDeaths = $json2->Response->trialsOfOsiris->allTime->deaths->basic->displayValue;
//  $trialsAverageDeathsPerGame = $json2->Response->trialsOfOsiris->allTime->deaths->pga->displayValue;
//  $trialsAverageLifespan = $json2->Response->trialsOfOsiris->allTime->averageLifespan->basic->displayValue;
//  $trialsWinLossRatio = $json2->Response->trialsOfOsiris->allTime->winLossRatio->basic->displayValue;
//  $trialsLongestKillSpree = $json2->Response->trialsOfOsiris->allTime->longestKillSpree->basic->displayValue;
 
 
 
//  $urlMissing2 = "https://bungie.net";
 

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
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://use.fontawesome.com/87ed5f0b78.js"></script>
    
    <link rel="stylesheet" href="/customMDLstyling.css">
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="/iconSelectRadio.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

 <html>
     <!--PASTE STARTS HERE-->
        <body>
          
          <!--submit post dialog-->
        
            <dialog class="mdl-dialog postDialog">
                <!--<h4 class="mdl-dialog__title">Submit LFG Post</h4>-->
                <!--mdl-color--homeBackground-->
                <div class="mdl-dialog__title" 
                style="padding: 24px 24px 24px;
                        font-size: 2.5rem;
                        color: white;">Submit LFG Post</div>
                    <div class="mdl-dialog__content">
                        <form id="submitPostForm" method="post" action="#">
                            <div class="class-selector lfgEmblemContainer">
                                
                                <input id="firstCharacter" type="radio" name="characterSlot" value="0" checked/>
                                <label class="classEmblems" for="firstCharacter">
                                    <img class="emblemIcons" src=<?php echo htmlspecialchars("$bungieURL$firstCharacterEmblem");?>>
                                </label>
                                
                                <?php if($_SESSION['user']['secondCharacterID'] != null){
                                    echo "<input id=\"secondCharacter\" type=\"radio\" name=\"characterSlot\" value=\"1\" />
                                    <label class=\"classEmblems\" for=\"secondCharacter\">
                                        <img class=\"emblemIcons\" src=";echo htmlspecialchars("$bungieURL$secondCharacterEmblem");
                                    echo "></label>";
                                }?>
                                <?php if($_SESSION['user']['thirdCharacterID'] != null){
                                    echo "<input id=\"thirdCharacter\" type=\"radio\" name=\"characterSlot\" value=\"2\" />
                                    <label class=\"classEmblems\"for=\"thirdCharacter\">
                                        <img class=\"emblemIcons\" src=";echo htmlspecialchars("$bungieURL$thirdCharacterEmblem");
                                    echo "></label>";
                                }?>
                                    
                                    
                                
                                <input type="hidden" name="className" id="lfgCharacterClass" value="<?php echo $sessionFirstCharacter;?>"/>
                                <input type="hidden" name="characterID" id="getCharacterID" value="<?php echo $firstCharacterID;?>"/>
                                
                            </div>
                            
                            <div class="class-selector emblemLabels">
                                <!--<div>-->
                                <label id="titanLabel" class="classEmblems" for="firstCharacter"><?php echo $sessionFirstCharacter; ?></label>
                                <!--</div>-->
                                <!--<div>-->
                                <?php if($_SESSION['user']['secondCharacterID'] != null){
                                    echo "<label id=\"hunterLabel\" class=\"classEmblems\" for=\"secondCharacter\">$sessionSecondCharacter</label>"
                                ;}?>
                                <!--</div>-->
                                <!--<div>-->
                                <?php if($_SESSION['user']['thirdCharacterID'] != null){
                                    echo "<label id=\"warlockLabel\" class=\"classEmblems\" for=\"thirdCharacter\">$sessionThirdCharacter</label>"
                                ;}?>
                                <!--</div>-->
                            </div>

                        
                            <!--Raid select list-->
                            <div class="mdl-select mdl-js-select mdl-select--floating-label Raid">
                                <select class="mdl-select__input" id="activitySelection" name="activitySelection">
                                    <!--<option value=""></option>-->
                                        <optgroup label="Raid - Wrath of the Machine">
                                            <option value="Wrath of the Machine - Heroic (Fresh)">Heroic (Fresh)</option>
                                            <option value="Wrath of the Machine - Heroic (Vosik)">Heroic (Vosik)</option>
                                            <option value="Wrath of the Machine - Heroic (Siege Engine)">Heroic (Siege Engine)</option>
                                            <option value="Wrath of the Machine - Heroic (Aksis Ph 2)">Heroic (Aksis Ph 2)</option>
                                            <option value="Wrath of the Machine - Heroic (Aksis Ph 1)">Heroic (Aksis Ph 1)</option>
                                            <option value="%">---</option>
                                            <option value="Wrath of the Machine - Normal (Fresh)">Normal (Fresh)</option>
                                            <option value="Wrath of the Machine - Normal (Vosik)">Normal (Vosik)</option>
                                            <option value="Wrath of the Machine - Normal (Siege Engine)">Normal (Siege Engine)</option>
                                            <option value="Wrath of the Machine - Normal (Aksis Ph 2)">Normal (Aksis Ph 2)</option>
                                            <option value="Wrath of the Machine - Normal (Aksis Ph 1)">Normal (Aksis Ph 1)</option>
                                        </optgroup>    
                                        <optgroup label="Raid - King's Fall">
                                            <option value="King's Fall - Heroic (Fresh)">Heroic (Fresh)</option>
                                            <option value="King's Fall - Heroic (Oryx)">Heroic (Oryx)</option>
                                            <option value="King's Fall - Heroic (Daughters)">Heroic (Daughters)</option>
                                            <option value="King's Fall - Heroic (Golgoroth)">Heroic (Golgoroth)</option>
                                            <option value="King's Fall - Heroic (Warpriest)">Heroic (Warpriest)</option>
                                            <option value="King's Fall - Heroic (Totems)">Heroic (Totems)</option>
                                            <option value="%">---</option>
                                            <option value="King's Fall - Normal (Fresh)">Normal (Fresh)</option>
                                            <option value="King's Fall - Normal (Oryx)">Normal (Oryx)</option>
                                            <option value="King's Fall - Normal (Daughters)">Normal (Daughters)</option>
                                            <option value="King's Fall - Normal (Golgoroth)">Normal (Golgoroth)</option>
                                            <option value="King's Fall - Normal (Warpriest)">Normal (Warpriest)</option>
                                            <option value="King's Fall - Normal (Totems)">Normal (Totems)</option>
                                        </optgroup>
                                        <optgroup label="Raid - Crota's End">
                                            <option value="Crota's End - Heroic (Fresh)">Heroic (Fresh)</option>
                                            <option value="Crota's End - Heroic (Crota)">Heroic (Crota)</option>
                                            <option value="Crota's End - Heroic (Deathsinger)">Heroic (Deathsinger)</option>
                                            <option value="Crota's End - Heroic (Thrallway)">Heroic (Thrallway)</option>
                                            <option value="Crota's End - Heroic (Bridge)">Heroic (Bridge)</option>
                                            <option value="%">---</option>
                                            <option value="Crota's End - Normal (Fresh)">Normal (Fresh)</option>
                                            <option value="Crota's End - Normal (Crota)">Normal (Crota)</option>
                                            <option value="Crota's End - Normal (Deathsinger)">Normal (Deathsinger)</option>
                                            <option value="Crota's End - Normal (Thrallway)">Normal (Thrallway)</option>
                                            <option value="Crota's End - Normal (Bridge)">Normal (Bridge)</option>
                                        </optgroup>
                                        <optgroup label="Raid - Vault of Glass">
                                            <option value="Vault of Glass - Heroic (Fresh)">Heroic (Fresh)</option>
                                            <option value="Vault of Glass - Heroic (Atheon)">Heroic (Atheon)</option>
                                            <option value="Vault of Glass - Heroic (Gatekeepers)">Heroic (Gatekeepers)</option>
                                            <option value="Vault of Glass - Heroic (Gorgons)">Heroic (Gorgons)</option>
                                            <option value="Vault of Glass - Heroic (Templar)">Heroic (Templar)</option>
                                            <option value="Vault of Glass - Heroic (Oracles)">Heroic (Oracles)</option>
                                            <option value="Vault of Glass - Heroic (Confluxes)">Heroic (Confluxes)</option>
                                            <option value="%">---</option>
                                            <option value="Vault of Glass - Normal (Fresh)">Normal (Fresh)</option>
                                            <option value="Vault of Glass - Normal (Atheon)">Normal (Atheon)</option>
                                            <option value="Vault of Glass - Normal (Gatekeepers)">Normal (Gatekeepers)</option>
                                            <option value="Vault of Glass - Normal (Gorgons)">Normal (Gorgons)</option>
                                            <option value="Vault of Glass - Normal (Templar)">Normal (Templar)</option>
                                            <option value="Vault of Glass - Normal (Oracles)">Normal (Oracles)</option>
                                            <option value="Vault of Glass - Normal (Confluxes)">Normal (Confluxes)</option>
                                        </optgroup>
                                        <optgroup label="Raid - Misc">
                                            <option value="Raid - Checkpoint Share">Checkpoint Share</option>
                                            <option value="Raid - Exploration">Exploration</option>
                                        </optgroup>
                                        
                                        <optgroup label="Trials of Osiris">
                                            <option value="Trials of Osiris (Casual/Bounty)">Trials of Osiris (Casual/Bounty)</option>
                                            <option value="Trials of Osiris (Competitive)">Trials of Osiris (Competitive)</option>
                                        </optgroup>
                                        <optgroup label="Iron Banner">
                                            <option value="Iron Banner">Iron Banner</option>
                                        </optgroup>
                                        
                                        <optgroup label="Crucible">
                                            <option value="Crucible - Private Match">Private Match</option>
                                            <option value="Crucible - Public Matchmaking">Public Match</option>
                                        </optgroup>
                                        <optgroup label="Strike Playlist">
                                            <option value="Strike Playlist - SIVA Crisis Heroic">SIVA Crisis Heroic</option>
                                            <option value="Strike Playlist - SIVA Crisis">SIVA Crisis</option>
                                            <option value="Strike Playlist - Taken War">Taken War</option>
                                            <option value="Strike Playlist - Vanguard Legacy">Vanguard Legacy</option>
                                        </optgroup>
                                        <optgroup label="Weeklies">
                                            <option value="Nightfall">Nightfall</option>
                                            <option value="Weekly Challenge of the Elders">Weekly Challenge of the Elders</option>
                                            <option value="Weekly Story Playlist">Weekly Story Playlist</option>
                                            <option value="Weekly Heroic Strike">Weekly Heroic Strike</option>
                                        </optgroup>
                                        <optgroup label="Arena">
                                            <option value="Arena - Archon's Forge">Archon's Forge</option>
                                            <option value="Arena - Court of Oryx">Court of Oryx</option>
                                            <option value="Arena - Challenge of the Elders">Challenge of the Elders</option>
                                            <option value="Arena - Prison of Elders">Prison of Elders</option>
                                        </optgroup>
                                </select>
                                <label class="mdl-select__label" for="activitySelection">Select an Activity</label>
                            </div>
                            
                            <input type="hidden" id="dropdownSelection" name="dropdownSelection" value="Raid - Wrath of the Machine"/>
                            
                            <div class="mdl-textfield mdl-textfield-custom mdl-js-textfield">
                                <textarea class="mdl-textfield__input" type="text" rows= "5" id="description" name="description" ></textarea>
                                <label class="mdl-textfield__label" for="description">Description</label>
                            </div>
                            
                            <!--Mic toggle-->
                            <div class="micDiv">
                                <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect hasMicToggle" for="micCheckbox">
                                    <input type="checkbox" id="micCheckbox" name="micCheckbox" class="mdl-checkbox__input">
                                    <span class="mdl-checkbox__label">Mic?</span>
                                </label>
                                <!--<label class="checkbox-inline hasMicToggle">-->
                                <!--    <input type="checkbox" id="micCheckbox" name="micCheckbox" value="">Mic?</label>-->
                            </div>
                            
                        <!--</form>-->
                    <!--</div>-->
                            <div class="mdl-dialog__actions">
                                <button type="submit" id="submitLFGpost" name="submit" class="mdl-button mdl-color--accent">Submit</button>
                                <!--<div class="mdl-spinner mdl-js-spinner is-active submitPostSpinner" id="submitPostLoading"></div>-->
                                <img class="submitPostLoading" id="submitPostLoading" src="assets/Rasputin-25px.png">
                                <button type="button" name="cancel" id="cancelLFGpost" class="mdl-button closeDialog cancelButton">Cancel</button>
                            </div>
                        
                        </form>
                    </div>
            </dialog>
            
            <div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
                <div class="mdl-snackbar__text"></div>
                <button class="mdl-snackbar__action" type="button"></button>
            </div> <!--End submit post dialog-->
        
            
            <!--Search player dialog-->
            <dialog class="mdl-dialog searchDialog">
                <!--<h4 class="mdl-dialog__title">Submit LFG Post</h4>-->
                <div class="mdl-dialog__title" 
                style="padding: 24px 24px 24px;
                        font-size: 2.5rem;
                        color: white;">Search Player</div>
                    <div class="mdl-dialog__content">
                        <form id="submitSearchForm" method="post" action="#">
                            

                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                <input class="mdl-textfield__input" type="text" id="sample3">
                                <label class="mdl-textfield__label " for="sample3">PSN Name/Xbox Gamertag..</label>
                            </div>

                            <div class="mdl-dialog__actions mdl-dialog__action--full-width">
                                    <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-1">
                                        <input type="radio" id="option-1" class="mdl-radio__button" name="options" value="1">
                                            <span class="mdl-radio__label">Xbox</span>
                                    </label>
                                    <div class="mdl-layout-spacer"></div>
                                    <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-2">
                                        <input type="radio" id="option-2" class="mdl-radio__button" name="options" value="2" checked>
                                            <span class="mdl-radio__label">PlayStation</span>
                                    </label>
                            </div>
                        
                            <div class="mdl-dialog__actions">
                                <button type="submit" id="submitLFGpost" name="submit" class="mdl-button mdl-button--accent mdl-button--raised">Submit</button>
                                <!--<div class="mdl-spinner mdl-js-spinner is-active submitPostSpinner" id="submitPostLoading"></div>-->
                                <button type="button" name="cancel" id="cancelLFGpost" class="mdl-button cancelButton closeSearchDialog">Cancel</button>
                            </div>
                        
                        </form>
                    </div>
            </dialog>
            <!--end player search-->
    
          
          
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
                    <!--<button id="submit-dialog" type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Submit</button>-->
                </nav>
            </div>

            <!-- Tab Container with Tab links -->
            <div class="mdl-layout__tab-bar mdl-js-ripple-effect darkColour">
                <!-- class is-active to show currently active tab -->
                <a href="#fixed-tab-1" class="mdl-layout__tab is-active">Raids</a>
                <a href="#fixed-tab-2" class="mdl-layout__tab">PVP</a>
                <a href="#fixed-tab-3" class="mdl-layout__tab">Strikes</a>
                <a href="#fixed-tab-4" class="mdl-layout__tab">Other</a>
                
            </div>
        </header>

        <!--            Proper MDL sidebar-->

        <div class="mdl-layout__drawer drawerStyling">
            
            
<!--            User account header-->
            <header class="demo-drawer-header">
                <?php 
                    if(isset($_SESSION['user'])){
                        
                        echo "<div class=\"iconTestBox\">";
                        echo "<img src=\"$bungieURL$firstCharacterEmblem\" class=\"demo-avatar titanEmblemIcon\">";
                        if($_SESSION['user']['secondCharacterID'] != null){
                            echo "<img src=\"$bungieURL$secondCharacterEmblem\" class=\"demo-avatar\">";
                        }
                        if($_SESSION['user']['thirdCharacterID'] != null){
                            echo "<img src=\"$bungieURL$thirdCharacterEmblem\" class=\"demo-avatar warlockEmblemIcon\">";
                        }
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
            <a class="mdl-navigation__link mdl-color-text--white" href="home.php">
                <i class="material-icons mdl-color-text--white" role="presentation">person_add</i>LFG Feed</a>
            <?php 
            if(isset($_SESSION['user'])){
                // echo "<a class=\"mdl-navigation__link mdl-color-text--white\" href=\"#\">";
                    // echo "<i class=\"material-icons mdl-color-text--white\" role=\"presentation\">chat </i>My Posts</a>";
                // echo "<a class=\"mdl-navigation__link mdl-color-text--white\" href=\"#\">";
                //     echo "<i class=\"material-icons mdl-color-text--white\" role=\"presentation\">assessment </i>My Stats</a>";
            }?>
            <!--<a class="mdl-navigation__link mdl-color-text--white" id="search-dialog" href="#">-->
            <!--    <i class="material-icons mdl-color-text--white" role="presentation">search</i>Search Player</a>-->
            <!--</div>-->
            <div class="mdl-layout-spacer"></div>
            <?php 
            if(isset($_SESSION['user'])){
                // echo "<a class=\"mdl-navigation__link mdl-color-text--white\" href=\"#\">";
                // echo "<i class=\"material-icons mdl-color-text--white\" role=\"presentation\">settings</i>Account</a>";
                
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
                    <img class="contentLoading" src="assets/Rasputin-25.png">
                        <!--<div class="mdl-grid">-->
                           <template id="raidPosts">
                                <div class="posts mdl-cell mdl-cell--1-offset-phone mdl-cell--6-col mdl-cell--2-offset-tablet">
                                <!--<div class="posts mdl-cell mdl-cell--6--phone mdl-cell--6-col-tablet mdl-cell--4-desktop">-->
                                    <div class="postCard mdl-card mdl-card--primary mdl-shadow--2dp">
                                        <div class="emblemContainer">
                                            <div class="emblemIcon">
                                                <img class="emblemIconImg">
                                            </div>
                                            <div class="emblemBackground">
                                                <img class="emblemBackgroundImg" src="">
                                            </div>
                                            <div class="playerUsername">
                                                <span class="playerUsernameOutput"></span>
                                                <img class="consoleIcon">
                                                
                                                
                                            </div>
                                            <div class="playerCurrentClass">
                                                <span class="playerClassOutput"></span>
                                                
                                            </div>
                                            
                                            
                                            <div class="rightSide">
                                                <div class="playerLightLevel"></div>
                                                <div class="playerGrimoire">
                                                    <span class="playerGrimoireOutput"></span>
                                                    <img class="grimoireImage">
                                                </div>
                                            </div>
                                        </div>
                                        <!--<div class="mdl-spinner mdl-js-spinner is-active getStatsLoading statsLoading"></div>-->
                                        <img class="getStatsLoading statsLoading" src="assets/Rasputin-25px.png">
                                        <div class="postActivity"><span class="postActivityText"></span>
                                            <div class="divider"></div>
                                        </div>
                                        <div class="postDescription">
                                            <i class="material-icons hasMic"></i>
                                            <span class="postDescriptionText"></span>
                                        </div>
                                        <span class="postAge"></span>
                                        <button class="btn btn-primary getStats" type="button"></button>
                                    </div>
                                
                                <div class="stats-row whiteText"></div>
                                    <template id="raidStats">
                                            <table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp trialsStatsRow postColour">
                                            <thead>
                                                <tr class="goldColour">
                                                    <th>Fastest Completion</th>
                                                    <th>Completions</th>
                                                    <th>Total Time Played</th>
                                                </tr>
                                            </thead>
                                                <tbody>
                                                     <!--Row 1 -->
                                                    <tr class="whiteText">
                                                        <td class="fastestCompletion"></td>
                                                        <td class="completionCount"></td>
                                                        <td class="totalTime"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                    </template>
                                </div> <!-- /posts mdl cell-6 -->
                            </template>
                        <!--template    -->
                            <div class="raidContainerTemplate allPostsTemplate mdl-grid">
                            
                            
                            </div>
                            
                             <!--Hard coded post-->
    
  
                            
                        <!--</div>-->
                        


                    </div> <!--/tab1container-->
                </div> <!-- /pagecontent-->
                <!--</div>-->
            </section> <!-- /fixed tab 1-->

            <section class="mdl-layout__tab-panel" id="fixed-tab-2">
                <div class="page-content">
                    <div class="tab2container">
                        
                        <img class="pvpContentLoading contentLoading" src="assets/Rasputin-25.png">
                        
                        <template id="pvpPosts">
                                <div class="posts mdl-cell mdl-cell--1-offset-phone mdl-cell--6-col mdl-cell--2-offset-tablet">
                                <!--<div class="posts mdl-cell mdl-cell--6--phone mdl-cell--6-col-tablet mdl-cell--4-desktop">-->
                                    <div class="postCard mdl-card mdl-card--primary mdl-shadow--2dp">
                                        <div class="emblemContainer">
                                            <div class="emblemIcon">
                                                <img class="emblemIconImg">
                                            </div>
                                            <div class="emblemBackground">
                                                <img class="emblemBackgroundImg" src="">
                                            </div>
                                            <div class="playerUsername">
                                                <span class="playerUsernameOutput"></span>
                                                <img class="consoleIcon">
                                                
                                                
                                            </div>
                                            <div class="playerCurrentClass">
                                                <span class="playerClassOutput"></span>
                                                
                                            </div>
                                            
                                            
                                            <div class="rightSide">
                                                <div class="playerLightLevel"></div>
                                                <div class="playerGrimoire">
                                                    <span class="playerGrimoireOutput"></span>
                                                    <img class="grimoireImage">
                                                </div>
                                            </div>
                                        </div>
                                        <!--<div class="mdl-spinner mdl-js-spinner is-active getStatsLoading statsLoading"></div>-->
                                        <img class="getStatsLoading statsLoading" src="assets/Rasputin-25px.png">
                                        <div class="postActivity"><span class="postActivityText"></span>
                                            <div class="divider"></div>
                                        </div>
                                        <div class="postDescription">
                                            <i class="material-icons hasMic"></i>
                                            <span class="postDescriptionText"></span>
                                        </div>
                                        <span class="postAge"></span>
                                        <button class="btn btn-primary getStats" type="button"></button>
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
                            </template>

                        <div class="pvpContainerTemplate allPostsTemplate mdl-grid">
                        
                        </div>
                    </div>
                </div>
            </section>

            <section class="mdl-layout__tab-panel" id="fixed-tab-3">
                <div class="page-content">
                    <div class="tab3container">
                        
                        <img class="strikesContentLoading contentLoading" src="assets/Rasputin-25.png">
                        
                        <template id="strikesPosts">
                                <div class="posts mdl-cell mdl-cell--1-offset-phone mdl-cell--6-col mdl-cell--2-offset-tablet">
                                <!--<div class="posts mdl-cell mdl-cell--6--phone mdl-cell--6-col-tablet mdl-cell--4-desktop">-->
                                    <div class="postCard mdl-card mdl-card--primary mdl-shadow--2dp">
                                        <div class="emblemContainer">
                                            <div class="emblemIcon">
                                                <img class="emblemIconImg">
                                            </div>
                                            <div class="emblemBackground">
                                                <img class="emblemBackgroundImg" src="">
                                            </div>
                                            <div class="playerUsername">
                                                <span class="playerUsernameOutput"></span>
                                                <img class="consoleIcon">
                                                
                                                
                                            </div>
                                            <div class="playerCurrentClass">
                                                <span class="playerClassOutput"></span>
                                                
                                            </div>
                                            
                                            
                                            <div class="rightSide">
                                                <div class="playerLightLevel"></div>
                                                <div class="playerGrimoire">
                                                    <span class="playerGrimoireOutput"></span>
                                                    <img class="grimoireImage">
                                                </div>
                                            </div>
                                        </div>
                                        <!--<div class="mdl-spinner mdl-js-spinner is-active getStatsLoading statsLoading"></div>-->
                                        <img class="getStatsLoading statsLoading" src="assets/Rasputin-25px.png">
                                        <div class="postActivity"><span class="postActivityText"></span>
                                            <div class="divider"></div>
                                        </div>
                                        <div class="postDescription">
                                            <i class="material-icons hasMic"></i>
                                            <span class="postDescriptionText"></span>
                                        </div>
                                        <span class="postAge"></span>
                                        <!--<button class="btn btn-primary getStats" type="button">Get Player Stats</button>-->
                                    </div>
                                
                                <!--<div class="stats-row whiteText"></div>-->
                                <!--    <template id="playerStats">-->
                                <!--            <table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp trialsStatsRow postColour">-->
                                <!--            <thead>-->
                                <!--                <tr class="goldColour">-->
                                <!--                    <th>K/D Ratio</th>-->
                                <!--                    <th>Average Lifespan</th>-->
                                <!--                    <th>Win/Loss Ratio</th>-->
                                <!--                </tr>-->
                                <!--            </thead>-->
                                <!--                <tbody>-->
                                                     <!--Row 1 -->
                                <!--                    <tr class="whiteText">-->
                                <!--                        <td class="playerKD"></td>-->
                                <!--                        <td class="playerAverageLifespan"></td>-->
                                <!--                        <td class="playerWinLossRatio"></td>-->
                                <!--                    </tr>-->
                                <!--                </tbody>-->
                                <!--            </table>-->
                                <!--    </template>-->
                                </div> <!-- /posts mdl cell-6 -->
                            </template>

                        <div class="strikesContainerTemplate allPostsTemplate mdl-grid">
                        
                        </div>
                        
                    </div>
                </div>
            </section>
            
            <section class="mdl-layout__tab-panel" id="fixed-tab-4">
                <div class="page-content">
                    <div class="tab4container">
                        
                        <img class="otherContentLoading contentLoading" src="assets/Rasputin-25.png">
                        
                        <template id="otherPosts">
                                <div class="posts mdl-cell mdl-cell--1-offset-phone mdl-cell--6-col mdl-cell--2-offset-tablet">
                                <!--<div class="posts mdl-cell mdl-cell--6--phone mdl-cell--6-col-tablet mdl-cell--4-desktop">-->
                                    <div class="postCard mdl-card mdl-card--primary mdl-shadow--2dp">
                                        <div class="emblemContainer">
                                            <div class="emblemIcon">
                                                <img class="emblemIconImg">
                                            </div>
                                            <div class="emblemBackground">
                                                <img class="emblemBackgroundImg" src="">
                                            </div>
                                            <div class="playerUsername">
                                                <span class="playerUsernameOutput"></span>
                                                <img class="consoleIcon">
                                                
                                                
                                            </div>
                                            <div class="playerCurrentClass">
                                                <span class="playerClassOutput"></span>
                                                
                                            </div>
                                            
                                            
                                            <div class="rightSide">
                                                <div class="playerLightLevel"></div>
                                                <div class="playerGrimoire">
                                                    <span class="playerGrimoireOutput"></span>
                                                    <img class="grimoireImage">
                                                </div>
                                            </div>
                                        </div>
                                        <!--<div class="mdl-spinner mdl-js-spinner is-active getStatsLoading statsLoading"></div>-->
                                        <img class="getStatsLoading statsLoading" src="assets/Rasputin-25px.png">
                                        <div class="postActivity"><span class="postActivityText"></span>
                                            <div class="divider"></div>
                                        </div>
                                        <div class="postDescription">
                                            <i class="material-icons hasMic"></i>
                                            <span class="postDescriptionText"></span>
                                        </div>
                                        <span class="postAge"></span>
                                        <!--<button class="btn btn-primary getStats" type="button">Get Player Stats</button>-->
                                    </div>
                                
                                <!--<div class="stats-row whiteText"></div>-->
                                <!--    <template id="playerStats">-->
                                <!--            <table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp trialsStatsRow postColour">-->
                                <!--            <thead>-->
                                <!--                <tr class="goldColour">-->
                                <!--                    <th>K/D Ratio</th>-->
                                <!--                    <th>Average Lifespan</th>-->
                                <!--                    <th>Win/Loss Ratio</th>-->
                                <!--                </tr>-->
                                <!--            </thead>-->
                                <!--                <tbody>-->
                                                     <!--Row 1 -->
                                <!--                    <tr class="whiteText">-->
                                <!--                        <td class="playerKD"></td>-->
                                <!--                        <td class="playerAverageLifespan"></td>-->
                                <!--                        <td class="playerWinLossRatio"></td>-->
                                <!--                    </tr>-->
                                <!--                </tbody>-->
                                <!--            </table>-->
                                <!--    </template>-->
                                </div> <!-- /posts mdl cell-6 -->
                            </template>

                        <div class="otherContainerTemplate allPostsTemplate mdl-grid">
                        
                        </div>
                        
                    </div>
                </div>
            </section>
        </main>
    </div>
  
  <script async>
    
    //load all posts, sort into tabs
    function loadPosts(){
        $('.contentLoading').show();
        $(".raidContainerTemplate").empty();
        $(".pvpContainerTemplate").empty();
        $(".strikesContainerTemplate").empty();
        $(".otherContainerTemplate").empty();
        var datasource = "ajax/getPostsData.php";

            $.ajax({
                url:datasource,
                dataType:'json',
                type:'POST',
                encode:true
            })
            .done(function(data){
                $('.contentLoading').hide();
                //if there is data
                if(data.length > 0){
                    var len = data.length;
                    console.log(len);
                    
                    
                    for(i=0;i<len;i++){
                        
                        //load LFG posts from db
                        var username = data[i].username;
                        var selectedCharacter = data[i].selectedCharacter;
                        var membershipID = data[i].membershipID;
                        var characterID = data[i].characterID;
                        var consoleID = data[i].consoleID;
                        var activity = data[i].activity;
                        var activityType = data[i].activityType;
                        var gameMode = data[i].activityType;
                        var description = data[i].description;
                        var emblemIcon = data[i].emblemIcon;
                        var emblemBackground = data[i].emblemBackground;
                        var lightLevel = data[i].lightLevel;
                        var grimoireScore = data[i].grimoireScore;
                        var hasMic = data[i].hasMic;
                        var postTimeD = data[i].ageD;
                        var postTimeH = data[i].ageH;
                        var postTimeM = data[i].ageM;
                        
                        var lightLevelIcon = "&#10022  ";
                        var grimoireImg = "./assets/grimoireIcon.png";
                        var buttonText = " Get Player Stats";
                        var postAge;
                        
                        //TODO xbox direct message
                        
                        //sorts all PvP posts into correct tab
                        if (((activity.toLowerCase().indexOf("crucible") >= 0) || (activity.toLowerCase().indexOf("iron") >= 0) || 
                        (activity.toLowerCase().indexOf("trials") >= 0))){
                            activityType = "pvp";
                        }
                        
                        var template = $('#'+activityType+'Posts').html().trim();
                        var clone = $(template);

                        if(postTimeD <= 0){
                            if(postTimeH <= 0){
                                if(postTimeM <= 0){
                                    postAge = "Just Now";
                                }
                                else if(postTimeM == 1){
                                    postAge = postTimeM + " min ago";
                                }
                                else{
                                    postAge = postTimeM + " mins ago";
                                }
                            }
                            else if(postTimeH == 1){
                                postAge = postTimeH + " hour ago"; 
                            }
                            else{
                                postAge = postTimeH + " hours ago";
                            }
                        }
                        else if(postTimeD == 1){
                            postAge = postTimeD + " day ago";
                        }
                        else{
                            postAge = postTimeD + " days ago";
                        }
                        // console.log("Row ", i, " D: ", postTimeD, " H: ",postTimeH, " M: ", postTimeM);
                       

                        if(consoleID == 1){
                          consoleChoice = "assets/xboxLogo.png"; //xbox icon
                        }
                        else if(consoleID == 2){
                          consoleChoice = "assets/psLogo.png"; //PS icon
                        }
                        
                        if(hasMic){
                          //var mic = "mic icon path"
                          var mic = "mic";
                        }
                        else{
                            var mic = "mic_off";
                        }
                
                
                        $(clone).find(".playerUsernameOutput").html(username);
                        $(clone).find(".playerClassOutput").html(selectedCharacter);

                        $(clone).find(".consoleIcon").attr("src", consoleChoice);
                        $(clone).find(".postActivityText").html(activity);
                        $(clone).find(".postDescriptionText").html(description);
                        $(clone).find(".emblemIconImg").attr("src", emblemIcon);
                        $(clone).find(".emblemBackgroundImg").attr("src", emblemBackground);
                        $(clone).find(".playerLightLevel").html(lightLevelIcon+lightLevel);
                        
                        $(clone).find(".grimoireImage").attr("src", grimoireImg);
                        $(clone).find(".playerGrimoireOutput").html(grimoireScore);
                        $(clone).find(".postAge").html(postAge);
                        
                        //button data for getting stats
                        var buttonText = "Player";
                        if (gameMode.toLowerCase().indexOf("crucible") >= 0){
                            buttonText = "Crucible"
                            $(clone).find(".getStats").html('Get '+buttonText+' Stats');
                        } 
                        else if(gameMode.toLowerCase().indexOf("iron") >= 0){
                            buttonText = "Iron Banner";
                            $(clone).find(".getStats").html("Get "+buttonText+" Stats");
                        } 
                        else if(gameMode.toLowerCase().indexOf("trials") >= 0){
                            buttonText = "Trials";
                            $(clone).find(".getStats").html("Get "+buttonText+" Stats");
                        }
                        else if(gameMode.toLowerCase().indexOf("raid") >= 0){
                            buttonText = "Raid";
                            $(clone).find(".getStats").html("Get "+buttonText+" Stats");
                        }
                        else{
                            $(clone).find(".getStats").html("Get "+buttonText+" Stats");
                        }
                        
                        $(clone).find(".getStats").attr("data-name", username);
                        $(clone).find(".getStats").attr("data-console", consoleID);
                        $(clone).find(".getStats").attr("data-activity", activity);
                        $(clone).find(".getStats").attr("data-character", selectedCharacter);
                        $(clone).find(".getStats").attr("data-characterID", characterID);
                        $(clone).find(".getStats").attr("data-membership-id", membershipID);
                        
                        $(clone).find(".hasMic").html(mic);
                        
                        $("."+activityType+"ContainerTemplate").append(clone);
                    }
                }
            });
            // componentHandler.upgradeDom();
          
        }
    
    //load posts from DB
    $(document).ready(function(){
        loadPosts();
        
        var characterCount = "<?php echo $thirdCharacterID;?>";
        
        if(characterCount == ""){
            $("#hunterLabel").removeAttr('style').css("margin-left","63px");
            $("#hunterLabel").css("margin-right","2px");
        }
    });
          
    setInterval("upgradeMDL();", 100);
    function upgradeMDL() {
        componentHandler.upgradeDom();
        componentHandler.upgradeAllRegistered();
    }

    
    
    //hide submit loader
    $('#submitPostLoading').hide();
    

    
    if ($('#submit-dialog').length){
        var dialog = document.querySelector('.postDialog');
        var showDialogButton = document.querySelector('#submit-dialog');
        if (!dialog.showModal) {
          dialogPolyfill.registerDialog(dialog);
        }
        showDialogButton.addEventListener('click', function() {
          dialog.showModal();
            $("#submitLFGpost").html('Submit');
            $("#submitLFGpost").attr("enabled", "true");
            $("#cancelLFGpost").show();
        });
        dialog.querySelector('.closeDialog').addEventListener('click', function() {
          dialog.close();
        });
    }
    
    if ($('#search-dialog').length){
        var dialog2 = document.querySelector('.searchDialog');
        var showDialogButton2 = document.querySelector('#search-dialog');
        if (!dialog2.showModal) {
          dialogPolyfill.registerDialog(dialog2);
        }
        showDialogButton2.addEventListener('click', function() {
          dialog2.showModal();
        });
        dialog2.querySelector('.closeSearchDialog').addEventListener('click', function() {
          dialog2.close();
        });
    }
    
  
    $('#activitySelection').on('change', function (){
        var label = $(this.options[this.selectedIndex]).closest('optgroup').prop('label');
        console.log(label);
        $('#dropdownSelection').attr("value", label);
    });
    
    
    //Submit LFG character radio select
    $('#firstCharacter').click(function(){
        $('#lfgCharacterClass').attr("value", '<?php echo $sessionFirstCharacter;?>');
        $('#getCharacterID').attr("value", '<?php echo $firstCharacterID;?>');
    });
    
    $('#secondCharacter').click(function(){
        $('#lfgCharacterClass').attr("value", '<?php echo $sessionSecondCharacter;?>');
        $('#getCharacterID').attr("value", '<?php echo $secondCharacterID;?>');
    
    });
    
    $('#thirdCharacter').click(function(){
        $('#lfgCharacterClass').attr("value", '<?php echo $sessionThirdCharacter;?>');
        $('#getCharacterID').attr("value", '<?php echo $thirdCharacterID;?>');

    });
    
    
    //Crucible/Trials/Iron Banana stats
    $('.pvpContainerTemplate').on("click", ".getStats", clickHandler2);

    var clicks = 0;
    function clickHandler2(e){
    
    var getActivity = $(e.target).data("activity");
        if($(e.target).attr("data-exists") == undefined){
            e.target;
            
            var getName = $(e.target).data("name");
            var getCharacter = $(e.target).data("character");
            var getConsole = $(e.target).data("console");
            var getCharacterID = $(e.target).data("characterid");
            var getActivity = $(e.target).data("activity");
            var getMembershipID = $(e.target).data("membership-id");
            var datasource = "./ajax/getPlayerStats.php";
            
            if(getName != undefined){
                $(e.target).siblings('.statsLoading').show();
                clickedBtn = $(e.target).parents(".getStats");
                $(e.target).html("Retrieving Stats..");
                $(e.target).attr("data-exists", "1");
            }
            else{
                $(e.target).html("Error: Can't find player!");
                $(e.target).removeClass("btn-primary");
                $(e.target).addClass("btn-danger");
                // $(e.target).attr("data-exists", null);
            }
    

            var obj = {name: getName, character:getCharacter, console:getConsole,
            characterID: getCharacterID, activity: getActivity, membershipID: getMembershipID};
                  
                  $.ajax({
                      data:obj, 
                      datatype: 'json',
                      timeout: 6000,
                      url:datasource,
                      type: 'POST',
                      encode: true
                  })
                  .done(function(data){
                    //if there is data

                    $('.statsLoading').hide();
                    if (getActivity.toLowerCase().indexOf("crucible") >= 0){
                            buttonText = "Crucible"
                        } 
                        else if(getActivity.toLowerCase().indexOf("iron") >= 0){
                            buttonText = "Iron Banner";
                        } 
                        else if(getActivity.toLowerCase().indexOf("trials") >= 0){
                            buttonText = "Trials";
                        }
                        else if(getActivity.toLowerCase().indexOf("raid") >= 0){
                            buttonText = "Raid";
                        }
                        else{
                            buttonText = "";
                        }
                    $(e.target).html("Hide "+buttonText+" Stats");
                    
                    // alert(data);
                    var jsonResponse = JSON.parse(data);

                    var kdRatio = jsonResponse.kdRatio;
                    var averageLifeSpan = jsonResponse.avgLifeSpan;
                    var winLossRatio = jsonResponse.winLossRatio;
 
                    if(kdRatio == null){
                        console.log("ERROR");
                        $(e.target).html('Error: No stats found');
                        $(e.target).removeClass("btn-primary");
                        $(e.target).addClass("btn-danger");
                        $(e.target).attr("data-exists", null);
                        
                    }
                    else if(averageLifeSpan == null){
                        console.log("ERROR");
                        $(e.target).html('Error: No stats found');
                        $(e.target).removeClass("btn-primary");
                        $(e.target).addClass("btn-danger");
                        $(e.target).attr("data-exists", null);
                        
                    }
                    else if(winLossRatio == null){
                        console.log("ERROR");
                        $(e.target).html('Error: No stats found');
                        $(e.target).removeClass("btn-primary");
                        $(e.target).addClass("btn-danger");
                        $(e.target).attr("data-exists", null);
                    }
                    else{
                        clicks++;
    
                        var template = $("#playerStats").html().trim();
                        var clone = $(template);

                        //output retrieved stats
                        console.log("lifespan: ", averageLifeSpan);
                        $(clone).find(".playerKD").html(kdRatio);
                        $(clone).find(".playerAverageLifespan").html(averageLifeSpan);
                        $(clone).find(".playerWinLossRatio").html(winLossRatio);
    
                        $(e.target).parents(".postCard").siblings(".stats-row").append(clone);
                    }
                    
                  })
                  .fail(function(){
                        console.log("ERROR- timeout");
                        $('.statsLoading').hide();
                        $(e.target).html('Error: Timed Out');
                        $(e.target).removeClass("btn-primary");
                        $(e.target).addClass("btn-danger");
                        $(e.target).attr("data-exists", null);
                  })
            
    
        }else if($(e.target).attr("data-exists") == 1){
            
            $(e.target).parents(".postCard").siblings(".stats-row").css("display", "none");
            $(e.target).html("Show "+buttonText+" Stats");
            $(e.target).attr("data-exists", "0");
    
        }else if($(e.target).attr("data-exists") == "0"){
            $(e.target).html("Hide "+buttonText+" Stats");
            $(e.target).parents(".postCard").siblings(".stats-row").css("display", "");
            $(e.target).attr("data-exists", "1");
        }
      
      
    } //clickHandler
    
    //Raid stats
    //TODO extra tableRow for account-wide stats(?)
    $('.raidContainerTemplate').on("click", ".getStats", clickHandler);

    var raidClicks = 0;
    function clickHandler(e){
    
        if($(e.target).attr("data-exists") == undefined){
            e.target;
            
            
            var getName = $(e.target).data("name");
            var getCharacter = $(e.target).data("character");
            var getConsole = $(e.target).data("console");
            var getCharacterID = $(e.target).data("characterid");
            var getActivity = $(e.target).data("activity");
            var getMembershipID = $(e.target).data("membership-id");

            var datasource = "./ajax/getRaidStats.php";
            
            if(getName != undefined){
                $(e.target).siblings('.statsLoading').show();
                clickedBtn = $(e.target).parents(".getStats");
                $(e.target).html("Retrieving Stats..");
                $(e.target).attr("data-exists", "1");
            }
            else{
                $(e.target).html("Error: Can't find player!");
                $(e.target).removeClass("btn-primary");
                $(e.target).addClass("btn-danger");
            }
    
            
            var obj = {name: getName, character:getCharacter, console:getConsole,
            characterID: getCharacterID, activity: getActivity, membershipID: getMembershipID};

                  $.ajax({
                      data:obj, 
                      datatype: 'json',
                      timeout: 6000,
                      url:datasource,
                      type: 'POST',
                      encode: true
                  })
                  .done(function(data2){
                    $('.statsLoading').hide();
                    $(e.target).html("Hide Stats");
                    

                    var jsonResponse2 = JSON.parse(data2);

                    if(typeof jsonResponse2.completions === "undefined"){
                        console.log("ERROR");
                        $(e.target).html('Error: No stats found');
                        $(e.target).removeClass("btn-primary");
                        $(e.target).addClass("btn-danger");
                        $(e.target).attr("data-exists", null);
                        
                    }
                    else if(typeof jsonResponse2.fastest === "undefined"){
                        console.log("ERROR");
                        $(e.target).html('Error: No stats found');
                        $(e.target).removeClass("btn-primary");
                        $(e.target).addClass("btn-danger");
                        $(e.target).attr("data-exists", null);
                    }
                    else if(typeof jsonResponse2.totalTime === "undefined"){
                        console.log("ERROR");
                        $(e.target).html('Error: No stats found');
                        $(e.target).removeClass("btn-primary");
                        $(e.target).addClass("btn-danger");
                        $(e.target).attr("data-exists", null);
                    }
                    else{
                        raidClicks++;
    
                        var template = $("#raidStats").html().trim();
                        var clone = $(template);
 
                        var fastestCompletion = jsonResponse2.fastest;
                        console.log("fast: ", fastestCompletion);
                        var completionCount = jsonResponse2.completions;
                        var totalTime = jsonResponse2.totalTime;
    
                        $(clone).find(".fastestCompletion").html(fastestCompletion);
                        $(clone).find(".completionCount").html(completionCount);
                        $(clone).find(".totalTime").html(totalTime);

    
                        $(e.target).parents(".postCard").siblings(".stats-row").append(clone);
    
                    }
                    
                  })
                  .fail(function(){
                      console.log("ERROR- timeout");
                        $('.statsLoading').hide();
                        $(e.target).html('Error: Timed Out');
                        $(e.target).removeClass("btn-primary");
                        $(e.target).addClass("btn-danger");
                        $(e.target).attr("data-exists", null);
                  })
            
    
        }else if($(e.target).attr("data-exists") == 1){
            
            $(e.target).parents(".postCard").siblings(".stats-row").css("display", "none");
            $(e.target).html("Show Raid Stats");
            $(e.target).attr("data-exists", "0");
    
        }else if($(e.target).attr("data-exists") == "0"){
            $(e.target).html("Hide Stats");
            $(e.target).parents(".postCard").siblings(".stats-row").css("display", "");
            $(e.target).attr("data-exists", "1");
        }
      
      
    } //clickHandler, raidContainerTemplate
    
    
    
    function showLoading() {
        console.log("showLoading fired");
        // remove existing loaders
        $('.loading-container').remove();
        $('<div id="orrsLoader" class="loading-container"><div><div class="mdl-spinner mdl-js-spinner is-active"></div></div></div>').appendTo("body");
    
        componentHandler.upgradeElements($('.mdl-spinner').get());
        setTimeout(function () {
            $('#orrsLoader').css({opacity: 1});
        }, 1);
    }
    
    function hideLoading() {
    $('#orrsLoader').css({opacity: 0});
    setTimeout(function () {
        $('#orrsLoader').remove();
    }, 400);
}
    
  
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
        $("#submitLFGpost").attr("enabled", "false");
        $("#cancelLFGpost").hide();
        
        $.ajax({
            type:"POST",
            url: submitPHP,
            timeout: 8000,
            data: $("#submitPostForm").serialize()
        })
            .done(function(data){
 
                $('#submitPostLoading').show();
                dialog.close();
                
                var notification = document.querySelector('.mdl-js-snackbar');
                notification.MaterialSnackbar.showSnackbar({
                    message: 'Post Submitted!'
                });
                
                $('#submitPostLoading').hide();
                loadPosts();
                upgradeMDL();
            })
            .fail(function(){
                $("#submitLFGpost").html('Error submitting post!');
            });
            
            
            
        // );
        
        e.preventDefault();
    });
    
    //Submit player search
      $("#submitSearchForm").submit(function(e){
        
        // showLoading();
        setTimeout(function () {
            hideLoading();
        }, 3000);
        
        $('#submitPostLoading').show();
        // <button id='btnAddProfile' type='button'>Add</button>
        $("#submitLFGpost").html('Submitting');
        
        var submitPHP = "ajax/searchResults.php";
        
        
        //disable buttons on submit
        $("#submitLFGpost").attr("enabled", "false");
        $("#cancelLFGpost").hide();
        
        $.ajax({
            type:"POST",
            url: submitPHP,
            timeout: 8000,
            data: $("#submitSearchForm").serialize()
        })
            .done(function(data){
 
                $('#submitPostLoading').show();
                dialog.close();
                
                var notification = document.querySelector('.mdl-js-snackbar');
                notification.MaterialSnackbar.showSnackbar({
                    message: 'Found Player!'
                });
                
                $('#submitPostLoading').hide();
                loadPosts();
                upgradeMDL();
            })
            .fail(function(){
                $("#submitLFGpost").html('Error submitting post!');
            });
            
            
            
        // );
        
        e.preventDefault();
    });
     
      
    
    
  </script>
  
  
  
<!--ENDS HERE-->


    
 </body>
 
</html>