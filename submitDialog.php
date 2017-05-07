<?php

    include("head.php");
    session_start();
    
    $titanEmblemPath = $_SESSION["titanArray"];
    // echo $titanEmblemPath;
    $hunterEmblemPath = $_SESSION["hunterArray"];
    $warlockEmblemPath = $_SESSION["warlockArray"];
//  array_push($_SESSION['hunterEmblem'],$hunterEmblem);
//  array_push($_SESSION['warlockEmblem'],$warlockEmblem);
    $bungieURL = "https://bungie.net";
    
?>

<!doctype html>
<html>
    <body>
        <body>
            <button id="show-dialog" type="button" class="mdl-button mdl-color--accent">Show Dialog</button>
            <dialog class="mdl-dialog postDialog">
                <!--<h4 class="mdl-dialog__title">Submit LFG Post</h4>-->
                <div class="mdl-dialog__title mdl-color--homeBackground" 
                style="padding: 24px 24px 24px;
                        font-size: 2.5rem;
                        color: white;">Submit LFG Post</div>
                    <div class="mdl-dialog__content">
                       
                        <form id="submitPostForm" action="#">
      <!-- Right aligned menu below button -->

                        <!--<div class="mdl-dialog__actions mdl-dialog__action--full-width">-->
                        <!--    <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-1">-->
                        <!--        <input type="radio" id="option-1" class="mdl-radio__button" name="options" value="1" checked>-->
                        <!--    <span class="mdl-radio__label">Titan</span>-->
                        <!--    </label>-->
                        <!--<div class="mdl-layout-spacer"></div>-->
                        <!--    <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-2">-->
                        <!--        <input type="radio" id="option-2" class="mdl-radio__button" name="options" value="2">-->
                        <!--    <span class="mdl-radio__label">Hunter</span>-->
                        <!--    </label>-->
                        <!--<div class="mdl-layout-spacer"></div>-->
                        <!--    <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-3">-->
                        <!--        <input type="radio" id="option-2" class="mdl-radio__button" name="options" value="3">-->
                        <!--    <span class="mdl-radio__label">Warlock</span>-->
                        <!--    </label>-->
                        
                        <!--</div>-->
                        <!--<form>-->
    <!--<p>Previously:</p>-->
    <!--<div>-->
    <!--    <input id="a1" type="radio" name="a" value="visa" />-->
    <!--    <label for="a1">Visa</label><br/>-->
    <!--    <input id="a2" type="radio" name="a" value="mastercard" />-->
    <!--    <label for="a2">Mastercard</label>-->
    <!--</div>-->
    <!--<p>Now, with CSS3: </p>-->
                            <div class="cc-selector lfgEmblemContainer">
                                <input id="titan" type="radio" name="credit-card" value="0" checked/>
                                <label class="drinkcard-cc visa" for="titan">
                                    <img class="emblemIcons" src=<?php echo "$bungieURL$titanEmblemPath";?>>
                                </label>
                                
                                <input id="hunter" type="radio" name="credit-card" value="1" />
                                <label class="drinkcard-cc mastercard"for="hunter">
                                    <img class="emblemIcons" src=<?php echo "$bungieURL$hunterEmblemPath";?>>
                                </label>
                                <input id="warlock" type="radio" name="credit-card" value="2" />
                                <label class="drinkcard-cc mastercard"for="warlock">
                                    <img class="emblemIcons" src=<?php echo "$bungieURL$warlockEmblemPath";?>>
                                </label>
                            </div>
                            
                            <div class="emblemLabels">
                                <!--<div>-->
                                <label id="titanLabel" class="drinkcard-cc " for="titan">Titan</label>
                                <!--</div>-->
                                <!--<div>-->
                                <label id="hunterLabel" class="drinkcard-cc " for="hunter">Hunter</label>
                                <!--</div>-->
                                <!--<div>-->
                                <label id="warlockLabel" class="drinkcard-cc " for="warlock">Warlock</label>
                                <!--</div>-->
                            </div>
<!--</form>-->
                        <!--<div class="mdl-layout-spacer"></div>-->
                            <!--<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-3">-->
                            <!--    <input type="radio" id="option-2" class="mdl-radio__button" name="options" value="3">-->
                            <!--<span class="mdl-radio__label">Warlock</span>-->
                            <!--</label>-->
                        <!--</div>-->
                        <!--<form action="#">-->
                            <div class="mdl-select mdl-js-select mdl-select--floating-label">
                                <select class="mdl-select__input" id="professsion" name="professsion">
                                    <option value=""></option>
                                    <option value="option1">option 1</option>
                                    <option value="option2">option 2</option>
                                    <option value="option3">option 3</option>
                                    <option value="option4">option 4</option>
                                    <option value="option5">option 5</option>
                                </select>
                                <label class="mdl-select__label" for="professsion">Select an Activity</label>
                            </div>
                        <!--</form>-->
    
        
                            <div class="mdl-textfield mdl-textfield-custom mdl-js-textfield">
                                <textarea class="mdl-textfield__input" type="text" rows= "5" id="sample5" ></textarea>
                                <label class="mdl-textfield__label" for="sample5">Description</label>
                            </div>
                        </form>
                    </div>
                <div class="mdl-dialog__actions">
                    <button type="button" class="mdl-button">Agree</button>
                    <button type="button" class="mdl-button close">Disagree</button>
                </div>
            </dialog>
    
    
    <script>
    var dialog = document.querySelector('dialog');
    var showDialogButton = document.querySelector('#show-dialog');
    if (! dialog.showModal) {
      dialogPolyfill.registerDialog(dialog);
    }
    showDialogButton.addEventListener('click', function() {
      dialog.showModal();
    });
    dialog.querySelector('.close').addEventListener('click', function() {
      dialog.close();
    });
    
    
      
    </script>
</body>
</html>


