<?php

namespace App\Http\Controllers\Api;

use App\Models\Lot;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\InventoryResource;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->all());
        try {
            $query = Inventory::with('product');

            if ($request->has('sku')) {
                $query->whereHas('product', function ($q) use ($request) {
                    $q->where('sku', 'like', '%' . $request->sku . '%');
                });
            }

            if ($request->has('name')) {
                $query->whereHas('product', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->name . '%');
                });
            }

            if ($request->has('location')) {
                $query->where('location', 'like', '%' . $request->location . '%');
            }

            $inventories = $query->paginate(10);

            if ($inventories->isEmpty()) {
                return response()->json([
                    'message' => 'No inventory records found.',
                    'data' => [],
                ], 404);
            }


            return InventoryResource::collection($inventories);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred while fetching the inventories.',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        try {
            $inventory = Inventory::with('product')->find($inventory->id);

            if (!$inventory) {
                return response()->json([
                    'message' => 'Inventory item not found.',
                ], 404);
            }

            return new InventoryResource($inventory);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred while fetching the inventory item.',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $request->validate([
            'quantity' => 'required|numeric|min:0',
        ]);
        try {
            DB::beginTransaction();
            $inventory = Inventory::findOrFail($id);
            if (!$inventory) {
                return response()->json([
                    'message' => 'Inventory item not found.',
                ], 404);
            }

            $inventory->quantity = $request->quantity;
            $inventory->save();
            $latestLot = Lot::where('product_id', $inventory->product_id)
                ->latest()
                ->first();
            if ($latestLot) {
                $latestLot->quantity = $request->quantity;
                $latestLot->total_price = $latestLot->price_per_unit * $request->quantity;
                $latestLot->save();
            }
            DB::commit();
            return response()->json([
                'message' => 'Inventory quantity updated successfully.',
                'inventory' => $inventory,
                'updated_lot' => $latestLot
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to update inventory.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
