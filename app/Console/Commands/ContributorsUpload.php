<?php

namespace App\Console\Commands;

use App\Models\ContributorContactPerson;
use Illuminate\Console\Command;
use App\Models\Contributor;

class ContributorsUpload extends Command {
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'app:contributorsUpload';

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
        $path = $path.'/public/datauploads/contributorsUpload.csv';

        if ( file_exists( $path ) ) {
            $this->info( 'DATA FILE FOUND - CONTRIBUTORS UPLOAD HAS STARTED' );

            $data = $this->readCSV( $path, array( 'delimiter' => ';' ) );
            $count = 0;
            $this->info( 'Loading Contributors' );
            foreach ( $data AS $uploadingData ) {
                $dataArr    = explode( ',', $uploadingData[ 0 ] );
                if ( $count>2530 ) {
                    $contributorID = $dataArr[ 1 ];

                    //start:: check if contributor already exist
                    $contributor = Contributor::where( 'contributor_code', $contributorID )->first();
                    //end:: check if contributor already exist

                    if ( $contributor ) {
                        $this->error( $count.') !!!! Contributor with '.$contributorID.' already Exist' );
                    } else {

                        $this->info( $count.') START LOADING WITH CONTRIBUTOR WITH ID : '.$contributorID );

                        $status=$dataArr[4]=='A'?"ACTIVE":"SUSPENDED";

                        $addContributor= new Contributor;
                        $addContributor->section_id=$dataArr[5];
                        $addContributor->contributor_code=$dataArr[1];
                        $addContributor->name=$dataArr[2];
                        $addContributor->contributor_type_id=$dataArr[3];
                        $addContributor->postal_address=$dataArr[7];
                        $addContributor->physical_address=$dataArr[6];
                        $addContributor->phone=$dataArr[9];
                        $addContributor->email=$dataArr[10];
                        $addContributor->status=$status;
                        $addContributor->reg_form='NULL';
                        $addContributor->created_by=$dataArr[26];
                        $addContributor->created_at=$dataArr[27].' '.$dataArr[28];
                        $addContributor->updated_by=$dataArr[26];
                        $addContributor->save();

                        $this->info( $count.') END LOADING WITH CONTRIBUTOR WITH ID : '.$contributorID );

                        
                        $this->info( $count.') START LOADING CONTRIBUTOR CONTACT PERSON FOR : '.$contributorID );

                        $addContactPerson = new ContributorContactPerson;
                        $addContactPerson->contributor_id=$addContributor->id;
                        $addContactPerson->name=$dataArr[14];
                        $addContactPerson->title=$dataArr[15];
                        $addContactPerson->phone=$dataArr[16];
                        $addContactPerson->email=$dataArr[17];
                        $addContactPerson->status='ACTIVE';
                        $addContactPerson->created_by=$dataArr[26];
                        $addContactPerson->updated_by=$dataArr[26];
                        $addContactPerson->save();

                        $this->info( $count.') START LOADING CONTRIBUTOR CONTACT PERSON FOR : '.$contributorID );
                    }
                }
                $count++;
            }
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
