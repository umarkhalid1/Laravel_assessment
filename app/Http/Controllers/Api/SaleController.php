<?php

namespace App\Http\Controllers\Api;

use App\Models\Lot;
use App\Models\Sale;
use App\Models\AuditLog;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SaleController extends Controller
{
    public function createSale(Request $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|numeric|min:1',
            ]);

            $inventory = Inventory::where('product_id', $validated['product_id'])
                ->lockForUpdate()
                ->first();

            if (!$inventory) {
                throw new \Exception('Inventory record not found.');
            }

            if ($inventory->quantity < $validated['quantity']) {
                return response()->json([
                    'message' => 'Not enough stock available.',
                ], 400);
            }

            $inventory->quantity -= $validated['quantity'];
            $inventory->save();

            $sale = Sale::create([
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'total_price' => $validated['quantity'] * $inventory->price_per_unit,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Sale completed successfully.',
                'sale' => $sale,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'An error occurred while processing the sale.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function updateLotInventory($product, $quantity)
    {
        $lots = Lot::where('product_id', $product->id)
            ->where('quantity', '>', 0)
            ->orderBy('date')
            ->get();

        $remainingQuantity = $quantity;

        foreach ($lots as $lot) {
            if ($remainingQuantity <= 0) {
                break;
            }

            if ($lot->quantity >= $remainingQuantity) {
                $lot->quantity -= $remainingQuantity;
                $lot->save();
                $remainingQuantity = 0;
            } else {
                $remainingQuantity -= $lot->quantity;
                $lot->quantity = 0;
                $lot->save();
            }
        }

        if ($remainingQuantity > 0) {
            throw new \Exception('Not enough stock available in the lots.');
        }
        $inventory = Inventory::where('product_id', $product->id)->first();
        $inventory->quantity -= $quantity;
        $inventory->save();
    }


    private function createAuditLog($action, $details)
    {
        AuditLog::create([
            'action' => $action,
            'details' => json_encode($details),
            'loggable_type' => Sale::class,
            'loggable_id' => $details['product_id'],
        ]);
    }

}
