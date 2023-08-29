<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $tabel = 'order_details';

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk','id');
    }
}
