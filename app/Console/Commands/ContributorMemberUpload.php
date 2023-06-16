<?php

namespace App\Console\Commands;

use App\Models\ContributorMember;
use Illuminate\Console\Command;

class ContributorMemberUpload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:contributorMemberUpload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle() {
        $this->init();
    }

    function init() {

        // $path  = Storage::disk( 'local' )->getDriver()->getAdapter()->getPathPrefix();
        $path = base_path();
        $path = $path.'/public/datauploads/contributorMemberUpload.csv';

        if ( file_exists( $path ) ) {
            $this->info( 'DATA FILE FOUND' );

            $this->info( '===== CONTRIBUTOR MEMBERS UPLOAD HAS STARTED' );

            $data = $this->readCSV( $path, array( 'delimiter' => ';' ) );
            $count = 0;

            foreach ( $data AS $uploadingData ) {
                $dataArr    = explode( ',', $uploadingData[ 0 ] );

                if ( $count > 0 ) {
                    $this->info( $count.') Loading Contributor Member Assignment' );
                    $contributorID = $dataArr[ 1 ];
                    $memberID      = $dataArr[ 2 ];
                    $assignedDate  = date('Y-m-d', strtotime($dataArr[ 3 ]));

                    $status        = $dataArr[ 4 ]=="A"?"ACTIVE":"DORMANT";

                    //start:: check if contributor already exist
                    $contributor = ContributorMember::where('member_id',$memberID)->where( 'contributor_id', $contributorID )
                    // ->where( 'status', 'ACTIVE' )
                    ->orderBy('id', 'ASC')
                    ->get();

                    if ( $contributor->count() > 0) {
                        $this->info( 'a) ---- Check if there many Contributor Member Pairs' );
                    
                        foreach($contributor as $contributorData){
                            //get Start Date
                                if ($contributorData->status=='ACTIVE') {
                                    if($status=='ACTIVE'){
                                        $this->info( '>>> ---- i. Deactivating old  Contributor Member pair' );
                                        $addNewPair = ContributorMember::find($contributorData->id);
                                        $addNewPair->end_date  = $assignedDate;
                                        $addNewPair->updated_by=1;
                                        $addNewPair->status    ='DORMANT';
                                        $addNewPair->save();   
                                    }
                                }
                        }
                                $addNewPair= new ContributorMember;
                                $addNewPair->contributor_id = $contributorID;
                                $addNewPair->member_id      = $memberID;
                                $addNewPair->start_date     = $assignedDate;
                                $addNewPair->end_date       = 'NULL';
                                $addNewPair->created_by     = 1;
                                $addNewPair->status         = $status;
                                $addNewPair->save();
                
                    }else{
                        $this->info( '>>> b. i) ---- Creating a new Contributor Member pair' );

                        $addNewPair= new ContributorMember;
                        $addNewPair->contributor_id = $contributorID;
                        $addNewPair->member_id      = $memberID;
                        $addNewPair->start_date     = $assignedDate;
                        $addNewPair->end_date       = 'NULL';
                        $addNewPair->created_by     = 1;
                        $addNewPair->status         = $status;
                        $addNewPair->save();
                    }
                    //end:: check if contributor already exist
                }
                $count++;
            }

            $this->info( ' ===== CONTRIBUTOR MEMBERS UPLOADING FINISHED' );
        } else {
            $this->error( 'File is does not exist' );
        }
    }

    public function readCSV( $csvFile, $array ) {
        $file_handle = fopen( $csvFile, 'r' );
        while ( !feof( $file_handle ) ) {
            $line_of_text[] = fgetcsv( $file_handle, 0, $array[ 'delimiter' ] );
        }

        fclose( $file_handle );
        return $line_of_text;
    }
}
