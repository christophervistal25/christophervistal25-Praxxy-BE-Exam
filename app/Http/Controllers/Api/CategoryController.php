<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

final class CategoryController extends Controller
{
    public function categories()
    {
        return Category::get();
    }
}
