<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;



Route::get('/get_all_invoice' , [InvoiceController::class,'get_all_invoice']);
Route::get('/create_invoice' , [InvoiceController::class,'create_invoice']);
Route::get('/customers' , [CustomerController::class,'all_customer']);
Route::get('/products' , [ProductController::class,'all_product']);
Route::post('/add_invoice' , [InvoiceController::class,'add_invoice']);
Route::get('/show_invoice/{id}' , [InvoiceController::class,'show_invoice']);
Route::get('/edit_invoice/{id}' , [InvoiceController::class,'edit_invoice']);
Route::get('/delete_invoice_items/{id}' , [InvoiceController::class,'delete_invoice_items']);
Route::post('/update_invoice/{id}' , [InvoiceController::class,'update_invoice']);
Route::get('/delete_invoice/{id}' , [InvoiceController::class,'delete_invoice']);