<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'number',
        'customer_id',
        'date',
        'due_date',
        'reference',
        'sub_total',
        'discount',
        'total',
        'terms_and_conditions',
    ];
    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function invoice_items(){
        return $this->hasMany(InvoiceItem::class);
    }
}
