<?php

function getConf()
{
    $config = parse_ini_file(key_exists("CONFIG_FILE_PATH", $_ENV) ? $_ENV["CONFIG_FILE_PATH"] : "config.ini");
    $config["auth_url"] = key_exists("AUTH_URL", $_ENV) ? $_ENV["AUTH_URL"] : $config["auth_url"];
    $config["auth_realm"] = key_exists("AUTH_REALM", $_ENV) ? $_ENV["AUTH_REALM"] : $config["auth_realm"];
    $config["auth_client_id"] = key_exists("AUTH_CLIENT_ID", $_ENV) ? $_ENV["AUTH_CLIENT_ID"] : $config["auth_client_id"];
    $config["auth_username"] = key_exists("AUTH_USERNAME", $_ENV) ? $_ENV["AUTH_USERNAME"] : $config["auth_username"];
    $config["auth_password"] = key_exists("AUTH_PASSWORD", $_ENV) ? $_ENV["AUTH_PASSWORD"] : $config["auth_password"];
    $config["cm_url"] = key_exists("CM_URL", $_ENV) ? $_ENV["CM_URL"] : $config["cm_url"];
    $config["cm_key"] = key_exists("CM_KEY", $_ENV) ? $_ENV["CM_KEY"] : $config["cm_key"];
    return $config;
}

function getToken()
{
    $config = getConf();
    $auth_url = $config["auth_url"];
    $auth_realm = $config["auth_realm"];
    $auth_client_id = $config["auth_client_id"];
    $auth_username = $config["auth_username"];
    $auth_password = $config["auth_password"];

    $curl_url = $auth_url . "/realms/" . $auth_realm . "/protocol/openid-connect/token";
    $curl_postfields = "grant_type=password&client_id=" . $auth_client_id .
        "&username=" . urlencode($auth_username) .
        "&password=" . urlencode($auth_password);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $curl_url);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_postfields);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);
    curl_errno($curl) > 0 && error_log("while getting token : " . curl_error($curl));
    curl_close($curl);

    return json_decode($response)->access_token;
}

?>