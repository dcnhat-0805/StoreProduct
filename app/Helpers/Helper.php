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
}
