<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Auth;

class FrontEndController extends Controller
{
    /**
     * FrontendController constructor.
     */
    public function __construct()
    {
        $this->middleware('customer');
    }
}
