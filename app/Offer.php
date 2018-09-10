<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'product_id',
        'price',
        'sales',
        'amount',
        'article',
    ];

    protected $casts = [
        'product_id' => 'integer',
        'price' => 'integer',
        'sales' => 'integer',
        'amount' => 'integer',
        'article' => 'string',
    ];

    protected $with = [
        'product',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function mostPopular()
    {
        return $this->orderByDesc('sales')->get()->unique('product_id')->take(20);
    }
}
