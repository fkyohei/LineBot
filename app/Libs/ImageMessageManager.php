<?php

namespace App\Libs;
use Log;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
/**
 * イメージメッセージ管理クラス
 *
 * @package App\Libs
 * @Copyright 2016 fkyohei
 */
class ImageMessageManager
{
    /**
     * イメージメッセージに返信をする
     *
     * @static
     * @access public
     * @param  object $obj_event イベント
     */
    public static function send_image_reply($obj_event)
    {
        $obj_bot = LineBotManager::getInstance();
        // 返信相手のトークン取得
        $str_reply_token = $obj_event[0]->getReplyToken();
        // 画像URL生成
        $str_image_url = secure_asset('img/bot.png', 'bot image', $attributes = []);
        Log::debug(print_r($str_image_url, true));
        // 返信画像
        $obj_image = new ImageMessageBuilder($str_image_url, $str_image_url);
        // 返信
        $obj_response = $obj_bot->replyMessage($str_reply_token, $obj_image);
        Log::debug(print_r($obj_response, true));
    }
}