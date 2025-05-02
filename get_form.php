<?php
include "common.php";

function getPayload()
{
    $payload = file_get_contents(key_exists("PAYLOAD_FILE_PATH", $_ENV) ? $_ENV["PAYLOAD_FILE_PATH"] : "payload.json");
    return json_decode($payload, true);
}

function getFormUrl($uuid, $email)
{
    $token = getToken();
    $config = getConf();
    $cm_key = $config["cm_key"];

    $context = getPayload();
    $context["subject"] = $uuid;
    $context["subjectInfos"]["emailAddress"] = $email;

    $url = $_SERVER["HTTP_REFERER"];
    $url_info = parse_url($url);
    $context["callback"] = $url_info["scheme"] . "://" . $url_info["host"] . ":" . $url_info["port"] . "/get_records.php?uuid=$uuid";
    $context["iframeOrigin"] = $url_info["scheme"] . "://" . $url_info["host"] . ":" . $url_info["port"];

    $curl_url = $config["cm_url"] . "/consents";
    $curl_postfields = json_encode($context);
    if(!empty($cm_key)){
        $curl_httpheaders = array("CM-Key: $cm_key", "Content-Type: application/json");
    } else {
        $curl_httpheaders = array("Authorization: Bearer $token", "Content-Type: application/json");
    }

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $curl_url);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_postfields);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $curl_httpheaders);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADERFUNCTION,
        function ($curl, $header) use (&$headers) {
            $len = strlen($header);
            $header = explode(':', $header, 2);
            if (count($header) < 2) // ignore invalid headers
                return $len;

            $headers[strtolower(trim($header[0]))][] = trim($header[1]);

            return $len;
        }
    );
    $ret = curl_exec($curl);
    curl_errno($curl) > 0 && error_log("while getting form : " . curl_error($curl));
    curl_close($curl);
    return $headers["location"][0];
}

$url = getFormUrl(array_key_exists("uuid", $_GET) ? $_GET["uuid"] : uniqid(), array_key_exists("email", $_GET) ? $_GET["email"] : "");

header("HTTP/1.1 303 See Other");
header("Location: $url");
exit();
?>