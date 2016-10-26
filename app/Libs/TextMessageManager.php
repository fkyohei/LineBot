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
    const TEXT_PARROT  = 'オウム返し';
    const TEXT_IMAGE   = '画像';
    const TEXT_STICKER = 'スタンプ';
    const TEXT_TEMPLATE_BUTTON   = 'ボタンテンプレート';
    const TEXT_TEMPLATE_CONFIRM  = '提示型テンプレート';
    const TEXT_TEMPLATE_CAROUSEL = 'カルーセル型テンプレート';

    /**
     * テキストメッセージに返信をする
     *
     * @static
     * @access public
     * @param  object $obj_event イベント
     */
    public static function reply($obj_event)
    {
        $str_text = self::_get_text($obj_event);
        if($str_text == self::TEXT_PARROT) {
            // オウム返し
            self::_send_parrot_reply($obj_event);
        } elseif($str_text == self::TEXT_IMAGE) {
            // 画像
            ImageMessageManager::send_image_reply($obj_event);
        } elseif($str_text == self::TEXT_STICKER) {
            // スタンプ
            StickerMessageManager::send_sticker_reply($obj_event);
        } elseif($str_text == self::TEXT_TEMPLATE_BUTTON) {
            // ボタンテンプレート
            ButtonTemplateMessageManager::send_button_template_reply($obj_event);
        } elseif($str_text == self::TEXT_TEMPLATE_CONFIRM) {
            // 提示型テンプレート
            ConfirmTemplateMessageManager::send_confirm_template_reply($obj_event);
        } elseif($str_text == self::TEXT_TEMPLATE_CAROUSEL) {
            // カルーセル型テンプレート
            CarouselTemplateMessageManager::send_carousel_template_reply($obj_event);
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
        $obj_bot = LineBotManager::getInstance();
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
        $obj_bot = LineBotManager::getInstance();
        // 返信相手のトークン取得
        $str_reply_token = $obj_event[0]->getReplyToken();
        // 返信テキスト
        $str_text = "【ヘルプ】\n"
                  . "・".self::TEXT_PARROT."\n"
                  . "・".self::TEXT_IMAGE."\n"
                  . "・".self::TEXT_STICKER."\n"
                  . "・".self::TEXT_TEMPLATE_BUTTON."\n"
                  . "・".self::TEXT_TEMPLATE_CONFIRM."\n"
                  . "・".self::TEXT_TEMPLATE_CAROUSEL;
        // 返信
        $obj_response = $obj_bot->replyText($str_reply_token, $str_text);
        Log::debug(print_r($obj_response, true));
    }
}