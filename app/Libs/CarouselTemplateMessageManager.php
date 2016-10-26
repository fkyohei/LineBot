<?php

namespace App\Libs;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder;
use Log;

/**
 * カルーセル型テンプレートメッセージ管理クラス
 *
 * @package App\Libs
 * @Copyright 2016 fkyohei
 */
class CarouselTemplateMessageManager
{
    /**
     * カルーセル型テンプレートメッセージに返信する
     *
     * @static
     * @access public
     * @param  object $obj_event イベント
     */
    public static function send_carousel_template_reply($obj_event)
    {
        $obj_bot = LineBotManager::getInstance();
        // 返信相手のトークン取得
        $str_reply_token = $obj_event[0]->getReplyToken();

        // カルーセル型テンプレート生成
        $obj_template_message  = new TemplateMessageBuilder('メッセージ', self::_create_carousel_template());
        // 返信
        $obj_response = $obj_bot->replyMessage($str_reply_token, $obj_template_message);
        Log::debug(print_r($obj_response, true));
    }

    /**
     * カルーセル型テンプレート生成
     *
     * @static
     * @access private
     * @return object CarouselTemplateBuilder
     */
    private static function _create_carousel_template()
    {
        return self::_create_full_carousel();
//        return self::_create_no_title_carousel();
//        return self::_create_no_thumbnail_carousel();
//        return self::_create_no_title_and_thumbnail_carousel();
    }

    /**
     * タイトル・テキスト・サムネイル・ボタン３のカルーセル生成
     *
     * @static
     * @access private
     * @return object CarouselTemplateBuilder
     */
    private static function _create_full_carousel()
    {
        // サムネイル画像URL
        $str_image_url = secure_asset('img/bot.png', 'bot image', $attributes = []);

        $ary_columns = array();
        for($i = 1; $i <= 5; $i++) {
            $ary_button_actions = array();
            $ary_button_actions[] = new TemplateActionBuilder\UriTemplateActionBuilder('google'.$i, 'http://google.com');
            $ary_button_actions[] = new TemplateActionBuilder\PostbackTemplateActionBuilder('feedback'.$i, 'feedback='.$i);
            $ary_button_actions[] = new TemplateActionBuilder\MessageTemplateActionBuilder('ボタンラベル'.$i, 'ボタンテキスト'.$i);
            // カラム1
            $ary_columns[] = new CarouselColumnTemplateBuilder('タイトル'.$i, 'テキスト'.$i, $str_image_url, $ary_button_actions);
        }

        return new CarouselTemplateBuilder($ary_columns);
    }

    /**
     * テキスト・サムネイル・ボタン２のカルーセル生成
     *
     * @static
     * @access private
     * @return object CarouselTemplateBuilder
     */
    private static function _create_no_title_carousel()
    {
        // サムネイル画像URL
        $str_image_url = secure_asset('img/bot.png', 'bot image', $attributes = []);

        $ary_columns = array();
        for($i = 1; $i <= 5; $i++) {
            $ary_button_actions = array();
            $ary_button_actions[] = new TemplateActionBuilder\UriTemplateActionBuilder('google'.$i, 'http://google.com');
            $ary_button_actions[] = new TemplateActionBuilder\PostbackTemplateActionBuilder('feedback'.$i, 'feedback='.$i);
            // カラム1
            $ary_columns[] = new CarouselColumnTemplateBuilder(null, 'テキスト'.$i, $str_image_url, $ary_button_actions);
        }

        return new CarouselTemplateBuilder($ary_columns);
    }

    /**
     * タイトル・テキスト・ボタン１のカルーセル生成
     *
     * @static
     * @access private
     * @return object CarouselTemplateBuilder
     */
    private static function _create_no_thumbnail_carousel()
    {
        $ary_columns = array();
        for($i = 1; $i <= 5; $i++) {
            $ary_button_actions = array();
            $ary_button_actions[] = new TemplateActionBuilder\UriTemplateActionBuilder('google'.$i, 'http://google.com');
            // カラム1
            $ary_columns[] = new CarouselColumnTemplateBuilder('タイトル'.$i, 'テキスト'.$i, null, $ary_button_actions);
        }

        return new CarouselTemplateBuilder($ary_columns);
    }

    /**
     * テキスト・ボタン２のカルーセル生成
     *
     * @static
     * @access private
     * @return object CarouselTemplateBuilder
     */
    private static function _create_no_title_and_thumbnail_carousel()
    {
        $ary_columns = array();
        for($i = 1; $i <= 5; $i++) {
            $ary_button_actions = array();
            $ary_button_actions[] = new TemplateActionBuilder\UriTemplateActionBuilder('google'.$i, 'http://google.com');
            $ary_button_actions[] = new TemplateActionBuilder\PostbackTemplateActionBuilder('feedback'.$i, 'feedback='.$i);
            // カラム1
            $ary_columns[] = new CarouselColumnTemplateBuilder(null, 'テキスト'.$i, null, $ary_button_actions);
        }

        return new CarouselTemplateBuilder($ary_columns);
    }
}