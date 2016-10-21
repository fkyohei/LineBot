<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CallbackController extends Controller
{
    /**
     * callbackメソッド
     *
     * @access public
     * @return Response
     */
    public function index()
    {
         return view('callback.index');
    }
}
