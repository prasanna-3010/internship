<?php
$dob = htmlspecialchars($_GET["dob"] ?? "");
$contact = htmlspecialchars($_GET["contact"] ?? "");
$age = htmlspecialchars($_GET["age"] ?? "");

include "details.html";
?>
