<?php

namespace App\Console\Commands;

use App\Category;
use App\CategoryProduct;
use App\Product;
use App\Offer;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Filesystem;


/**
 * Import markethot data into database
 *
 * Class MarketHotImportCommand
 * @package App\Console\Commands
 */
class MarketHotImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'markethot:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import markethot data into database';

    /**
     * @var Filesystem
     */
    protected $filesystem;
    /**
     * @var Product
     */
    protected $product;

    /**
     * @var Offer
     */
    protected $offer;
    /**
     * @var Category
     */
    protected $category;
    /**
     * @var CategoryProduct
     */
    protected $categoryProduct;

    /**
     * Local file with JSON data
     * @var string
     */
    protected $jsonFile;


    /**
     * Create new command instance.
     *
     * @param Filesystem $filesystem
     * @param Product $product
     * @param Offer $offer
     * @param Category $category
     * @param CategoryProduct $categoryProduct
     */
    public function __construct(
        Filesystem $filesystem,
        Product $product,
        Offer $offer,
        Category $category,
        CategoryProduct $categoryProduct
    )
    {
        parent::__construct();

        $this->filesystem = $filesystem;
        $this->product = $product;
        $this->offer = $offer;
        $this->category = $category;
        $this->categoryProduct = $categoryProduct;
        $this->jsonFile = config('markethot.jsonFile');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!$this->filesystem->exists($this->jsonFile)) {
            $this->error($this->jsonFile . ' not found. Execute markethot:download');
            return false;
        }

        $data = json_decode($this->filesystem->get($this->jsonFile), true);

        $this->dropOldData();

        $this->importData($data);

        $this->info('Data successfully imported');
    }

    /**
     * Drop old markethot data from DB
     */
    public function dropOldData()
    {
        $this->product->query()->delete();
        $this->offer->query()->delete();
        $this->category->query()->delete();
        $this->categoryProduct->query()->delete();

        $this->info('Old data deleted');
    }

    /**
     * Import data to DB
     * @param array $data
     */
    public function importData(array $data)
    {
        $products = [];
        $offers = [];
        $categories = [];
        $categoryProductRelations = [];

        foreach ($data['products'] as $product) {
            $products[$product['id']] = [
                'id' => $product['id'],
                'title' => $product['title'],
                'image' => $product['image'],
                'description' => $product['description'],
                'price' => $product['price'],
                'amount' => $product['amount'],
                //'offers' => json_encode($product['offers']),
            ];

            foreach ($product['offers'] as $offer){
                $offers[] = [
                    'product_id' => $product['id'],
                    'price'=> $offer['price'],
                    'sales' => $offer['sales'],
                    'amount' => $offer['amount'],
                    'article' => $offer['article'],
                ];
            }

            foreach ($product['categories'] as $category) {
                $categories[$category['id']] = [
                    'id' => $category['id'],
                    'parent_id' => $category['parent'],
                    'title' => $category['title'],
                    'alias' => $category['alias'],
                ];

                $categoryProductRelations[] = [
                    'product_id' => $product['id'],
                    'category_id' => $category['id'],
                ];
            }
        }

        $this->storeProducts($products);
        $this->storeOffers($offers);
        $this->storeCategories($categories);
        $this->storeCategoryProductRelations($categoryProductRelations);
    }


    /**
     * Bulk save products to DB
     * @param array $products
     */
    public function storeProducts(array $products)
    {
        $this->product->insert($products);
        $this->info("Products: " . count($products));

    }

    /**
     * Bulk save offers to DB
     * @param array $offers
     */
    public function storeOffers(array $offers)
    {
        $this->offer->insert($offers);
        $this->info("Offers: " . count($offers));

    }

    /**
     * Bulk save categories to DB
     * @param array $categories
     */
    public function storeCategories(array $categories)
    {
        $this->category->insert($categories);
        $this->info("Categories: " . count($categories));

    }

    /**
     * Bulk save category_product many to many relations
     * @param array $categoryProductRelations
     */
    public function storeCategoryProductRelations(array $categoryProductRelations)
    {
        $this->categoryProduct->insert($categoryProductRelations);
        $this->info("Relations: " . count($categoryProductRelations));

    }
}
