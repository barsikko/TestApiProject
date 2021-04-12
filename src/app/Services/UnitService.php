<?php 


namespace App\Services;

use App\Exceptions\UnitNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UnitService
{

	/**
	 * Gets list of units by username
	 * 
	 * @param string $name
	 * 
	 * @return \Illuminate\Database\Eloquent\Collection
	 * 
	 */
	
	public static function getUnitsByName(string $name)
	{
		$units = DB::table('units')->where('name', $name)->get();	
		
		if ($units->isEmpty()){
			throw new UnitNotFoundException();
		}
		 
		 return $units;
	}

	/**
	 * Get unit by categories name
	 * 
	 * @param string $category
	 * 
	 * @return \Illuminate\Database\Eloquent\Collection
	 * 
	 */
	
	public static function getUnitsByCategoryName(string $category)
	{

		$units = DB::table('units')
					->join('category_units', 'units.id', '=', 'category_units.unit_id')
					->join('categories', 'category_units.category_id', '=', 'categories.id')
					->where('categories.name', '=', $category)
					->select('units.id', 'units.name', 'units.amount', 'units.published')
					->get();

		if ($units->isEmpty()){
			throw new UnitNotFoundException();
		}
		 

		 return $units;

		 
	}

	/**
	 * Get units by min and max amount
	 * 
	 * @param float $min_amount
	 * @param float $max_amount
	 * 
	 * @return \Illuminate\Database\Eloquent\Collection
	 * 
	 */
	
	public static function getUnitsByAmount($min, $max)
	{

		$units = DB::table('units')
           ->whereBetween('amount', [$min, $max])
           ->get();
		 
        if ($units->isEmpty()){
			throw new UnitNotFoundException();
		}
		 

		 return $units;
	}

	/**
	 * Get published units
	 * 
	 * @param bollean $published
	 * 
	 * @return \Illuminate\Database\Eloquent\Collection
	 * 
	 */
	
	public static function getPublishedUnits($published)
	{

		$units = DB::table('units')
           ->where('published', $published)
           ->get();

        if ($units->isEmpty()){
			throw new UnitNotFoundException();
		}
		  
		 return $units;
	}

	/**
	 * Get undeleted units
	 * 
	 * @return \Illuminate\Database\Eloquent\Collection
	 * 
	 */
	
	public static function getUndeletedUnits()
	{

		$units = DB::table('units')
           ->whereNull('units.deleted_at')
           ->get();

        if ($units->isEmpty()){
			throw new UnitNotFoundException();
		}
		 
		 
		 return $units;
	}




}


?>