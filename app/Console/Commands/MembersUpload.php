<?php

namespace App\Console\Commands;

use App\Models\MemberDependant;
use App\Models\MemberIdentityType;
use Illuminate\Console\Command;
use App\Models\Member;

class MembersUpload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:membersUpload';

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
                    if($count>99){

                            $memberID = $dt[4];
                       //start:: check if Member already exist
                        $Member = Member::where('member_code', $memberID)->first();
                       //end:: check if Member already exist

                       if($Member){
                           $this->error($count.') !!!! Member with '.$memberID.' : already exists');
                        }else{
                            $this->info($count.') START:: Loading Members with MemberID : '.$memberID);
                            
                            if($dt[2]==''){ 
                                $id_type_id = 0; 
                            }else{
                                   $getID = MemberIdentityType::where('name',$dt[2])->first();
                                if($getID){
                                    $id_type_id = $getID->id;
                                }else{
                                    $id_type_id = 0; 
                                    $this->error($count.') Identity Type  Not recognized');
                                }
                            }

                            if($dt[15]==''){
                                $email='NULL';
                            }else{
                                $email=$dt[15];
                            }

                                    $member = new Member;
                                    $member->contributor_id=$dt[5];
                                    $member->title=str_replace('.','', $dt[1]);
                                    $member->member_salutation_id=0;
                                    $member->fname=$dt[8];
                                    $member->mname=$dt[9];
                                    $member->lname=$dt[10];
                                    $member->gender=$dt[11];
                                    $member->member_code=$dt[4];
                                    $member->id_type_id=$id_type_id;
                                    $member->id_number='NULL';
                                    $member->dob=$dt[12];
                                    $member->marital_status=$dt[13];
                                    $member->phone=$dt[14];
                                    $member->email=$email;
                                    $member->income=$dt[19];
                                    $member->service_start_at=$dt[6];
                                    $member->join_at=$dt[46];
                                    $member->postal_address=$dt[17];
                                    $member->physical_address='NULL';
                                    $member->picture='NULL';
                                    $member->status='ACTIVE';
                                    $member->password = password_hash( strtoupper($dt[8]), PASSWORD_BCRYPT, [ 'cost'=>10 ] );
                                    $member->password_status = 'DEFAULT';
                                    $member->password_changed_at =$dt[42];
                                    $member->created_by=$dt[41];
                                    $member->updated_by=$dt[41];
                                    $member->save();

                            $this->info($count.') END:: Loading Members with MemberID : '.$memberID);

                            $this->info($count.') START:: Loading Dependant with MemberID : '.$memberID);
                            //add father
                            if($dt[23]=='DECEASED' || $dt[23]=='DICEASED' || $dt[23]=='MAREHEMU' || $dt[23]=='LATE'){ 
                                $occupation = 'NONE';
                            }else if($dt[23]=='HOUSEWIFE' || $dt[23]=='MAMA WA NYUMBANI'){ 
                                $occupation = 'UNEMPLOYED';
                            }else if($dt[23]=='MAMA MCHUNGAJI' || $dt[23]=='PASTOR'){ 
                                $occupation = 'PASTOR'; 
                            }else if($dt[23]=='BUSINESSWOMAN' ||$dt[23]=='BUSINESSMAN' || $dt[23]=='MJASILIAMALI'|| $dt[23]=='MFANYABIASHARA'){ 
                                $occupation = 'BUSINESS';
                            }else if($dt[23]=='ASKARI'){ 
                                $occupation = 'EMPLOYED';
                            }else if($dt[23]=='MSTAAFU' || $dt[23]=='RETIRED'){ 
                                $occupation = 'RETIRED';
                            }else if($dt[23]=='MKULIMA' || $dt[23]=='FARMER'){ 
                                $occupation = 'FARMER';
                            }else{
                                $occupation = 'NONE';
                            }

                            $vital_status = $occupation=='DECEASED' ? 'DECEASED':'ALIVE';

                            $addDependant = new MemberDependant;
                            $addDependant->member_id=$member->id;
                            $addDependant->fname=$dt[20];
                            $addDependant->mname=$dt[21];
                            $addDependant->lname=$dt[22];
                            $addDependant->gender='MALE';
                            $addDependant->dob='NULL';
                            $addDependant->phone='NULL';
                            $addDependant->relationship='FATHER';
                            $addDependant->picture='NULL';
                            $addDependant->occupation=$occupation;
                            $addDependant->vital_status=$vital_status;
                            $addDependant->status='ACTIVE';
                            $addDependant->created_by=$dt[41];
                            $addDependant->updated_by=$dt[41];
                            $addDependant->save();

                            //add monther
                            if($dt[27]=='DECEASED' || $dt[27]=='DICEASED' || $dt[27]=='MAREHEMU' || $dt[27]=='LATE'){ 
                                $occupation2 = 'NONE';
                            }else if($dt[27]=='HOUSEWIFE' || $dt[27]=='MAMA WA NYUMBANI'){ 
                                $occupation2 = 'UNEMPLOYED';
                            }else if($dt[27]=='MAMA MCHUNGAJI' || $dt[27]=='PASTOR'){ 
                                $occupation2 = 'PASTOR'; 
                            }else if($dt[27]=='BUSINESSWOMAN' ||$dt[27]=='BUSINESSMAN' || $dt[27]=='MJASILIAMALI'|| $dt[27]=='MFANYABIASHARA'){ 
                                $occupation2 = 'BUSINESS';
                            }else if($dt[27]=='ASKARI'){ 
                                $occupation2 = 'EMPLOYED';
                            }else if($dt[27]=='MSTAAFU' || $dt[27]=='RETIRED'){ 
                                $occupation2 = 'RETIRED';
                            }else if($dt[27]=='MKULIMA' || $dt[27]=='FARMER'){ 
                                $occupation2 = 'FARMER';
                            }else{
                                $occupation2 = 'NONE';
                            }

                            $vital_status2 = $occupation2=='DECEASED' ? 'DECEASED':'ALIVE';

                            $addDependant = new MemberDependant;
                            $addDependant->member_id=$member->id;
                            $addDependant->fname=$dt[24];
                            $addDependant->mname=$dt[25];
                            $addDependant->lname=$dt[26];
                            $addDependant->gender='FEMALE';
                            $addDependant->dob='NULL';
                            $addDependant->phone='NULL';
                            $addDependant->relationship='MOTHER';
                            $addDependant->picture='NULL';
                            $addDependant->occupation=$occupation2;
                            $addDependant->vital_status=$vital_status2;
                            $addDependant->status='ACTIVE';
                            $addDependant->created_by=$dt[41];
                            $addDependant->updated_by=$dt[41];
                            $addDependant->save();

                            $this->info($count.') END:: Loading Dependant with MemberID : '.$memberID);
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
