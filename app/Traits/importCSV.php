<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\Branch; // Replace YourModel with your actual model
use App\Models\FeeCategory;
use App\Models\FeeCollectionType;
use App\Models\FeeType;
use DB;
use App\Models\CommonFeeCollection;
use App\Models\CommonFeeCollectionHeadWise;
use App\Models\FinancialTransaction;
use App\Models\FinancialTransactionDetail;
trait importCSV {

    /**
     * @param Request $request
     * @return $this|false|string
     */
    
     public function saveBranch($branch)
     {
         $branch = Branch::firstOrCreate(
             ['branch' => $branch],
             ['branch'=>$branch]
         );
         return $branch->id;
     
 
     }
     public function saveFeeCategory($branch,$fee_category)
     {
         $fee_category_data=FeeCategory::firstOrCreate(
             ['branch_id' => $branch],
             ['fee_category'=>$fee_category]
         );
         return $fee_category_data->id;
     }
     public function saveFeeCollectionType($branch)
     {
 
         $categoriesData = ['Academic','Academic Misc', 'Hostel','Hostel Misc', 'Transport','Transport Misc'];
         foreach ($categoriesData as $categoryName) {
             FeeCollectionType::create([
                 'branch_id' => $branch,
                 'collection_head' => $categoryName,
                 'collection_description' => $categoryName
             ]);
         }
     }
     public function checkEntry($entry)
     {
        
 
         $entry = strtolower($entry); 
         switch($entry) {
             case 'due':
                 $parentTable = 'Finance';
                 $entryMode = 0;
                 $inactive = 0;
                 break;
             case 'revdue':
                 $parentTable = 'Finance';
                 $entryMode = 12;
                 $inactive = 1;
                 break;
             case 'scholarship':
                 $parentTable = 'Finance';
                 $entryMode = 15;
                 $inactive = 0;
                 break;
             case 'scholarshiprev/revconsession':
                 $parentTable = 'Finance';
                 $entryMode = 16;
                 $inactive = 1;
                 break;
             case 'consession':
                 $parentTable = 'Finance';
                 $entryMode = 15;
                 $inactive = 0;
                 break;
             case 'rcpt':
                 $parentTable = 'Common';
                 $entryMode = 0;
                 $inactive = 0;
                 break;
             case 'revrcpt':
                 $parentTable = 'Common';
                 $entryMode = 0;
                 $inactive = 1;
                 break;
             case 'jv':
                 $parentTable = 'Common';
                 $entryMode = 14;
                 $inactive = 0;
                 break;
             case 'revjv':
                 $parentTable = 'Common';
                 $entryMode = 14;
                 $inactive = 1;
                 break;
             case 'pmt':
                 $parentTable = 'Common';
                 $entryMode = 1;
                 $inactive = 0;
                 break;
             case 'revpmt':
                 $parentTable = 'Common';
                 $entryMode = 1;
                 $inactive = 1;
                 break;
             case 'fundtransfer':
                 $parentTable = 'Common';
                 $entryMode = 1;
                 $inactive = 0;
                 break;
             default:
                 // Default case
                 $parentTable = 'Finance';
                 $entryMode = 0; // Or any other default value you want to set
                 $inactive = 0; // Or any other default value you want to set
                 $msg = 'Default Finance';
                 break;
         }
  
 
         return [$parentTable,$entryMode,$inactive];
     }
     public function saveFeeType($branch,$feeType,$collection)
     {
         FeeType::Create([
             'branch_id'=>$branch,
             'fee_name'=>$feeType,
             'collection_id'=>1,
             'inactive'=>0,
             "fee_head_type"=>1
 
         ]);
     }
}