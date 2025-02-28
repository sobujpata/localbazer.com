<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    protected $fillable=['invoice_id','product_id','user_id','qty','sale_price','color','size'];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');

    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');

    }
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');

    }
}
