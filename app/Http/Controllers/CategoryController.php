<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function show(Category $category)
    {
        $products = $category->getProductsWithOffers();

        return view('category', compact('category', 'products'));
    }

    public function showSubCategory(Category $parentCategory,  Category $category)
    {

        $products = $category->getProductsWithOffers();

        return view('category', compact('parentCategory', 'category', 'products'));
    }
}
