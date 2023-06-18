<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Invoice_detail;
use App\Models\Product;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerController extends Controller
{
    function dashboard()
    {
        $invoices = Invoice::where('user_id', auth()->id())->get();
        return view('backend.customer.dashboard', compact('invoices'));
    }
    function invoice_download($invoice_id)
    {
        $invoice = Invoice::find($invoice_id);
        $purchase_products = Invoice_detail::where('invoice_id', $invoice_id)->get();
        $pdf = Pdf::loadView('backend.customer.invoice_download', compact('invoice', 'purchase_products'));
        return $pdf->download($invoice->invoice_no . '.pdf');
        // return view('backend.customer.invoice_download', compact('invoice', 'purchase_products'));
    }
    function customer_review($invoice_id)
    {
        $invoice_details = Invoice_detail::where('invoice_id', $invoice_id)->get();
        return view('backend.customer.review', compact('invoice_details'));
    }
    function customer_review_insert(Request $request)
    {
        foreach ($request->rating as $invoice_details_id => $rating) {
            $product_id = Invoice_detail::find($invoice_details_id)->product_id;
            $vendor_id = Product::find($product_id)->user_id;
            if ($rating) {
                Review::insert([
                    'invoice_details_id' => $invoice_details_id,
                    'user_id' => auth()->id(),
                    'product_id' => $product_id,
                    'vendor_id' => $vendor_id,
                    'rating' => $rating,
                    'comments' => $request->comments[$invoice_details_id],
                    'created_at' => Carbon::now()
                ]);
            }
        }
        return back();
    }
}
