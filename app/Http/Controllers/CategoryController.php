<?php

namespace App\Http\Controllers;

use App\Category;
use Dotenv\Result\Success;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $categories=Category::all();
        return view('admin/categories',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    return view('admin/createCategory');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
          'name'=>'required|unique:categories',
          'status'=> 'required|in:active,disable',
          'description'=> 'required'

        ]);

        $category=new Category;
        $category->name=$request->name;
        $category->status=$request->status;
        $category->description=$request->description;
        $category->save();


           return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category =Category::findorfail($id);
       return view('admin/editCategory', compact('category'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {

        $validator = Validator::make($request->all(), [
            'name'=>'required|min:6|unique:categories',
            'status'=> 'required|in:active,disable',
            'description'=> 'required'

        ]);

          if ($validator->fails()) {
            return  back()->withErrors($validator);
        }        try{
            Category::where('id', $id)->update([
                'name' => $request->input('name'),
                'status' => $request->input('status'),
                'description' => $request->input('description')
            ]);

            return  redirect()->route('category.index')->with('success', 'success updated category');
        } catch (ModelNotFoundException $exception) {

            return back()->with('error', ' not found this category ');


        }
        }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


        try{
        $category =Category::findorfail($id);
        $category->delete();
        return back()->with("success","the category  deletion was successful");

        }catch(ModelNotFoundException $exception){
            return back()->with("error","not found this category");
        }

}}
