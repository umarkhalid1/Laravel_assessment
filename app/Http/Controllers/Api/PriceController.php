<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\PricingService;
use App\Http\Controllers\Controller;

class PriceController extends Controller
{

    protected $pricingService;
    
    public function __construct(PricingService $pricingService)
    {
        $this->pricingService = $pricingService;
    }
    
    public function calculate(Request $request)
    {
        $request->validate([
            'base_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'purchase_date' => 'nullable|date'
        ]);
        
        $result = $this->pricingService->calculateFinalPrice(
            $request->base_price,
            $request->quantity,
            $request->purchase_date ? Carbon::parse($request->purchase_date) : null
        );
        
        return response()->json($result);
    }
    

}
