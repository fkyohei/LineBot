<?php

namespace App\Libs;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder;
use Log;

/**
 * ボタンテンプレートメッセージ管理クラス
 *
 * @package App\Libs
 * @Copyright 2016 fkyohei
 */
class ButtonTemplateMessageManager
{
    /**
     * ボタンテンプレートメッセージに返信する
     *
     * @static
     * @access public
     * @param  object $obj_event イベント
     */
    public static function send_button_template_reply($obj_event)
    {
        $obj_bot = LineBotManager::getInstance();
        // 返信相手のトークン取得
        $str_reply_token = $obj_event[0]->getReplyToken();
        // タイトル
        $str_title = 'タイトル';
        // テキスト
        $str_text = 'テキスト';
        // サムネイル画像URL
        $str_image_url = secure_asset('img/bot.png', 'bot image', $attributes = []);
        // ボタン1
        $obj_button1 = new TemplateActionBuilder\UriTemplateActionBuilder('google', 'http://google.com');
        // ボタン2
        $obj_button2 = new TemplateActionBuilder\PostbackTemplateActionBuilder('feedback', 'feedback=1');
        // ボタン3
        $obj_button3 = new TemplateActionBuilder\MessageTemplateActionBuilder('ボタンラベル', 'ボタンテキスト');
        // ボタンテンプレート生成
        $obj_button_template = new ButtonTemplateBuilder($str_title, $str_text, $str_image_url, [$obj_button1, $obj_button2, $obj_button3]);
        $obj_template_message = new TemplateMessageBuilder('メッセージ', $obj_button_template);
        // 返信
        $obj_response = $obj_bot->replyMessage($str_reply_token, $obj_template_message);
        Log::debug(print_r($obj_response, true));
    }
}