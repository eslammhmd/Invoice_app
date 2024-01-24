<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'invoice_id',
        'unit_price',
        'qty'
     ];

     public function product(){
        return $this->belongsTo(Product::class);
    }

}
