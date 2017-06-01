<!DOCTYPE html>

<html>
    <body>
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
                    
                </nav>
            </div>

            <!-- Tab Container with Tab links -->
            <div class="mdl-layout__tab-bar mdl-js-ripple-effect darkColour">
                <!-- class is-active to show currently active tab -->
            <!--    <a href="#fixed-tab-1" class="mdl-layout__tab is-active">Raids</a>-->
            <!--    <a href="#fixed-tab-2" class="mdl-layout__tab">PVP</a>-->
            <!--    <a href="#fixed-tab-3" class="mdl-layout__tab">Strikes</a>-->
            <!--    <a href="#fixed-tab-4" class="mdl-layout__tab">Other</a>-->
                
            </div>
        </header>
        
        <!--//menu sidebar-->
        
        <div class="mdl-layout__drawer drawerStyling">
            
            
<!--            User account header-->
            <header class="demo-drawer-header">
                
                <img src="assets/Warmind Alpha.png" class="headerLogo">
                    <div class="demo-avatar-dropdown">
                        <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="accbtn">
                            <li class="mdl-menu__item">Titan</li>
                            <li class="mdl-menu__item">Hunter</li>
                            <li class="mdl-menu__item">Warlock</li>
                        </ul>
                    </div>
            </header>  
        <nav class="demo-navigation mdl-navigation navStyling">
            <a class="mdl-navigation__link mdl-color-text--white" href="home.php">
                <i class="material-icons mdl-color-text--white" role="presentation">person_add</i>LFG Feed</a>
            <div class="mdl-layout-spacer"></div>
                <a class="mdl-navigation__link mdl-color-text--white" href="login.php">
                <i class="material-icons mdl-color-text--white" role="presentation">account_circle</i>Log In</a>
        </nav>
<!--            End sidebar-->
            
            
        </div>
        
    </body>
</html>