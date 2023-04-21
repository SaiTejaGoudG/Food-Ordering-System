<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Food;


class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd("Index");
        return response()->json([
            'foods' => Food::get()
        ]);
    }

    public function store(Request $request)
    {
        // dd("store");

        $validator = Validator::make($request->all(), [
            'item_name' => 'required  | regex:/^[a-zA-Z0-9 ]+$/ ', // alpha_num
            'price' => 'required  |  numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'status' => 'Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $foods = new Food;
        $foods->item_name = $request->item_name;
        $foods->price = $request->price;
        $foods->save();

        return response()->json([
            'message' => 'Food Created Successfully',
            'status' => 'Success',
            'data' => $foods
        ]);
    }
}
