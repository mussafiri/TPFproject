<?php 
    function minifiedNumberFormat($number){
        // first strip any formatting;
        $n = (0 + str_replace(",","",$number));

        // is this a number?
        if(!is_numeric($n)) return false;

        // now filter it;
        if($n>1000000000000) return number_format(round(($n/1000000000000),1))."T";
        else if($n>1000000000) return number_format(round(($n/1000000000),1))."B";
        else if($n>1000000) return round(($n/1000000),2)."M";
        else if($n>1000) return number_format($n/1000)."K";

        return number_format($n);

    }
    function convertToReadableFileSize($size) {
        $mod = 1024;
        $units = array('B','KB','MB','GB','TB');
        for ($i = 0; $size > $mod; $i++) {
            $size /= $mod;
        }
        return round($size, 2) . ' ' . $units[$i];
    }
?>