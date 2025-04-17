<?php

namespace App\Services;

use App\Models\PricingRule;
use Carbon\Carbon;

class PricingService
{
    public function calculateFinalPrice(float $basePrice, int $quantity, ?Carbon $purchaseDate = null): array
    {
        $purchaseDate = $purchaseDate ?? now();
        
        $rules = $this->getApplicableRules($quantity, $purchaseDate);
        
        $finalPrice = $basePrice;
        $appliedRules = [];
        
        foreach ($rules as $rule) {
            $originalPrice = $finalPrice;
            
            if ($rule->type === 'quantity_based') {
                $finalPrice = $this->applyQuantityDiscount($finalPrice, $quantity, $rule);
            } elseif ($rule->type === 'time_based') {
                $finalPrice = $this->applyTimeDiscount($finalPrice, $rule);
            }
            
            if ($finalPrice !== $originalPrice) {
                $appliedRules[] = [
                    'rule_type' => $rule->type,
                    'discount_value' => $rule->discount_value,
                    'discount_type' => $rule->discount_type,
                    'price_after_rule' => $finalPrice
                ];
            }
        }
        
        return [
            'base_price' => $basePrice,
            'quantity' => $quantity,
            'final_price' => $finalPrice,
            'total_amount' => $finalPrice * $quantity,
            'applied_rules' => $appliedRules,
            'purchase_date' => $purchaseDate->toDateString()
        ];
    }
    
    protected function getApplicableRules(int $quantity, Carbon $date)
    {
        $dayOfWeek = strtolower($date->englishDayOfWeek);
        
        return PricingRule::where('is_active', true)
            ->where(function($query) use ($quantity, $dayOfWeek) {
                $query->where('type', 'quantity_based')
                      ->where('min_quantity', '<=', $quantity);
            })
            ->orWhere(function($query) use ($dayOfWeek) {
                $query->where('type', 'time_based')
                      ->where('day_of_week', $dayOfWeek);
            })
            ->orderBy('precedence')
            ->get();
    }
    
    protected function applyQuantityDiscount(float $price, int $quantity, PricingRule $rule): float
    {
        if ($rule->discount_type === 'discount') {
            return $price * (1 - ($rule->discount_value / 100));
        }
        return $price * (1 + ($rule->discount_value / 100));
    }
    
    protected function applyTimeDiscount(float $price, PricingRule $rule): float
    {
        if ($rule->discount_type === 'discount') {
            return $price * (1 - ($rule->discount_value / 100));
        }
        return $price * (1 + ($rule->discount_value / 100));
    }
}