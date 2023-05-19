<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ContributorsUpload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:contributors-upload';

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
 //  //START:: Load bulk Investors' Contracts
     function init(){

         // $path  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
         $path=base_path();
         $path = $path.'/public/datauploads/contributorsUpload.csv';

         if(file_exists($path)){
                 $this->info('DATA FILE FOUND - CONTRIBUTORS UPLOAD HAS STARTED');

                 $data = $this->readCSV($path, array('delimiter' => ';'));
                 $count = 0;
                 $this->info('Loading Contributors');
                 foreach($data AS $uploadingData){
                             $dt    = explode(",", $uploadingData[0]);
                         if($count>1){
                             $fname = $dt[3];

                        //start:: check if contributor already exist
                         $user = ::where('email', $email)->first();
                        //end:: check if contributor already exist

                         if($user){
                                 $this->info($count.')LOADING INVESTOR CONTRACT FOR EMAIL: '.$email.' INVEST AMOUNT =>'.$dt[10]);

                                 $package = Package::where('title',$package_title)->first(); // checking for package

                                 if(!empty($package->id)){
                                     if(empty($postal_address)){ $postal_address='-'; }else{ $postal_address= $postal_address;}
                                     if(empty($physical_address)){ $physical_address='-';}else{ $physical_address= $physical_address;}
                                     if(empty($cell_number)){ $cell_number='-';}else{ $cell_number= $cell_number;}
                                     if(empty($id_number)){ $id_number='-';}else{ $id_number= $id_number;}
                                     if(empty($title)){ $title='Mx';}else{ $title= $title;}

                                     Contract::create([
                                         'user_id'              =>$user->id,
                                         'package_id'           =>$package->id,
                                         'id_number'            =>$id_number,
                                         'title'                =>$title,
                                         'name'                 =>$user->first_name.' '.$user->last_name,
                                         'email'                =>$email,
                                         'cell_number'          =>$cell_number,
                                         'postal_address'       =>$postal_address,
                                         'physical_address'     =>$physical_address,
                                         'amount_invested'      =>$amount_invested,
                                         'interest_rate'        =>$interest_rate,
                                         'monthly_return'       =>$monthly_return,
                                         'contract_type'        =>'investment',
                                         'investment_date'      =>$investment_date,// Waiting
                                         'status'               =>'active'
                                     ]);

                                     $this->info(' >>>>> Contract Created');

                                 }else{
                                     $this->error($count.') !!!! PACKAGE NOT FOUND FOR Owner Email: '.$email);
                                 }

                         }else{
                             $this->error($count.') !!!! User with '.$email.' Could not be found on investors register');
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
