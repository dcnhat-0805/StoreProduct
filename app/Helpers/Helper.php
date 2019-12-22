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

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Rating;
use App\Models\Wards;
use DateTime;
use DatePeriod;
use DateInterval;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\HomeController;
use App\Models\Category;
use Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Arr;
use Intervention\Image\ImageManagerStatic as ImageResize;

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

    /**
     * Get Sort Param
     *
     * @param array $params param
     *
     * @return string
     */
    public static function getSortParamFrontEnd($params)
    {
        $order = 'products.id desc';

        if (isset($params[SORT]) && $params[SORT] == 'popularity') {
            $order = 'products.id desc';
        }
        if (isset($params[SORT]) && $params[SORT] == 'priceasc') {
            $order = 'products.product_price asc, products.product_promotion asc';
        }
        if (isset($params[SORT]) && $params[SORT] == 'pricedesc') {
            $order = 'products.product_price desc, products.product_promotion desc';
        }

        return $order;
    }

    public static function setCheckedForm($name, $value, $status)
    {
        return isset($_GET[$name]) && (in_array($value, $_GET[$name])) || !isset($_GET[$name]) ? $status : "";
    }

    /**
     * Create Resize Image
     *
     * @param string  $imagePath image path
     * @param integer $width     width
     * @param integer $height    height
     */
    public static function createResizeImage($imagePath, $width, $height)
    {
        $imageResize = ImageResize::make($imagePath);
        $imageResize->resize($width, $height);

        $fileName = Helper::convertUnsupportedExtension($imageResize->basename);
        $pathUpload = $imageResize->dirname . "/". IMAGE_RESIZE_PREFIX . $fileName;
        $imageResize->save($pathUpload);
        \Storage::disk('local')->put(IMAGE_RESIZE_PREFIX.$fileName, file_get_contents($pathUpload), 'public');
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
    public static function getRemoteFileSize($file_size)
    {
        $size = $file_size;
        switch ($file_size) {
            case $file_size < 1024:
                $size = $file_size .' B'; break;
            case $file_size < 1048576:
                $size = round($file_size / 1024, 2) .' KB'; break;
            case $file_size < 1073741824:
                $size = round($file_size / 1048576, 2) . ' MB'; break;
            case $file_size < 1099511627776:
                $size = round($file_size / 1073741824, 2) . ' GB'; break;
        }

        return $size;
    }

    public static function getDataImage($filePath, $images)
    {
        $response['images'] = [];
        if (isset($images) && $images !== '0') {
                $dataImage = [];
                $dataImage['name'] = $images;
                $dataImage['url'] = $filePath . $images;
                $dataImage['size'] = Helper::getRemoteFileSize(file_exists($dataImage['url']) ? filesize($dataImage['url']) : 0 . 'KB');
//            $dataImage['url'] = asset(\Storage::url('app/' . $images));
//            $dataImage['size'] = Helper::getRemoteFileSize(\Storage::size($images));
                $response['images'][] = $dataImage;
        }

        return json_encode($response);
    }

    public static function getDataImageList($filePath, $images)
    {
        $response['images'] = [];
        if (isset($images) && count($images)) {
            foreach ($images as $image) {
                if ($image !== '0') {
                    $dataImage = [];
                    $dataImage['name'] = $image;
                    $dataImage['url'] = $filePath . $image;
//                    $dataImage['url'] = \Storage::url($image);
                    $dataImage['size'] = Helper::getRemoteFileSize(file_exists($dataImage['url']) ? filesize($dataImage['url']) : 0 . 'KB');
                    $response['images'][] = $dataImage;
                }
            }
        }

        return json_encode($response);
    }

    public static function getTitleName($titleName = null)
    {
        return (isset($titleName['product_category_name']) && !isset($titleName['product_type_name'])) ? $titleName['product_category_name']: $titleName['product_type_name'];
    }/**
 * Is Has Data By Pages
 *
 * @param $data
 *
 * @param $routeName
 *
 * @return string
 */
    public static function isHasDataByPages($data)
    {
        if (!count($data)) {
            $lastPages = $data->lastPage();
            $url = url()->full();

            if ($lastPages > 1) {
                return self::changeUrlNotData($url, 'page', $lastPages);
            } else {
                return self::changeUrlNotData($url, 'page', null);
            }
        }
    }

    /**
     * Change Url Not Data
     *
     * @param $url
     *
     * @param $key
     *
     * @param null $value
     *
     * @return string
     */
    public static function changeUrlNotData($url, $key, $value = null)
    {
        list($urlPart, $currentParam) = array_pad(explode('?', $url), 2, '');
        parse_str($currentParam, $params);
        unset($params[$key]);
        $newParam = http_build_query($params);
        $url = $newParam ? ($urlPart . '?' . $newParam) : $urlPart;

        if (strpos($url, '?') === false) {
            return $value ? ($url .'?'. $key .'='. $value) : $url;
        } else {
            return $value ? ($url .'&'. $key .'='. $value) : $url;
        }
    }

    public static function addToCart($product, $request)
    {
        $quantity = 1;
        $price = $product->product_price;

        if (isset($request['quantity']) && $request['quantity']) {
            $quantity = $request['quantity'];
        }

        if($product->product_promotion > 0){
            $price = $product->product_promotion;
        }

        $cart = [
            'id' => $product->id,
            'name' => $product->product_name,
            'qty' => $quantity,
            'price' => $price,
            'options' => [
                'image' => $product->product_image,
                'promotion' => $product->product_promotion > 0 ? $product->product_price : null,
                'description' => $product->product_description,
                'color' => $request['color'],
                'storage' => $request['storage'],
                'size' => $request['size'],
                'material' => $request['material'],
            ]
        ];

        return $cart;
    }

    public static function updateCart($request, $rowId)
    {
        $quantity = $request['quantity'];

        if ($quantity == 0) return;

        return Cart::update($rowId, $quantity);
    }

    public static function loadMoney($price)
    {
        return number_format($price,0,",",".") . ' ₫';
    }

    public static function loadPercentage($percentage)
    {
        return number_format($percentage,0,",",".") . '%';
    }

    public static function randomArrayKey($data)
    {
        $data = $data->pluck('id')->toArray();

        return Arr::random($data, 3);
    }

    public static function loadAddressByWardsId($wardsId)
    {
        $address = Wards::select('wards.path_with_type')
                ->join('districts', 'wards.parent_code', 'districts.code')
                ->join('cities', 'districts.parent_code', 'cities.code')
                ->where('wards.code', '=' , $wardsId)
                ->pluck('wards.path_with_type')
                ->first();

        return $address;
    }

    public static function getAddressByWardsId($wardsId)
    {
        $address = Wards::where('wards.code', '=' , $wardsId)
                ->select([
                    'wards.code as wardsId',
                    'districts.code as districtId',
                    'cities.code as cityId',
                ])
                ->join('districts', 'wards.parent_code', 'districts.code')
                ->join('cities', 'districts.parent_code', 'cities.code')
                ->first();

        return $address;
    }

    public static function getCountRatingByProductIdAndPoint($productId, $point)
    {
        return Rating::getCountRatingByPoint($productId, $point);
    }

    public static function getPointRatingByUserIdAndProductId($userId, $productId)
    {
        return Rating::getRatingByUserIdAndProductId($userId, $productId);
    }

    public static function loadStatusOrder($status)
    {
        if ($status == DELIVERY) {
            return 'Delivery';
        } elseif ($status == FINISH) {
            return 'Finish';
        } elseif ($status == CANCEL) {
            return 'Cancel';
        } else {
            return 'Pending';
        }
    }

    public static function loadClassStatusOrder($status)
    {
        if ($status == DELIVERY) {
            return 'status__delivery';
        } elseif ($status == FINISH) {
            return 'status__finish';
        } elseif ($status == CANCEL) {
            return 'status__cancel';
        } else {
            return 'status__pending';
        }
    }
    public static function getTimeAgo($time)
    {
        $time = strtotime($time);
        $etime = time() - $time;

        if( $etime < 1 )
        {
//            return 'less than '. $etime .' second ago';
            return 'Just finish';
        }

        $array = array( 12 * 30 * 24 * 60 * 60  =>  'year',
            30 * 24 * 60 * 60                   =>  'month',
            24 * 60 * 60                        =>  'day',
            60 * 60                             =>  'hour',
            60                                  =>  'minute',
            1                                   =>  'second'
        );

        foreach( $array as $secs => $str )
        {
            $d = $etime / $secs;

            if( $d >= 1 )
            {
                $r = round( $d );
                return $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
            }
        }
    }

    public static function getAttributeFilter($arrayProductId, $attributeName)
    {
        return ProductAttribute::getAttributeItemName($arrayProductId, $attributeName);
    }

    public static function getArrayProductId($products)
    {
        $arrayProductId = [];

        foreach ($products as $product) {
            array_push($arrayProductId, $product->id);
        }

        return $arrayProductId;
    }

    public static function getArrayDateBetweenFromTo($from, $to)
    {
        $begin = new \DateTime($from);
        $end = new \DateTime($to);

        $period = new \DatePeriod(
            $begin,
            new \DateInterval('P1D'),
            $end->modify('+1 day')
        );
        $date = [];
        foreach ($period as $key => $dt) {
            array_push($date, $dt->format("Y/m/d"));
        }

        return $date;
    }

    public static function getArrayStringDateBetweenFromTo($from, $to)
    {
        $arrayDates = self::getArrayDateBetweenFromTo($from, $to);

        $date = [];
        foreach ($arrayDates as $arrayDate) {
            array_push($date, $arrayDate . ',');
        }

        return $date;
    }

    public static function getArrayDateBetweenFromToMonth($from, $to)
    {
        $begin = new \DateTime($from);
        $end = new \DateTime($to);


        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($begin, $interval, $end);
        $date = [];

        foreach ($period as $key => $dt) {
            array_push($date, $dt->format("Y/m"));
        }

        return $date;
    }

    public static function getArrayStringDateBetweenFromToMonth($from, $to)
    {
        $arrayDates = self::getArrayDateBetweenFromToMonth($from, $to);

        $date = [];
        foreach ($arrayDates as $arrayDate) {
            array_push($date, $arrayDate . ',');
        }

        return $date;
    }

    /**
     * Is sort field by order
     *
     * @param $fieldName
     * @param $order
     *
     * @return bool
     */
    public static function isSortFieldByOrder($fieldName, $order)
    {
        if ($order == "asc") {
            return isset($_GET['sort']) && $_GET['sort'] == $fieldName && !isset($_GET['desc']);
        } else if ($order == "desc") {
            return isset($_GET['sort']) && $_GET['sort'] == $fieldName && isset($_GET['desc']);
        } else return false;
    }



    /**
     * @param $date
     * @return string
     */
    public static function formatDateWeekday($date)
    {
        $days = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");
        $date_format = date('D - Y M d', strtotime($date));

        return $date_format;
    }

    public static function getQuantityProductById($productId)
    {
        return Product::getQuantityProductById($productId);
    }

    public static function isRatingProduct($productId, $userId = null)
    {
        if (!$userId) return false;

        return Order::where('orders.user_id', $userId)
            ->where('product_id', $productId)
            ->select(
                'orders.id',
                'orders.user_id',
                'order_details.product_id'
            )
            ->join('order_details', 'order_details.order_id', 'orders.id')
            ->exists();
    }
}
