<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slide extends Model
{
    use SoftDeletes;

    protected $table = 'slides';

    protected $fillable = [
        'slide_link', 'slide_content', 'slide_image', 'slide_order', 'slide_status',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function getListAllSlide()
    {
        return $this->select('slide_link', 'slide_content', 'slide_image', 'slide_order', 'slide_status')
            ->orderBy('id', 'DESC')->get();
    }

    public function getListSlide()
    {
        return $this->select('slide_link', 'slide_content', 'slide_image', 'slide_order', 'slide_status')
            ->orderBy('id', 'DESC')->paginate(5);
    }

    public function createSlide($request)
    {
        return $this->create($request);
    }

    public function showSlide($slide_id)
    {
        return $this->find($slide_id);
    }

    public function updateSlide($request, $slide_id)
    {
        $slide = $this->showSlide($slide_id);
        return $slide->update($request);
    }

    public function deleteSlide($slide_id)
    {
        $file_path = 'assets/uploads/image/product/slide/';
        $slide = $this->showSlide($slide_id);
        if (File::exists($file_path.$slide->image_Slide)) {
            unlink($file_path.$slide->image_Slide);
        }
        return $slide->delete();
    }

    public function searchSlide($keyWord, $length)
    {
        if ($keyWord == '') {
            $slide = Slide::orderBy('id', 'DESC')
                ->offset(0)
                ->limit(5)
                ->get();
        } else {
            $slide = Slide::where('id', $keyWord)
                ->orWhere('order_Slide', $keyWord)->get();
        }

        if ($length != '') {
            $slide = Slide::orderBy('id', 'DESC')
                ->offset(0)
                ->limit($length)
                ->get();
        }
        return $slide;
    }
}
