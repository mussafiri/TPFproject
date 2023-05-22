<?php

namespace App\Console\Commands;

use App\Models\Contribution;
use Illuminate\Console\Command;

class ContributionsUpload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:contributions-upload';

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
            $this->info( 'DATA FILE FOUND - contributions UPLOAD HAS STARTED' );

            $data = $this->readCSV( $path, array( 'delimiter' => ';' ) );
            $count = 0;
            $this->info( 'Loading contributions' );
            foreach ( $data AS $uploadingData ) {
                $dt    = explode( ',', $uploadingData[ 0 ] );
                if ( $count>1 ) {
                    $fname = $dt[ 3 ];
                    $contributorID = $dt[ 4 ];

                    //start:: check if CONTRIBUTIONS already exist
                    $CONTRIBUTIONS = Contribution::where( 'contributor_id', $contributorID )->first();
                    //end:: check if CONTRIBUTIONS already exist

                    if ( $CONTRIBUTIONS ) {
                        $this->info( $count.')LOADING WITH CONTRIBUTIONS WITH ID : '.$contributorID );
                    } else {
                        $this->error( $count.') !!!! CONTRIBUTIONS with '.$contributorID.' Could not be found on CONTRIBUTIONS register' );
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
