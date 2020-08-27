<?php
//////////////// Config ////////////////////////////////

//Array of user id's to which the message will be sent - TODO : Pull from JSON file in the same directory.
$adm_ids= array(
    "",
);

//Bot token
$bot_tok = "";

//Message (you can append message with $_GET & $_POST values by accessing this script from somewhere else)
$message = "";

/////////////////////////////////////////////////////////////

function sendMessage($token, $chatid, $message) 
{
    $url = "https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chatid}&text=";
    $url .= urlencode($message);
    $ch = curl_init();
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

foreach ($adm_ids as &$id)
{
    $date = date('Y.m.d H:i');
    //$message = ""; -override-
    $response;
    $result = json_decode(sendMessage($bot_tok, $id, $message));
}

?>