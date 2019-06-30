<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scraping extends Model
{
    public function scopequoteAndAccess ($match) {
dd($match);
        preg_match(
            '/<div class="itemInfo">(.*?)<\/div>/s',
            $match,
            $quoteAndAccess
        );
        // htmlタグを除去する。
        $quoteAndAccessTagExclusion = strip_tags($quoteAndAccess[0], '');

        // 複数スペースを１つのスペースにする。
        $quoteAndAccessTagExclusion = preg_replace("/\s+/", " ", trim($quoteAndAccessTagExclusion));

        // 変数として格納する。
        $quoteAndAccessResult = explode(' ',$quoteAndAccessTagExclusion);

        return $quoteAndAccessResult;
    }


    public function scopemovieTime ($match) {
        preg_match(
            '/<span class="movieTime">(.*?)<\/span>/s',
            $match,
            $movieTime
        );

        return $movieTime;
    }

}
