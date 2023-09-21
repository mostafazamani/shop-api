<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ProductResource;
use App\Http\Resources\v1\UserResource;
use App\Models\Favorite;
use App\Models\Product;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
//    public function wishlist(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'userid' => 'required'
//        ]);
//        if ($validator->fails()) {
//            return response()->json($validator->errors()->first(), 422);
//        }
//        $favorit = Favorite::where('id','like',$request->userid)->get();
//        $arra =[];
//        foreach ($favorit as $item) {
//            echo $item;
//        }
//
////        $data = Product::where('id','like',$favorit[0]->productid)->get();
////        $resp = new ProductResource($data[0]);
//
//
//        return response()->json([
//            'user' => $arra,
//            'token' => $favorit[0],
//            'token_type' => 'Bearer'
//        ]);
//    }

    public function productwitid(Request $request, $param)
    {
        $data = Product::where('id', '=', strval($param))->get();
        $list = [];

        for ($x = 0; $x < count($data); $x++) {
            if ($data[$x]->image == null) {
                array_push($list, ['id' => strval($data[$x]->id),
                    'name' => $data[$x]->name,
                    'price' => $data[$x]->price,
                    'discount' => $data[$x]->discount,
                    'pricediscount' => $data[$x]->pricediscount,
                    'available' => $data[$x]->available,
                    'category' => $data[$x]->category,
                    'details' => $data[$x]->details,
                    'image' => null
                ]);
            } else {

                $img = base64_encode($data[$x]->image);
                array_push($list, ['id' => strval($data[$x]->id),
                    'name' => $data[$x]->name,
                    'price' => $data[$x]->price,
                    'discount' => $data[$x]->discount,
                    'pricediscount' => $data[$x]->pricediscount,
                    'available' => $data[$x]->available,
                    'category' => $data[$x]->category,
                    'details' => $data[$x]->details,
                    'image' => $img
                ]);
            }


        }


        return response()->json($list);
    }

    public function productwitcategor(Request $request, $param)
    {
        if (strval($param) == 'All'){
            $data = Product::all();
        }else{
            $data = Product::where('category', '=', strval($param))->get();
        }

        $list = [];

        for ($x = 0; $x < count($data); $x++) {
            if ($data[$x]->image == null) {
                array_push($list, ['id' => strval($data[$x]->id),
                    'name' => $data[$x]->name,
                    'price' => $data[$x]->price,
                    'discount' => $data[$x]->discount,
                    'pricediscount' => $data[$x]->pricediscount,
                    'available' => $data[$x]->available,
                    'category' => $data[$x]->category,
                    'details' => $data[$x]->details,
                    'image' => null
                ]);
            } else {
                //$result = Product::pluck('image','id');
                $img = base64_encode($data[$x]->image);
                array_push($list, ['id' => strval($data[$x]->id),
                    'name' => $data[$x]->name,
                    'price' => $data[$x]->price,
                    'discount' => $data[$x]->discount,
                    'pricediscount' => $data[$x]->pricediscount,
                    'available' => $data[$x]->available,
                    'category' => $data[$x]->category,
                    'details' => $data[$x]->details,
                    'image' => $img
                ]);
            }


        }


        return response()->json($list);
    }


    public function getallproduct(Request $request)
    {
        $data = Product::all();

        $list = [];

        for ($x = 0; $x < count($data); $x++) {
            if ($data[$x]->image == null) {
                array_push($list, ['id' => strval($data[$x]->id),
                    'name' => $data[$x]->name,
                    'price' => $data[$x]->price,
                    'discount' => $data[$x]->discount,
                    'pricediscount' => $data[$x]->pricediscount,
                    'available' => $data[$x]->available,
                    'category' => $data[$x]->category,
                    'details' => $data[$x]->details,
                    'image' => null
                ]);
            } else {
                $result = Product::pluck('image');
                $img = base64_encode($result[$x]);
                array_push($list, ['id' => strval($data[$x]->id),
                    'name' => $data[$x]->name,
                    'price' => $data[$x]->price,
                    'discount' => $data[$x]->discount,
                    'pricediscount' => $data[$x]->pricediscount,
                    'available' => $data[$x]->available,
                    'category' => $data[$x]->category,
                    'details' => $data[$x]->details,
                    'image' => $img
                ]);
            }


        }


        return response()->json($list);
    }
}
