<?php

function ordinal($number){
    $ends = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
    if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
        return $number.'th';
    } else {
        return $number.$ends[$number % 10];
    }
}


function available(){
    return 1;
}

function occupied(){
    return 2;
}

function reserved(){
    return 3;
}

function maintenance(){
    return 4;
}

function unavailable(){
    return 5;
}

function selectedInKiosk(){
    return 6;
}

function uncleaned(){
    return 7;
}

function cleaning(){
    return 8;
}
// 
function branch_admin()
{
    return 1;
}

function front_desk()
{
    return 2;
}

function kiosk()
{
    return 3;
}

function kitchen()
{
    return 4;
}

function room_boy()
{
    return 5;
}

function super_admin()
{
    return 6;
}

