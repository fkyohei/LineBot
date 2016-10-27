<?php

namespace App\Libs;
use Log;

/**
 * Postback管理クラス
 *
 * @package App\Libs
 * @Copyright 2016 fkyohei
 */
class PostBackManager
{
    /**
     * アクションの内容を返信
     *
     * @static
     * @access public
     * @param  object $obj_event
     */
    public static function reply_action($obj_event)
    {
        $obj_bot = LineBotManager::getInstance();
        // 返信相手のトークン取得
        $str_reply_token = $obj_event[0]->getReplyToken();
        // アクションを取得
        $str_action = $obj_event[0]->getPostbackData();
        // 返信
        $obj_response = $obj_bot->replyText($str_reply_token, $str_action);
        Log::debug(print_r($obj_response, true));
    }
}