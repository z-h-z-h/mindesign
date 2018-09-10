<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Offer;
use App\Category;

class IndexController extends Controller
{
    /**
     * @var Product $product
     */
    protected $product;
    /**
     * @var Offer $offer
     */
    protected $offer;
    /**
     * @var Category $category
     */
    protected $category;
    /**
     * @var Request $request
     */
    protected $request;

    public function __construct(
        Product $product,
        Offer $offer,
        Category $category,
        Request $request)
    {
        $this->product = $product;
        $this->offer = $offer;
        $this->category = $category;
        $this->request = $request;
    }


    public function index()
    {
        $searchQuery = $this->request->post('searchQuery');

        if ($searchQuery) {
            $searchResults = $this->product->search($searchQuery)->get();
        }

        $offers = $this->offer->mostPopular();
        $categories = $this->category->getTree();

        return view('index', compact('offers', 'categories', 'searchQuery', 'searchResults'));
    }
}
