<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class ModalController extends Controller
{
    public function load(Request $request)
    {
        $input = $request->all();
        
        $response_html = view($input['view'])
            ->render();

        $response = [];
        $response['html'] = $response_html;

        return response($response, 200); 
    }
}
