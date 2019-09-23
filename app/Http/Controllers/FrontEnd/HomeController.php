<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\Category;
use App\Models\ProductType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::getMenuCategory();

        return view('frontend.pages.index', compact('categories'));
    }
}
