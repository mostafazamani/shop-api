<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getallcategory(Request $request){
        $data = Category::all();
        $list = [];
        foreach ($data as $category){
            array_push($list,$category['name']);
        }
        return response()->json(['category'=>$list]);
    }
}
