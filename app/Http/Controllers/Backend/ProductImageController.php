<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Helper;
use App\Models\ProductImage;
use App\Services\UploadService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class ProductImageController extends Controller
{

    public function uploadImageList(Request $request)
    {
        if ($request->ajax()) {
            if ($request->hasFile('file')) {
//                $type = $request->get('type');
//                $fileExtExplode = explode('.', $_FILES['file']['name']);
//                $file_ext = end($fileExtExplode);
//                $helper_text = uniqid() . "-" . time();
//                $fileName = 'product-' . $helper_text . ".$file_ext";
//                $path_upload = FILE_PATH_PRODUCT . $fileName;
//                move_uploaded_file($_FILES["file"]["tmp_name"], $path_upload);
//
//                ImageOptimizer::optimize($path_upload);
//                Helper::createResizeImage($path_upload, IMAGE_RESIZE_WIDTH, IMAGE_RESIZE_HEIGHT);
//
//                // upload to s3
//                \Storage::disk('local')->put($fileName, file_get_contents($path_upload), 'public');
//
//                $data = [
//                    'name' => $fileName,
////                    'url' => FILE_PATH_PRODUCT . $fileName,
//                    'url' => \Storage::url($fileName),
//                    'size' => Helper::getRemoteFileSize(\Storage::size($fileName)),
//                ];
//
//                Session::push(SESSION_LIST_PRODUCT_IMAGE.$type, $data);
//
//                return $data;
                $fileName = UploadService::moveImage(FILE_PATH_PRODUCT_IMAGE, $request->file('file'), PREFIX_PRODUCT_DETAIL);
                $type = $request->get('type');
                $size = UploadService::getFileSize($request->file('file'));
                $size = Helper::getRemoteFilesize($size);

                $data = [
                    'name' => $fileName,
                    'url' => asset(FILE_PATH_PRODUCT_IMAGE . $fileName),
                    'size' => $size
                ];

                Session::push(SESSION_LIST_PRODUCT_IMAGE.$type, $data);

                return $data;
            }
        }
    }

    /**
     * Get images
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getImageList(Request $request)
    {
        if ($request->ajax()) {
            $type = $request->get('type');
            $images = Session::get(SESSION_LIST_PRODUCT_IMAGE.$type);
            $response = [];

            $response['images'] = [];
            if (isset($images) && count($images)) {
                foreach ($images as $image) {
                    $dataImage = [];
                    $dataImage['name'] = $image['name'];
                    $dataImage['url'] = $image['url'];
                    $dataImage['size'] = $image['size'];
                    $response['images'][] = $dataImage;
                }
            }

            return response()->json($response);
        }
    }

    public function deleteImageList()
    {
        if (request()->ajax()) {
            $fileName = request()->get('fileName');
            $type = request()->get('type');
            $sessionProductImages = Session::get(SESSION_LIST_PRODUCT_IMAGE.$type);
//            ProductImage::deleteProductImageByName($fileName);

            return response('success', 200);
//            if ($sessionProductImages !== null) {
//                foreach ($sessionProductImages as $k => $image) {
//                    if (trim($image) == trim($fileName)) {
//                        session()->pull(SESSION_LIST_PRODUCT_IMAGE.$type . $k);
//                    }
//                }
//            }

        }

    }
}
