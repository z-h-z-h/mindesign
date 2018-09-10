<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;


class Product extends Model
{
    use SearchableTrait;

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'products.title' => 10,
            'products.description' => 5,
        ],
    ];

    protected $fillable = [
        'id',
        'title',
        'image',
        'description',
        'price',
        'amount',
        'offers',
    ];

    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'image' => 'string',
        'description' => 'string',
        'price' => 'integer',
        'amount' => 'integer',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function offers()
    {
        return $this->hasMany('App\Offer');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function category()
    {
        return $this->belongsToMany('App\Category')->whereNull('parent_id');
    }
}
