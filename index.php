<?php
require_once 'http_build_url.php';
require_once 'class.urlbuilder.php';
$action = (isset($_GET['action'])) ? $_GET['action'] : '';
UrlBuilder::Create()->processRequest($action);