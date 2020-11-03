<?php
require_once __DIR__ . '/vendor/autoload.php';

// Load all configuration options
/** @var array $config */
$config = require __DIR__ . '/config.php';

try { 
    $telegram = new Longman\TelegramBot\Telegram($config['api_key'], $config['bot_username']);
    $result["Version"] = $telegram->getVersion();
    $vUrl = sprintf('https://api.telegram.org/bot%s/getWebhookInfo',$config['api_key']);
    $client = new \GuzzleHttp\Client();
    $response = $client->request('GET', $vUrl);
    if ($response->getStatusCode() == 200 ) 
    {
        $result["Body"] = json_decode($response->getBody());
    }; 
    header("Content-Type:application/json");
    echo json_encode($result);
    
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    // Log telegram errors
    Longman\TelegramBot\TelegramLog::error($e);

    // Uncomment this to output any errors (ONLY FOR DEVELOPMENT!)
    echo $e;
} catch (Longman\TelegramBot\Exception\TelegramLogException $e) {
    // Uncomment this to output log initialisation errors (ONLY FOR DEVELOPMENT!)
    echo $e;
}
