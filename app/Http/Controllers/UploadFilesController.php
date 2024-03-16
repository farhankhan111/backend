<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SplFileInfo;
use SplFileObject;

class UploadFilesController extends Controller
{

    public function uploadCsv(Request $request)
    {
        /*if ($request->hasFile('csv_file')) {
            $uploadedFile = $request->file('csv_file');
            $filePath = $uploadedFile->getRealPath();
            $csvFile = new SplFileObject($filePath, 'r');
            $csvFile->setFlags(SplFileObject::READ_CSV | SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY);
            $data = [];

            foreach ($csvFile as $row) {
                $data[] = [
                    'name' => iconv('ISO-8859-1', 'UTF-8', $row[1]) ?? null,
                ];

                if (count($data) == 1000) {
                   DB::table('csv')->insert($data);// YourModel::insert($data);
                   // print_r($data);
                    $data = [];
                }
            }

            if (!empty($data)) {
                DB::table('csv')->insert($data);
            }

        }*/

    }


    /*public function show()
    {
        return view('upload_form');

    }

    public function upload(Request $request)
    {


        $file = $request->csv_file;

        $fileName = $file->getClientOriginalName();
        $file->move(public_path('upload'), $fileName);

        exit;
        $request->validate([
            'csv_file' => 'required',
        ]);
        echo "<pre>";

        $file = $request->file('csv_file');

        if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $data[] = [
                    'name' => iconv('ISO-8859-1', 'UTF-8', $row[1]) ?? null
                ];

                if (count($data) == 1000) {
                    DB::table('csv')->insert($data);// YourModel::insert($data);
                    // print_r($data);
                     $data = [];
                }
            }

            fclose($handle);
        }

        //Excel::import(new CsvImport, $file);
        //return redirect()->route('upload.form')->with('success', 'CSV file uploaded and processed successfully.');
    }*/


}
