<?php

namespace App\Http\Controllers;

use App\Libs\Verify;
use App\Libs\Analyze;
use Illuminate\Http\Request;
use LINE\LINEBot\HTTPClient\GuzzleHTTPClient;
use Log;

/**
 * コールバック用コントローラー
 *
 * @package App\Http\Controllers
 * @Copyright 2016 fkyohei
 */
class CallbackController extends Controller
{
    /**
     * callbackメソッド
     *
     * @access public
     * @param  Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        // 署名検証
        $mix_result = Verify::execute($request);
        if(!empty($mix_result['error_message'])) {
            Log::error($mix_result['error_message']);
            return \App::abort(400);
        }
        Log::debug(print_r($mix_result, true));
        Analyze::execute($mix_result['events']);
        return response()->json([]);
    }
}
