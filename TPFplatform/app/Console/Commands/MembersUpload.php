<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Member;

class MembersUpload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:members-upload';

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
        $path = $path.'/public/datauploads/membersUpload.csv';

        if(file_exists($path)){
                $this->info('DAT FILE FOUND - MEMBERS UPLOAD HAS STARTED');

                $data = $this->readCSV($path, array('delimiter' => ';'));
                $count = 0;
                $this->info('Loading Members');
                foreach($data AS $uploadingData){
                            $dt    = explode(",", $uploadingData[0]);
                        if($count>1){
                            $fname = $dt[3];
                            $memberID = $dt[4];

                       //start:: check if Member already exist
                        $Member = Member::where('email', $memberID)->first();
                       //end:: check if Member already exist

                       if($Member){
                           $this->error($count.') !!!! Member with '.$memberID.' : Already exists');
                        }else{
                            $this->info($count.') Loading Members with MemberID : '.$memberID);
                        }
                    }
                    $count++;
                }
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
