<?php

namespace App\Console\Commands;

use App\Lib\Common;
use App\Models\Contribution;
use App\Models\Section;
use Illuminate\Console\Command;

class ArrearCheck extends Command {
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'app:arrear-check';

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
        $cmn = new Common();

        // if ( date( 'Y-m-d H:i' ) == date( 'Y-m-01 00:01' ) ) {
            if ( date( 'Y-m-d H:i' ) == date( 'Y-m-d H:i') ) {

            $contributioPeriod = date( 'Y-m' );
            $getSections = Section::where( 'status', 'ACTIVE' )->limit(2)->get();
            
            $count =1;
            foreach ( $getSections as $data ) {
                $checkContribution = Contribution::where( 'section_id', $data->id )->where( 'contribution_period', $contributioPeriod )->where( 'processing_status', 'POSTED' )->get();
                
                if ( $checkContribution->count() == 0 && $count==1) {
                    
                    $this->info( $count.') >>> Register Arrear for Section :: '.$data->name.' Contribution Period:: '.$contributioPeriod );

                    $cmn->arrearRegister( $data->id, $contributioPeriod );
               
                    $count++;
                }
            }

        }

    }
}
