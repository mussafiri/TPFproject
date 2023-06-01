<?php
namespace App\Lib;
use App\Models\Contributor;
use App\Models\Member;
use App\Models\District;
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
    public function districtCodeGenerator($ID,$district,$zone_code){
        #substr()function to return the first two characters from the district name
        $d_code = substr($district,0,2);
        $codeFormat = $zone_code.'-'.$d_code; //format
        $nextDigLength = mb_strlen($ID, "UTF-8");
        if($nextDigLength>1){
            $lastCodePart=$ID;
        }else{
            $lastCodePart='0'.$ID;
        }
        $finalCode=$codeFormat.$lastCodePart;

        $districtcodeUpdateobj = District::find($ID);
        $districtcodeUpdateobj->district_code=$finalCode;
        $districtcodeUpdateobj->save();
    }
}
