<?php

namespace App\Libs;
use Log;
/**
 * テキストメッセージ管理クラス
 *
 * @package App\Libs
 * @Copyright 2016 fkyohei
 */
class TextMessageManager
{
    const TEXT_HELP   = 'ヘルプ';
    const TEXT_PARROT = 'オウム返し';

    /**
     * テキストメッセージに返信をする
     *
     * @static
     * @access public
     * @param  object $obj_event イベント
     */
    public static function reply($obj_event)
    {
        if(self::_get_text($obj_event) == self::TEXT_PARROT) {
            // オウム返し
            self::_send_parrot_reply($obj_event);
        } else {
            // ヘルプ
            self::_send_help_reply($obj_event);
        }
    }

    /**
     * テキストを取得
     *
     * @static
     * @access private
     * @param  object $obj_event イベント
     * @return string テキスト
     */
    private static function _get_text($obj_event)
    {
        return $obj_event[0]->getText();
    }

    /**
     * オウム返しメッセージを送信
     *
     * @static
     * @access private
     * @param  object $obj_event イベント
     */
    private static function _send_parrot_reply($obj_event)
    {
        $obj_bot = \App\Libs\LineBotManager::getInstance();
        // 返信相手のトークン取得
        $str_reply_token = $obj_event[0]->getReplyToken();
        // 返信テキスト
        $str_text = self::_get_text($obj_event);
        // 返信
        $obj_response = $obj_bot->replyText($str_reply_token, $str_text);
        Log::debug(print_r($obj_response, true));
    }

    /**
     * ヘルプメッセージを送信
     *
     * @static
     * @access private
     * @param  object $obj_event イベント
     */
    private static function _send_help_reply($obj_event)
    {
        $obj_bot = \App\Libs\LineBotManager::getInstance();
        // 返信相手のトークン取得
        $str_reply_token = $obj_event[0]->getReplyToken();
        // 返信テキスト
        $str_text = "【ヘルプ】\n・オウム返し";
        // 返信
        $obj_response = $obj_bot->replyText($str_reply_token, $str_text);
        Log::debug(print_r($obj_response, true));
    }
}