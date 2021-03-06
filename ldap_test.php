<?php
function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}

function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
}

function print_ldap_info($ldap_id) {
    $ds = ldap_connect("ldap.iitb.ac.in") or die("Unable to connect to LDAP server. Please try again later.");
    $sr = ldap_search($ds, "dc=iitb,dc=ac,dc=in", "(uid=$ldap_id)");
    $info = ldap_get_entries($ds, $sr);

    $a['prof_name'] = $info[0]['cn'][0]; 
    $str = explode(",",$info[0]['dn'])[2];
    $a['department'] = substr($str, (strrpos($str, "="))+1);
    
    var_dump($a);
    
//    $l_id = $info[0]['dn'];
//    $l_id_arr = explode(",",$l_id);
//    $user_is_faculty = endsWith($l_id_arr[1],"FAC");
//    return $user_is_faculty;
}

print_ldap_info('swapneel');

