<?php
namespace App\Lib;
use App\Models\Contributor;
use App\Models\Member;
use Carbon\Carbon;

class Common {
    public function contributorCodeGenerator($ID){
        $codeFormat = 'TPF-CN000000'; //format
        $nextDigLength = mb_strlen($ID , "UTF-8");
        $createNewCodeSpace=substr($codeFormat,0,-$nextDigLength);
        $finalCode=$createNewCodeSpace.$ID;

        $putContributorCode = Contributor::find($ID);
        $putContributorCode->contributor_code=$finalCode;
        $putContributorCode->save();
    }

    public function memberCodeGenerator($ID){
        $codeFormat = 'TPF-MB000000'; //format
        $nextDigLength = mb_strlen($ID , "UTF-8");
        $createNewCodeSpace=substr($codeFormat,0,-$nextDigLength);
        $finalCode=$createNewCodeSpace.$ID;

        $putContributorCode = Member::find($ID);
        $putContributorCode->contributor_code=$finalCode;
        $putContributorCode->save();
    }
}
