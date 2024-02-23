<html>
<body>
<pre>

<?php
include "common.php";

function getRecords($uuid)
{
    $token = getToken();
    $config = getConf();

    $curl_url = $config["cm_url"] . "/records?subject=$uuid";
    $curl_httpheaders = array("Authorization: Bearer $token", "Content-Type: application/json");
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $curl_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $curl_httpheaders);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $ret = curl_exec($curl);
    curl_errno($curl) > 0 && error_log("while getting form : " . curl_error($curl));
    curl_close($curl);
    return json_decode($ret);
}

print_r(getRecords(array_key_exists("uuid", $_GET) ? $_GET["uuid"] : ""));
?>
</pre>
</body>
</html>