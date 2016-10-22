<?php

namespace App\Libs;

use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Exception\InvalidEventRequestException;
use LINE\LINEBot\Exception\InvalidSignatureException;
use LINE\LINEBot\Exception\UnknownEventTypeException;
use LINE\LINEBot\Exception\UnknownMessageTypeException;
use LINE\LINEBot\HTTPClient\GuzzleHTTPClient;

class Verify
{
    /**
     * 署名検証の実行
     *
     * @static
     * @access public
     * @param  object $obj_request ヘンドポイントへのリクエスト
     * @return mix $mix_result
     */
    public static function execute($obj_request)
    {
        // リクエストヘッダー内のシグネチャを得る
        $obj_signature = $obj_request->headers->get(HTTPHeader::LINE_SIGNATURE);
        if(empty($obj_signature)) {
            $mix_result['error_message'] = 'Bad Request';
            return $mix_result;
        }

        $obj_http_client = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
        $obj_bot = new \LINE\LINEBot($obj_http_client, ['channelSecret' => getenv('CHANNEL_SECRET')]);

        // Check request with signature and parse request
        try {
            $obj_events = $obj_bot->parseEventRequest($obj_request->getContent(), $obj_signature);
        }  catch (InvalidSignatureException $e) {
            $mix_result['error_message'] = 'Invalid signature';
            return  $mix_result;
        }  catch (UnknownEventTypeException $e) {
            $mix_result['error_message'] = 'Unknown event type has come';
            return  $mix_result;
        }  catch (UnknownMessageTypeException $e) {
            $mix_result['error_message'] = 'Unknown message type has come';
            return  $mix_result;
        }  catch (InvalidEventRequestException $e) {
            $mix_result['error_message'] = "Invalid event request";
            return  $mix_result;
        }

        $mix_result['events'] = $obj_events;
        return $mix_result;
    }
}