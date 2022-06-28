<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Service;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Muestra los servicios filtrados por una categoria.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return view('CategoriesAndCities.index', [
            'categories' =>Category::pluck('name', 'id'),
            'cities' =>City::pluck('name', 'id'),
            'services' =>Service::where('category_id', '=', $id)->paginate(5),
            'filter'=>Category::where('id', '=', $id)->first()
        ]);
    }
}
