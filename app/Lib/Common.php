<?php
namespace App\Lib;
use App\Models\Contributor;
use App\Models\Member;
use App\Models\District;
use App\Models\Section;
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
        $codeFormat = 'TPF-MN000000'; //format
        $nextDigLength = mb_strlen($ID , "UTF-8");
        $createNewCodeSpace=substr($codeFormat,0,-$nextDigLength);
        $finalCode=$createNewCodeSpace.$ID;

        $putMemberCode = Member::find($ID);
        $putMemberCode->member_code = $finalCode;
        $putMemberCode->save();
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
    public function sectionCodeGenerator($ID,$section,$district_code){
        #substr()function to return the first two characters from the district name
        $s_code = substr($section,0,2);
        $codeFormat = $district_code.'-'.$s_code; //format
        $nextDigLength = mb_strlen($ID, "UTF-8");
        if($nextDigLength>1){
            $lastCodePart=$ID;
        }else{
            $lastCodePart='0'.$ID;
        }
        $finalCode=$codeFormat.$lastCodePart;

        $sectioncodeUpdateobj = Section::find($ID);
        $sectioncodeUpdateobj->section_code=$finalCode;
        $sectioncodeUpdateobj->save();
    }
}
