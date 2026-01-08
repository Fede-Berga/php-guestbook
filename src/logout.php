<?php
require_once 'Auth.php';
session_start();
Auth::logout();
header('Location: index.php');
exit;
