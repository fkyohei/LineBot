<?php

namespace App\Libs;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder;
use Log;

/**
 * 提示型テンプレートメッセージ管理クラス
 *
 * @package App\Libs
 * @Copyright 2016 fkyohei
 */
class ConfirmTemplateMessageManager
{
    /**
     * 提示型テンプレートメッセージに返信する
     *
     * @static
     * @access public
     * @param  object $obj_event イベント
     */
    public static function send_confirm_template_reply($obj_event)
    {
        $obj_bot = LineBotManager::getInstance();
        // 返信相手のトークン取得
        $str_reply_token = $obj_event[0]->getReplyToken();
        // テキスト
        $str_text = 'テキスト';
        // ボタン1
        $obj_button1 = new TemplateActionBuilder\UriTemplateActionBuilder('google', 'http://google.com');
        // ボタン2
        $obj_button2 = new TemplateActionBuilder\PostbackTemplateActionBuilder('feedback', 'feedback=1');
        // 提示型テンプレート生成
        $obj_confirm_template = new ConfirmTemplateBuilder($str_text, [$obj_button1, $obj_button2]);
        $obj_template_message = new TemplateMessageBuilder('メッセージ', $obj_confirm_template);
        // 返信
        $obj_response = $obj_bot->replyMessage($str_reply_token, $obj_template_message);
        Log::debug(print_r($obj_response, true));
    }
}