<?php

namespace App\Console\Commands;

use App\Models\Section;
use Illuminate\Console\Command;

class SectionsUpload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sectionsUpload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       $this->init();
    }

 //START:: Load bulk Investors' Contracts
    function init(){

        // $path  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $path=base_path();
        $path = $path.'/public/datauploads/sectionsUpload.csv';

        if(file_exists($path)){
                $this->info('DATA FILE FOUND - Sections UPLOAD HAS STARTED');

                $data = $this->readCSV($path, array('delimiter' => ';'));
                $count = 0;
                $this->info('Loading Sections');
                foreach($data AS $uploadingData){
                    $dataArr = explode(",", $uploadingData[0]);

                    if($count > 0){

                        $sectionName = $dataArr[3];

                        $this->info($count.') Loading Sections with sectionName : '.$sectionName.' STARTED >>>');

                        $createdAt=$dataArr[9].' '.$dataArr[10];

                        $sectionsUpload = new Section;
                        $sectionsUpload->district_id=$dataArr[1];
                        $sectionsUpload->section_code=$dataArr[2];
                        $sectionsUpload->name=$dataArr[3];
                        $sectionsUpload->postal_address=$dataArr[4];
                        $sectionsUpload->physical_address=$dataArr[5];
                        $sectionsUpload->phone=$dataArr[6];
                        $sectionsUpload->email=$dataArr[7];
                        $sectionsUpload->status='ACTIVE';
                        $sectionsUpload->created_by=$dataArr[8];
                        $sectionsUpload->created_at=$createdAt;
                        $sectionsUpload->updated_by=$dataArr[8];
                        $sectionsUpload->save();

                        $this->info($count.') Loading Sections with sectionName : '.$sectionName.' FINISHED >>>');

                    }

                    $count++;
                }

                $this->info('Loading Sections Finished');
        }else{
            $this->error('File is does not exist');
        }
    }

    public function readCSV($csvFile,$array){
        $file_handle = fopen($csvFile, 'r');
        while (!feof($file_handle)){
            $line_of_text[] = fgetcsv($file_handle, 0, $array['delimiter']);
        }

        fclose($file_handle);
        return $line_of_text;
    }
}
