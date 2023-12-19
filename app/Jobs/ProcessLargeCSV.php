<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use App\Models\Branch; // Replace YourModel with your actual model
use App\Models\FeeCategory;
use App\Models\FeeCollectionType;
use App\Models\FeeType;
use DB;
use App\Models\CommonFeeCollection;
use App\Models\CommonFeeCollectionHeadWise;
use App\Models\FinancialTransaction;
use App\Models\FinancialTransactionDetail;
use App\Traits\importCSV;
class ProcessLargeCSV implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use importCSV;

    protected $filePath,$chunckfilePath;

    public function __construct($filePath,$chunckFilePath)
    {
        $this->filePath = $filePath;
        $this->chunkFilePath=$chunckFilePath;
    }

    public function handle()
    {
        $file = fopen(storage_path('app/' . $this->filePath), 'r');
        fgets($file);

        $startingRow = 6; // Start from row 6
        $currentRow = 0;
    
        while ($currentRow < $startingRow - 1 && !feof($file)) {
            fgets($file); // Skip rows until the starting row is reached
            $currentRow++;
        }

        while (($data = fgetcsv($file, 1000, ',')) !== false ) {

            // saving branches;
            $branch=$this->saveBranch($data[11]);

            // Savimg Fee Categories

            $fee_category=$this->saveFeeCategory($branch,$data[10]);


            // Saving fee collection type data
            $fee_collection_type=$this->saveFeeCollectionType($branch);


            // Saving fee type data
            $fee_type=$this->saveFeeType($branch,$data[16],$fee_collection_type);



            // Check entrymode

            $entry_mode=$this->checkEntry($data[5]);

            info($entry_mode);

            if($entry_mode[0]=="Common")
            {


                $commonFeeCollection =CommonFeeCollection::UpdateOrCreate([
                    "admission_no"=>$data[8],
                    "roll_no"=>$data[7],
                    "paid_date" => \Carbon\Carbon::createFromFormat('d-m-Y', $data[1])->format('Y-m-d')

                ],
                [
                    'module_id'=>1,
                    "trans_id"=>1,
                    "admission_no"=>$data[8],
                    "roll_no"=>$data[7],
                    "branch_id"=>$branch,
                    "academic_year"=>$data[2],
                    "financial_year"=>$data[2],
                    "recpt_no"=>$data[15],
                    "entry_mode"=>$entry_mode[1],
                    "inactive"=>$entry_mode[2],
                    "paid_date"=>\Carbon\Carbon::createFromFormat('d-m-Y', $data[1])->format('Y-m-d'),
                    'amount' => DB::raw("IFNULL(amount, 0) + {$data[18]}") // Assuming 'amount' is nullable

                ]);

                // Saving data to child table
                CommonFeeCollectionHeadWise::Create([
                    'module_id'=>1,
                    'receipt_id'=>$commonFeeCollection->id,
                    'head_id'=>1,
                    "head_name"=>$data[16],
                    "branch_id"=>$branch,
                    "amount"=>$data[18]
                ]);



            }
            else if ($entry_mode[0]=="Finance")
            {


                $financeCollection =FinancialTransaction::UpdateOrCreate([
                    "admission_no"=>$data[8],
                    "transaction_date" => \Carbon\Carbon::createFromFormat('d-m-Y', $data[1])->format('Y-m-d')

                ],
                [
                    'module_id'=>1,
                    "trans_id"=>1,
                    "admission_no"=>$data[8],
                    "roll_no"=>$data[7],
                    "branch_id"=>$branch,
                    "academic_year"=>$data[2],
                    "voucher_no"=>$data[6],
                    "recpt_no"=>$data[15],
                    "entry_mode"=>$entry_mode[1],
                    "transaction_date"=>\Carbon\Carbon::createFromFormat('d-m-Y', $data[1])->format('Y-m-d'),
                    'amount' => DB::raw("IFNULL(amount, 0) + {$data[18]}") // Assuming 'amount' is nullable

                ]);

            // Saving to child table
            FinancialTransactionDetail::Create([

                'financial_transaction_id'=>$financeCollection->id,
                'module_id'=>1,
                'head_id'=>1,
                'branch_id'=>$branch,
                'head_name'=>$data[16],
                'amount'=>$data[18]

            ]);

            }

           
        }

        fclose($file);
        Storage::delete($this->filePath);

    }
   

}
