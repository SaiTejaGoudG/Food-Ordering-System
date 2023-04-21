<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\FoodOrderItem;
use App\Models\FoodOrders;
use App\Models\Food;
use PDF;



class FoodOrdersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'FoodOrders' => FoodOrders::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'date' => 'required | date',  //|date_format:d-m-Y
            'food_order_ids' => 'required|array|min:1',
            'food_order_ids.*' => 'required|exists:food,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'status' => 'Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $foodOrder  = new FoodOrders;
        $foodOrder->date = $request->input('date');
        $foodOrder->order_number  = FoodOrders::generateOrderNumber();
        $foodOrder->total_amount = 0;
        $foodOrder->save();

        // Create the food order items
        $foodOrderIds = $request->input('food_order_ids');
        $totalAmount = 0;
        foreach ($foodOrderIds as $foodItemId) {
            $foodItem = Food::find($foodItemId);
            $price = $foodItem->price;
            $totalAmount += $price;

            $item = new FoodOrderItem();
            $item->food_order_ids = $foodOrder->id;
            $item->food_item_id = $foodItemId;
            $item->price = $price;
            $item->save();
        }

        // Update the food order's total amount
        $foodOrder->total_amount = $totalAmount;
        $foodOrder->save();

        return response()->json([
            'message' => 'Order created successfully',
            'order_number' => $foodOrder->order_number,
            'total_amount' => $foodOrder
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $orderNumber
     * @return \Illuminate\Http\Response
     */
    public function payOrder(Request $request)
    {
        $orderNumber = $request['order_number'];

        // Find the food order by its order number
        $foodOrder = FoodOrders::where('order_number', $orderNumber)->first();

        // Check if the food order exists
        if (!$foodOrder) {
            return response()->json(['error' => 'Food order not found'], 404);
        }

        // $foodOrder->is_paid = false;

        // Check if the food order has already been paid
        // if ($foodOrder->is_paid) {
        //     return response()->json(['error' => 'Food order has already been paid'], 422);
        // }

        // Check if the paid amount is equal to the total amount of the food order
        $paidAmount = $request->input('amount');
        $totalAmount = $foodOrder->total_amount;
        if ($paidAmount != $totalAmount) {
            return response()->json(['error' => 'Paid amount does not match the total amount of the food order'], 422);
        }

        // Update the food order status to mark it as paid
        // $foodOrder->is_paid = true;
        $foodOrder->save();

        return response()->json(['message' => 'Food order has been paid successfully']);
    }

    public function downloadPDF()
    {
        // Get the data you need to generate the PDF
        // $orders = FoodOrders::with('items.food')->get();
        $orders = DB::table('food_orders') 
            ->select('food_orders.date', 'food_orders.order_number', 'food_orders.total_amount', 'food.item_name', 'food.price')
            ->join('food_order_items', 'food_order_items.food_order_ids', '=', 'food_orders.id')
            ->join('food', 'food.id', '=', 'food_order_items.food_item_id')
            ->get(); 

        // dd($orders);
        // Generate the PDF using the view and data
        $pdf = PDF::loadView('orders', compact('orders'));

        // Download the PDF
        return $pdf->download('orders.pdf');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
