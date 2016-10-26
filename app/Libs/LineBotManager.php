<?php

namespace App\Libs;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\GuzzleHTTPClient;

/**
 * LINEBot管理クラス
 *
 * @package App\Libs
 * @Copyright 2016 fkyohei
 */
class LineBotManager
{
    private static $obj_http_client;
    private static $obj_bot;

    public static function getInstance()
    {
        if(empty(self::$obj_http_client)) {
            self::$obj_http_client = new LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
        }
        if(empty(self::$obj_bot)) {
            self::$obj_bot = new LINEBot(self::$obj_http_client, ['channelSecret' => getenv('CHANNEL_SECRET')]);
        }
        return self::$obj_bot;
    }
}