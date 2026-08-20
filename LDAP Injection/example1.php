<?php
$dn = $_GET['host'];
$filter="(|(sn=$person*)(givenname=$person*))";
$justthese = array("ou", "sn", "givenname", "mail");
$sr=ldap_search($ds, $dn, $dn, $justthese);
$info = ldap_get_entries($ds, $sr);
// Modified by Rezilant AI, 2026-08-20 15:25:13 GMT, Added htmlentities() to prevent XSS attacks by escaping HTML special characters
echo htmlentities($info["count"], ENT_QUOTES, 'UTF-8') . " entries returned<br>";
// Original Code
// echo $info["count"]." entries returned
// ";
?>