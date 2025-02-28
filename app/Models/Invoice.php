<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable=['total','vat','shipping_charge','payable','cus_details','ship_details','tran_id','val_id','delivery_status','payment_status','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');

    }
    public function invoice_products()
    {
        return $this->hasMany(InvoiceProduct::class, 'invoice_id', 'id');

    }
}
