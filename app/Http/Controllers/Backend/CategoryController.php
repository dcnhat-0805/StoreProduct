<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
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
        $category = Category::getListAllCategory();
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
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
