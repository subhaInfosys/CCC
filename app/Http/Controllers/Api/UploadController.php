<?php

namespace App\Http\Controllers\Api;

use Log;
use Exception;
use Illuminate\Http\Request;
use App\Jobs\ProcessUploadProducts;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class UploadController extends ApiController
{
    public $responseData;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->responseData = [
            'code'    => 'custom error code for all validations',
            'message' => 'custom error message for all validations',
        ];
    }

    /**
     * updateProductMaster
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function updateProductMaster(Request $request)
    {
        try{
            $prodCsvValidate = Validator::make($request->all(),[
                "productCsv" => "required|mimes:xlsx,xls|max:10000" //upload file type should be xlsx
            ]);

            if(!$prodCsvValidate->fails() && $prodCsvValidate->validated()){
                if($request->has('productCsv')){
                    $productFileName = $request->productCsv->getClientOriginalName();
                    $productFile     = public_path('uploads') .'/'. $productFileName;
                    
                    if(!file_exists($productFile)){
                        $request->productCsv->move(public_path('uploads'), $productFileName);
                    }

                    $header = '';
                    $dataFromCsv = [];

                    $records =  Excel::toArray('', $productFile);
                    
                    foreach($records[0] as $record){
                        if(!$header){
                            $header = $record;
                        }else{
                            $dataFromCsv[] = $record;
                        }
                    }

                    // headers we expect
                    $requiredHeaders = ['Product ID', 'Types', 'Brand',	'Model', 'Capacity', 'Status'];

                    // validate required headers, headers we expect
                    if ($header == $requiredHeaders) {
                        // breaking data, for example 10,000 to 1000/300 each
                        $dataFromCsv = array_chunk($dataFromCsv,300);

                        // looping throough ecah 1000/300 each product data
                        foreach($dataFromCsv as $index=>$dataCsv){
                            // looping throough each product data
                            foreach($dataCsv as $product){
                                $productData[$index][] = array_combine($header, $product);
                            }

                            ProcessUploadProducts::dispatch($productData[$index]);
                        }
                        $this->responseData['code']    = 200;
                        $this->responseData['message'] = 'Upload Success';
                    }else{
                        // handle if failed headers we expect
                        //dd('headers are not same: ', $header, $requiredHeaders);
                        $this->responseData['code']    = 400;
                        $this->responseData['message'] = 'Mandatory fields missing in upload file';
                    }
                }
            }else{
                $errors = $prodCsvValidate->errors();
                //foreach ($prodCsvValidate->get('productCsv') as $msg ){
                    // handle if file type is not excel
                    $this->responseData['code']    = 400;
                    $this->responseData['message'] = 'Upload file type should be xlsx or xls';
                //}
            }
            
            return response()->json($this->responseData, 200);

        }catch(Exception $e){
            Log::error($e);
            $this->responseData['code']    = 400;
            $this->responseData['message'] = 'Upload Failed';
            return response()->json($this->responseData, 200);
        }
    } // end of public function updateProductMaster
}