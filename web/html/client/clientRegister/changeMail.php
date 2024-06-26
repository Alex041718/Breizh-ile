<?php


setcookie('token', '', -1, '/'); 
setcookie('account', '', -1, '/'); 
header("Location: /client/register");