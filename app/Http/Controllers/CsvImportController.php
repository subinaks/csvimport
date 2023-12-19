<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessLargeCSV;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Bus;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class CsvImportController extends Controller
{

    public function import(Request $request) {
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if (!$receiver->isUploaded()) {
            // file not uploaded
        }

        $fileReceived = $receiver->receive(); // receive file
        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            $fileName = str_replace('.'.$extension, '', $file->getClientOriginalName()); //file name without extenstion
            $fileName .= '_' . md5(time()) . '.' . $extension; // a unique file name
            $disk = Storage::disk(config('filesystems.default'));
            $path = $disk->putFileAs('csvfile', $file, $fileName);

            ProcessLargeCSV::dispatch($path,$file->getPathname())->onQueue('csv_processing');

            // delete chunked file
            unlink($this->chunkFilePath);
           
            return [
                'path' => asset('storage/' . $path),
                'filename' => $fileName
            ];
        }

        // // otherwise return percentage informatoin
        // $handler = $fileReceived->handler();
        // return [
        //     'done' => $handler->getPercentageDone(),
        //     'status' => true
        // ];
    }


    
    
}