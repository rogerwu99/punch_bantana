<?php
    include("Mobile_Detect.php");
    $detect = new Mobile_Detect();
    
    if ($detect->isAndroid()) {
        // code to run for the Google Android platform
    }
    
    if ($detect->isIphone()) {
        // code to run for iPhone
    }    
    
    if ($detect->isMobile()) {
        // any mobile platform
    }
