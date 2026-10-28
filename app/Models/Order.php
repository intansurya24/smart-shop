<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'total_product_amount',
        'shipping_cost',
        'total_amount',
        'payment_status',
        'order_status',
        'snap_token',
        'recipient_name',
        'recipient_phone',
        'shipping_city',
        'shipping_address',
        'shipping_courier',
        'tracking_number',
        'notes',
        'paid_at',
        'shipped_at',
        'completed_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'completed_at' => 'datetime',
        'total_product_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    public function getFormattedShippingCostAttribute(): string
    {
        return 'Rp ' . number_format($this->shipping_cost, 0, ',', '.');
    }

    public function getFormattedProductAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->total_product_amount, 0, ',', '.');
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->order_status) {
            'pending' => 'Menunggu Pembayaran',
            'processing' => 'Diproses Penjual',
            'shipped' => 'Dalam Pengiriman',
            'completed' => 'Pesanan Selesai',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($this->order_status),
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->order_status) {
            'pending' => 'bg-amber-100 text-amber-800 border-amber-300',
            'processing' => 'bg-blue-100 text-blue-800 border-blue-300',
            'shipped' => 'bg-purple-100 text-purple-800 border-purple-300',
            'completed' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            'cancelled' => 'bg-rose-100 text-rose-800 border-rose-300',
            default => 'bg-slate-100 text-slate-800 border-slate-300',
        };
    }

    public function getPaymentStatusBadgeClassAttribute(): string
    {
        return match($this->payment_status) {
            'paid' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            'unpaid' => 'bg-amber-100 text-amber-800 border-amber-300',
            'failed' => 'bg-rose-100 text-rose-800 border-rose-300',
            'expired' => 'bg-gray-100 text-gray-800 border-gray-300',
            default => 'bg-slate-100 text-slate-800 border-slate-300',
        };
    }
}

