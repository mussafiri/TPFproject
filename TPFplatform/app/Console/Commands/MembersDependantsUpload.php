<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MembersDependantsUpload extends Command
{
    //SELECT members.memid,members.memcode, members.fname, members.mname, members.sname,memfamily.memid, memfamily.fname, memfamily.mname, memfamily.sname,memfamily.gender,memfamily.dob,memfamily.mobile, memfamily.relationship,memfamily.certno,memfamily.hascertpic, memfamily.certpic FROM members INNER JOIN memfamily ON memfamily.memid=members.memid 
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:members-dependants-upload';

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
        //
    }
}
