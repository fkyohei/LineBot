<?php

namespace App\Libs;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use Log;

/**
 * スタンプメッセージ管理クラス
 *
 * @package App\Libs
 * @Copyright 2016 fkyohei
 */
class StickerMessageManager
{
    /**
     * スタンプメッセージに返信をする
     *
     * @static
     * @access public
     * @param  object $obj_event イベント
     */
    public static function send_sticker_reply($obj_event)
    {
        $obj_bot = \App\Libs\LineBotManager::getInstance();
        // 返信相手のトークン取得
        $str_reply_token = $obj_event[0]->getReplyToken();
        // パッケージ番号
        $str_package_id = '2';
        // スタンプ番号
        $str_sticker_id = '18';
        // 返信スタンプ
        $obj_sticker = new StickerMessageBuilder($str_package_id, $str_sticker_id);
        // 返信
        $obj_response = $obj_bot->replyMessage($str_reply_token, $obj_sticker);
        Log::debug(print_r($obj_response, true));
    }
}