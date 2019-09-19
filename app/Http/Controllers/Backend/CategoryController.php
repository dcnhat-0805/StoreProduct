<?php

namespace App\Http\Controllers\Backend;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $params = request()->all();
        $category = Category::getListAllCategory($params);

        return view('backend.pages.category.list', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $user = Auth::guard('admins')->user();
        if ($user->can('createCategory', Admin::class)) {
            if ($request->ajax()) {
                $input = $request->all();
                $category = Category::createCategory($input);

                if ($category) {
                    Session::flash("success", trans("messages.category.create_success"));
                    return response()->json($category, 200);
                } else {
                    Session::flash("error", trans("messages.category.create_failed"));
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $user = Auth::guard('admins')->user();
        if ($user->can('updateCategory', Admin::class)) {
            if ($request->ajax()) {
                $input = $request->all();
                $category = Category::updateCategory($id, $input);

                if ($category) {
                    Session::flash("success", trans("messages.category.update_success"));
                    return response()->json($category, 200);
                } else {
                    Session::flash("error", trans("messages.category.update_failed"));
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $user = Auth::guard('admins')->user();
        if ($user->can('deleteCategory', Admin::class)) {
            $category = Category::deleteCategory($id);

            if (isset($category)) {
                Session::flash("success", trans("messages.category.delete_success"));
                return response()->json();
            } else {
                Session::flash("error", trans("messages.category.delete_failed"));
                return response()->json();
            }
        }
    }

    public function getListCategory()
    {
        $category = Category::getListAllCategory();$data = [];

        if (count($category)) {
            foreach ($category as $cate) {
                $data[] = [
                    'id' => $cate->id
                ];
            }
        }

        return response()->json(array_flatten($data));
    }

    public function destroy(Request $request)
    {
        $user = Auth::guard('admins')->user();
        if ($user->can('deleteCategory', Admin::class)) {
            try {
                Category::destroy($request->input('ids'));
                if ($request->input('ids') != DELETE_ALL) {
                    Session::flash("success", trans("messages.category.delete_success"));
                }
            } catch (\Exception $e) {
                Session::flash("error", trans("messages.category.delete_failed"));
            }
        }
    }
}
