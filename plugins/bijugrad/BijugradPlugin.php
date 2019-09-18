<?php

/**
 * Plugin Name: Bijugrad
 * Version: 1.0
 * Author: Raxkor
 * Author uri: https://t.me/drKeinakh
 */

require_once "includes/functions.php";
require_once "Bijugrad.php";

function bg()
{
    return Bijugrad::getInstance();
}

bg();