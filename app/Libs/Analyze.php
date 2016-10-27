<?php

namespace App\Libs;

use \LINE\LINEBot\Event\MessageEvent\TextMessage;

/**
 * イベント解析クラス
 *
 * @package App\Libs
 * @Copyright 2016 fkyohei
 */
class Analyze
{
    const EVENT_TYPE_MESSAGE  = 'message';
    const EVENT_TYPE_POSTBACK = 'postback';
    const EVENT_TYPE_TEXT     = 'text';

    /**
     * イベント解析の実行
     *
     * @static
     * @access public
     * @param  object $obj_event イベント
     */
    public static function execute($obj_event)
    {
        // イベントタイプ取得
        $str_event_type = self::_get_event_type($obj_event);
        if($str_event_type == self::EVENT_TYPE_POSTBACK) {
            // postbackの場合
            PostBackManager::reply_action($obj_event);
        } elseif($str_event_type == self::EVENT_TYPE_MESSAGE) {
            //// メッセージの場合、イベント詳細タイプ毎に処理を実行
            // テキストメッセージ
            if(self::_get_event_detail_type($obj_event) == self::EVENT_TYPE_TEXT) {
                TextMessageManager::reply($obj_event);
            }
        }
    }

    /**
     * イベントタイプを取得
     *
     * @static
     * @access private
     * @param  object $obj_event イベント
     * @return string イベントタイプ
     */
    private static function _get_event_type($obj_event)
    {
        return $obj_event[0]->getType();
    }

    /**
     * イベント詳細タイプを取得
     *
     * @static
     * @access private
     * @param  object $obj_event イベント
     * @return string イベント詳細タイプ
     */
    private static function _get_event_detail_type($obj_event)
    {
        // テキストメッセージ
        if($obj_event[0] instanceof TextMessage) {
            return self::EVENT_TYPE_TEXT;
        }
        return 'undefined';
    }
}