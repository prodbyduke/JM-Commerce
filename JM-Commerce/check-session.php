<?php

function check_session()
{
    if (!isset($_SESSION)) {
        session_start();
        return false;
    }
    return true;
}

function check_cookie()
{
    if (!isset($_COOKIE["user"])) {
        setcookie("user", "guest", time() + (86400 * 30));
        return false;
    } elseif (!isset($_COOKIE["cart"])) {
        return false;
    }
    return true;
}

function is_logged()
{
    if (!isset($_COOKIE["user"]) || $_COOKIE["user"] == "guest") {
        return false;
    }
    return true;
}