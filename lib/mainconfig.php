<?php
error_reporting(0);

//data
require("config.php");

//proper installation checker
if ($cfg_baseurl == "enter_base_url") {
    header('Location: installer');
}

$cfg_mt = 0; // Maintenance? 1 = yes 0 = no
if ($cfg_mt == 1) {
    header("Location: " . $cfg_baseurl . "maintenance.html");
}

//DOMAIN FINDER
$cfg_baseurl_domain = $cfg_baseurl;


$cfg_baseurl_domain = trim($cfg_baseurl_domain, '/');

// If not have http:// or https:// then prepend it
if (!preg_match('#^http(s)?://#', $cfg_baseurl_domain)) {
    $cfg_baseurl_domain = 'http://' . $cfg_baseurl_domain;
}

$urlParts = parse_url($cfg_baseurl_domain);

// Remove www.
$domain_name = preg_replace('/^www./', '', $urlParts['host']);


// WEB
$email_webmail_forgot = "noreply@" . $domain_name;

// date & time
$date = date("Y-m-d");
$time = date("H:i:s");

// require
require("database.php");
require("function.php");

// TRIPAY
$tripay_merchant_code = "T3192";
$tripay_private_key = "gGhUr-5JlT4-CEGmx-Vgm11-X3q6n";
$tripay_api_key = "OsIgtKwRfGeGskG1QkxOpCz2mMRZaLpRkiemurLB";

function rupiah($angka)
{

    $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}