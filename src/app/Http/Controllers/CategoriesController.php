<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Response;

class CategoriesController extends Controller
{
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\CategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        Category::create($request->all());

        return response()->json('Data was added successefull', Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $category = Category::findOrFail($id);
    	
    	if (count($category->units) !== 0){
    		return response()->json('This category has products you can not delete it',  Response::HTTP_UNPROCESSABLE_ENTITY);
    	}
         
         $category->delete();

         return response()->json('Data was deleted successefull',  Response::HTTP_OK);

    }
}
