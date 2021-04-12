<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitRequest;
use App\Models\Category;
use App\Models\Unit;
use App\Services\UnitService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UnitsController extends Controller
{
    /**
     * Displays a list of the units by parameters.
     * 
     * @param string name
     * @param integer id
     * @param string category
     * @param integer min_amount|max_amount
     * @param boolean published
     * @param boolean undeleted
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    	if ($request->name){
    		$units = UnitService::getUnitsByName($request->name);
		}

		if ($request->category){
			$units = UnitService::getUnitsByCategoryName($request->category);	
		}

		if ($request->min_amount || $request->max_amount){
			$units = UnitService::getUnitsByAmount($request->min_amount ?? 0, $request->max_amount);
		}

		if (isset($request->published)){
			$units = UnitService::getPublishedUnits($request->published);
		}

		if ($request->undeleted == 1){
			$units = UnitService::getUndeletedUnits();
		}

	
		if (!isset($units)){
			return response()->json('Error: Request value is not correct', Response::HTTP_UNPROCESSABLE_ENTITY);
		}




        return response()->json($units, Response::HTTP_OK);
    }

 	/**
     * Show specific untit by id
     *
     * @param  App\Http\Requests\UnitRequest  $request
     * @return \Illuminate\Http\Response
     */


    public function show($id)
    {
    	$unit = Unit::findOrFail($id);

    	return $unit;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\UnitRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitRequest $request)
    {
    	
    	$categories = $request->categories ?? [];

		if (count($categories) < 2 || count($categories) > 10)
    	{
    		return response()->json('Categories count must be from 2 to 10', Response::HTTP_UNPROCESSABLE_ENTITY);
    	}

    	  $unit = Unit::create([
     		   	'name' => $request->name,
        		'amount' => $request->amount
        		]);


    		foreach($categories as $category)
    		{
    			$cat = new Category;
    			$cat->fill($category);
    			$cat->save();
    			$unit->categories()->attach($cat);
    		}

        return response()->json('Your parameters are stored successefully', Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $unit = Unit::findOrFail($id);

        $unit->fill($request->all());

        if ($unit->isClean()) {
            return response()->json('You did not make any chages', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $unit->save();

        return response()->json('Changes are made successefull', Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
         $unit = Unit::findOrFail($id);
         $unit->categories()->detach();
         $unit->delete();

         return response()->json('Product was deleted successefull',  Response::HTTP_OK);

    }
}
