<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessUploadProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $productData;

    /**
     * Create a new job instance.
     */
    public function __construct($productData)
    {
        $this->productData = $productData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach($this->productData as $productData){
            // better if we remove space from headers in file, example: ProductID
            $productID      = $productData['Product ID'];
            $productStatus  = $productData['Status'];
            
            $product = Product::find($productID); // you can use few more colums also in a where condition for get more accurate result (if needed)
            if(@$product->Quantity){
                if($productStatus == config('constants.ProductStatus.Sold')){
                    $product->Quantity = $product->Quantity-1;
                    $product->save();
                }else if($productStatus == config('constants.ProductStatus.Buy')){
                    $product->Quantity = $product->Quantity+1;
                    $product->save();
                }
            }
        }
    }
}