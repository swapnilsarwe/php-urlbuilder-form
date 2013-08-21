<?php
require_once 'http_build_url.php';
require_once 'class.urlbuilder.php';
$action = (isset($_POST['action'])) ? $_POST['action'] : '';
UrlBuilder::Create()->processRequest($action);