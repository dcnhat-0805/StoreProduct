<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    protected $table = 'menus';

    protected $fillable = [
        'menu_name', 'menu_slug',
        'menu_type', 'menu_link',
        'parent_id', 'menu_order',
        'menu_status'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function getListAllMenu()
    {
        return $this->select(
                'menu_name', 'menu_type',
                'menu_link', 'parent_id',
                'menu_order',  'menu_status')
            ->orderBy('id', 'DESC')->get();
    }

    public function getListMenu()
    {
        return $this->select(
                'menu_name', 'menu_type',
                'menu_link', 'parent_id',
                'menu_order',  'menu_status')
            ->orderBy('id', 'DESC')->paginate(5);
    }

    public function createMenu($request)
    {
        return $this->create($request);
    }

    public function showMenu($id_slide)
    {
        return $this->find($id_slide);
    }

    public function upadteMenu($id_slide, $request)
    {
        $slide = $this->showMenu($id_slide);
        return $slide->update($request);
    }

    public function deleteMenu($id_slide)
    {
        $slide = $this->showSlide($id_slide);
        return $slide->delete();
    }

    public function searchMenu($keyWord, $length)
    {
        if ($keyWord == '') {
            $menu = $this->select(
                'menu_name', 'menu_type',
                'menu_link', 'parent_id',
                'menu_order',  'menu_status')
                ->orderBy('id', 'DESC')
                ->offset(0)
                ->limit(5)
                ->get();
        } else {
            $menu = $this->select(
                'menu_name', 'menu_type',
                'menu_link', 'parent_id',
                'menu_order',  'menu_status')
                ->where('id', $keyWord)
                ->orWhere('order_Slide', $keyWord)->get();
        }

        if ($length != '') {
            $menu = Menu::orderBy('id', 'DESC')
                ->offset(0)
                ->limit($length)
                ->get();
        }
        return $menu;
    }
}
