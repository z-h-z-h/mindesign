<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use TypiCMS\NestableTrait;
use Illuminate\Database\DatabaseManager;
use App\Offer;

class Category extends Model
{
    use NestableTrait;

    protected $fillable = [
        'id',
        'parent_id',
        'title',
        'alias',
    ];

    protected $casts = [
        'id' => 'integer',
        'parent_id' => 'integer',
        'title' => 'string',
        'alias' => 'string',
    ];

    /**
     * @var DatabaseManager $db
     */
    protected $db;

    /**
     * @var \App\Offer $offer
     */
    protected $offer;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    public function getRouteKeyName()
    {
        return 'alias';
    }

    /**
     * @return Collection
     */
    public function getTree()
    {
        return $this->orderBy('parent_id')->get()->nest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany('App\Product');
    }

    /**
     * @return mixed
     */
    public function getProductsWithOffers()
    {
        return $this->load('products.offers')->products;
    }


}
