<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Promo extends Model
{
    protected $table = 'promos';
    protected $fillable = [
        'code',
        'title',
        'description',
        'discount_type',
        'discount_value',
        'min_purchase',
        'max_discount',
        'start_date',
        'end_date',
        'active'
    ];
    
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'active' => 'boolean',
        'discount_value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'max_discount' => 'decimal:2',
    ];

    // Cek apakah promo valid
    public function isValid($totalBelanja = 0)
    {
        $now = Carbon::now();
        
        if (!$this->active) {
            return false;
        }

        if ($now->lt($this->start_date) || $now->gt($this->end_date)) {
            return false;
        }

        if ($totalBelanja < $this->min_purchase) {
            return false;
        }

        return true;
    }

    // Hitung diskon
    public function calculateDiscount($totalBelanja)
    {
        if ($this->discount_type === 'percentage') {
            $discount = ($totalBelanja * $this->discount_value) / 100;
            
            if ($this->max_discount && $discount > $this->max_discount) {
                $discount = $this->max_discount;
            }
            
            return $discount;
        } else {
            // fixed
            return $this->discount_value;
        }
    }
}
