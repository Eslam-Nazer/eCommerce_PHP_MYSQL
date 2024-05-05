<?php

function language($phrase){
    static $lang = [
        "ADMIN"   => "Administrator",
        // Dashboard Words
        "ADMIN_HOME"    => "Admin Area" ,
        "CATEGORIES"    => "Categories" ,
        "ITEMS"         => "Items" ,
        "MEMBERS"       => "Members" ,
        "STATISTICS"    => "Statistics" ,
        "LOGS"          => "Logs" ,
        "COMMENTS"      => "Comments",
        "" => "" ,


    ];
    return $lang[$phrase];
}