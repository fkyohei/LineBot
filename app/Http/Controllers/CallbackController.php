<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LINE\LINEBot\HTTPClient\GuzzleHTTPClient;
use Log;

class CallbackController extends Controller
{
    /**
     * callbackメソッド
     *
     * @access public
     * @return Response
     */
    public function index(Request $request)
    {
        // 署名検証
        $mix_result = \App\Libs\Verify::execute($request);
        if(!empty($mix_result['error_message'])) {
            Log::error($mix_result['error_message']);
            return \App::abort(400);
        }
        Log::debug(print_r($mix_result, true));
        return view('callback.index');
    }
}
