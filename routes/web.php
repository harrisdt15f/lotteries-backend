<?php

if (defined('ADMIN')) {
    include_once ("web_admin.php");
} elseif (defined('PARTNER')) {
    include_once("web_partner.php");
} else {
    include_once ("web_player.php");
}