<?php
/**
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * PHP version 7.2
 *
 * @category  Helpers
 * @package   App\Helpers
 * @author    Duong Cong Nhat <nhat.dc@deha-soft.com>
 * @copyright 2019 store online
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @link      https://laravel.com Laravel(tm) Project
 */


namespace App\Helpers;

use App\Models\Area1Display;
use App\Models\Area2Search;
use App\Models\BlackList;
use App\Models\RatePlan;
use DateTime;
use DatePeriod;
use DateInterval;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\TopHTMLController;
use App\Models\ApplicantMessage;
use App\Models\Bar;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\City;
use App\Models\HotSearch;
use App\Models\ListRecruitHtml;
use App\Models\News;
use App\Models\PostView;
use App\Models\Recruit;
use App\Models\RequestApply;
use App\Models\Special;
use App\Models\TopArea;
use App\Models\TransportRoute;
use App\Models\CustomizeContent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\ImageManagerStatic as ImageResize;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\TransportStation;
use App\Models\AreaNearly;
use App\Models\RatePlanItem;

/**
 * Class Helper
 *
 * @category  Helpers
 * @package   App\Helpers
 * @author    Duong Cong Nhat <nhat.dc@deha-soft.com>
 * @copyright 2019 store online
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @link      https://laravel.com Laravel(tm) Project
 */
class Helper
{
    /**
     * Get asset version
     *
     * @param string $path path
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public static function asset($path)
    {
        $url = url($path);
        if ( file_exists(public_path($path)) ){
            return $url . '?v=' . filemtime(public_path($path));
        }

        return $url;
    }

    /**
     * Get Sort Param
     *
     * @param array $params param
     *
     * @return string
     */
    public static function getSortParam($params)
    {
        $order = '1 = 1';
        if (isset($params['sort']) && in_array($params['sort'], SORT_PARAMS_ALLOWED)) {
            $order = $params['sort'];
        }
        if (isset($params['sort']) && isset($params['desc'])) {
            $order .= " desc";
        }
        return $order;
    }

    public static function setCheckedForm($name, $value, $status)
    {
        return isset($_GET[$name]) && (in_array($value, $_GET[$name])) || !isset($_GET[$name]) ? $status : "";
    }

    /**
     * Convert Unsupported Extension Image
     *
     * @param $filePath
     *
     * @return string
     */
    public static function convertUnsupportedExtension($filePath)
    {
        $fileArr = explode('.', $filePath);
        $fileName = $fileArr[0] ?? '';
        $fileExtension = $fileArr[1] ?? '';

        if (in_array($fileExtension, ['jfif'])) {
            return $fileName . '.jpg';
        }

        return $filePath;
    }

    /**
     * @param $file_url
     * @param bool $formatSize
     * @return int|string|content-length
     */
    public static function getRemoteFilesize($file_url, $formatSize = true)
    {
        $head = array_change_key_case(get_headers($file_url, 1));
        // content-length of download (in bytes), read from Content-Length: field

        $clen = isset($head['content-length']) ? $head['content-length'] : 0;

        // cannot retrieve file size, return "-1"
        if (!$clen) {
            return -1;
        }

        if (!$formatSize) {
            return $clen;
            // return size in bytes
        }

        $size = $clen;
        switch ($clen) {
            case $clen < 1024:
                $size = $clen .' B'; break;
            case $clen < 1048576:
                $size = round($clen / 1024, 2) .' KB'; break;
            case $clen < 1073741824:
                $size = round($clen / 1048576, 2) . ' MB'; break;
            case $clen < 1099511627776:
                $size = round($clen / 1073741824, 2) . ' GB'; break;
        }

        return $size;
        // return formatted size
    }
}
