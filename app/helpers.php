<?php 

function sanitize($dirty)
{
    return htmlentities(trim($dirty),ENT_QUOTES,'UTF-8');
}

function currentCustomer()
{
    return auth()->guard('customer')->user();
}

function currentAdmin()
{
    return auth()->guard('admin')->user();
}