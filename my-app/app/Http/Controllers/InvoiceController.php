<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function get_all_invoice(){
        //inject customer table with returned data
        $data = Invoice::with('customer')->orderBy('id' , 'DESC')->get();
        return response()->json([
            'invoices' => $data
        ],200);
    }



        // create invoice 
        public function create_invoice(Request $request){
            $counter = Counter::where('key' ,'invoice')->first();
            $random = Counter::where('key' ,'invoice')->first();
            $invoice = Invoice::orderBy('id' , 'DESC')->first();
            if($invoice){
                $invoice= $invoice->id+1;
                $counters= $counter->value+$invoice;
            }else{
                $counters= $counter->value;
            }

            $formData = [
                "number"          => $counter->prefix.$counters,
                "customer_id"         => null,
                "customer"         => null,
                "date"            => date("Y-m-d"),
                "due_date"       => null,
                "reference"         => null,
                "discount"         => 0,
                "terms_and_conditions" => 'Default terms and Conditions',
                "items" => [
                 [
                    "product_id" => null,
                    "product" => null,
                    "unit_price" => 0,
                    "qty" => 1,
                ]

                        ]
                 ];
                 return response()->json($formData);
        }






        public function add_invoice(Request $request){
            $invoiceItem = $request->input('invoice_item');


            $invoice['number'] = $request->input('number');
            $invoice['customer_id'] = $request->input('customer_id');
            $invoice['date']= $request->input('date');
            $invoice['due_date'] = $request->input('due_date');
            $invoice['reference'] = $request->input('reference');
            $invoice['sub_total'] = $request->input('sub_total');
            $invoice['discount'] = $request->input('discount');
            $invoice['total']= $request->input('total');
            $invoice['terms_and_conditions']= $request->input('terms_and_conditions');
            
            
            $data = Invoice::create($invoice);


                foreach(json_decode($invoiceItem) as $item){
                    $itemdata['product_id'] = $item->id;
                    $itemdata['invoice_id'] = $data->id;
                    $itemdata['qty'] = $item->qty;
                    $itemdata['unit_price'] = $item->unit_price;
                    InvoiceItem::create($itemdata);
                }
        }








        public function show_invoice($id){
            $data = Invoice::with('customer' , 'invoice_items.product')->find($id);
            return response()->json([
                'invoices' => $data
            ],200);
        }



        public function edit_invoice($id){
            $data = Invoice::with('customer' , 'invoice_items.product')->find($id);
            return response()->json([
                'invoices' => $data
            ],200);
        }




        public function delete_invoice_items($id){
            $invoiceItem = InvoiceItem::findOrFail($id);
            $invoiceItem->delete();
            // return response()->json('success');
        }



        public function update_invoice(Request $request , $id){
            $invoice = Invoice::where('id' , $id)->first();
            $invoice->number = $request->number;
            $invoice->customer_id = $request->customer_id;
            $invoice->date = $request->date;
            $invoice->due_date = $request->due_date;
            $invoice->reference = $request->reference;
            $invoice->sub_total = $request->sub_total;
            $invoice->discount= $request->discount;
            $invoice->total = $request->total;
            $invoice->terms_and_conditions= $request->terms_and_conditions;


            $invoice->update($request->all());

            $invoiceItem = $request->input('invoice_item');

            $invoice->invoice_items()->delete();

            foreach(json_decode($invoiceItem) as $item){
                $itemdata['product_id'] = $item->product_id;
                $itemdata['invoice_id'] = $invoice->id;
                $itemdata['qty'] = $item->qty;
                $itemdata['unit_price'] = $item->unit_price;
                InvoiceItem::create($itemdata);
                // return response()->json('success');
            }

        }





        public function delete_invoice($id){
            $invoice = Invoice::findOrFail($id);
            $invoice->invoice_items()->delete();
            $invoice->delete();
            // return response()->json('success');
        }
    }