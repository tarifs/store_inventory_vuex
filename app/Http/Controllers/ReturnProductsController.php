<?php

namespace App\Http\Controllers;

use App\Models\ProductSizeStock;
use App\Models\ReturnProduct;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ReturnProductsController extends Controller
{
    public function returnProduct(){
        return view('return_products.return');
    }

    public function returnProductSubmit(Request $request){
        // Validate data
        $validate = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
            'date' => 'required|string',
            'items' => 'required'
        ]);

        // Error response
        if ($validate->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validate->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Store return product
        foreach ($request->items as $item){
            if($item['quantity'] && $item['quantity'] > 0){
                $new_item = new ReturnProduct();
                $new_item->product_id = $request->product_id;
                $new_item->date = $request->date;
                $new_item->size_id = $item['size_id'];
                $new_item->quantity = $item['quantity'];
                $new_item->save();

                // Product stock size update
                $psq = ProductSizeStock::where('product_id', $request->product_id)
                    ->where('size_id', $item['size_id'])
                    ->first();
                // Stock in
                $psq->quantity = $psq->quantity + $item['quantity'];

                $psq->save();
            }
        }

        flash('Return product updated successfully')->success();

        return response()->json([
            'success' => true
        ], Response::HTTP_OK);
    }

    public function history(){
        $return_products = ReturnProduct::with(['product', 'size'])->orderBy('created_at', 'DESC')->get();
        return view('return_products.history', compact('return_products'));
    }
}
