<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UsersUpload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:usersUpload';

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
        $path = $path.'/public/datauploads/usersUpload.csv';

        if(file_exists($path)){
                $this->info('DATA FILE FOUND - USERS UPLOAD HAS STARTED');

                $data = $this->readCSV($path, array('delimiter' => ';'));
                $count = 0;
                $this->info('Loading Users');
                foreach($data AS $uploadingData){
                            $dataArr = explode(",", $uploadingData[0]);
                        if($count>32){
                            $userEmail = $dataArr[6];

                       //start:: check if Member already exist
                        $Member = User::where('email', $userEmail)->first();
                       //end:: check if Member already exist

                       if($Member){
                           $this->error($count.') !!!! Member with '.$userEmail.' : Already exists');
                        }else{
                            $this->info($count.') Loading Users with userEmail : '.$userEmail.' STARTED >>>');

                            $status=$dataArr[14]=='A'?"ACTIVE":"BLOCKED";
                            $createdAt=$dataArr[16].' '.$dataArr[17];

                            $userUpload = new User;
                            $userUpload->old_id=$dataArr[1];
                            $userUpload->fname=$dataArr[2];
                            $userUpload->mname=$dataArr[3];
                            $userUpload->lname=$dataArr[4];
                            $userUpload->gender=$dataArr[5];
                            $userUpload->email=$dataArr[6];
                            $userUpload->phone=$dataArr[7];
                            $userUpload->avatar='NULL';
                            $userUpload->password=$dataArr[12];
                            $userUpload->dob='NULL';
                            $userUpload->physical_address='NULL';
                            $userUpload->dept_id=1;
                            $userUpload->designation_id=1;
                            $userUpload->created_by=1;
                            $userUpload->updated_by=0;
                            $userUpload->last_login='NULL';
                            $userUpload->status=$status;
                            $userUpload->created_at=$createdAt;
                            $userUpload->password_status="DEFAULT";
                            $userUpload->password_changed_at='NULL';
                            $userUpload->save();

                            $this->info($count.') Loading Users with userEmail : '.$userEmail.' FINISHED >>>');
                        }
                    }
                    $count++;
                }
                $this->info('Loading Users Finished');
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
