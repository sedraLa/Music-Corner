<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index($slug) {
        $category = Category::with('products')
        ->where('slug', $slug)
        ->firstOrFail();
         return view('categories.index',compact('category'));

    }
}
