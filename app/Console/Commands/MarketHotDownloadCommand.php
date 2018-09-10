<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Filesystem;


/**
 * Download JSON from markethot.ru and save ii on the disk
 *
 * Class MarketHotGetCommand
 * @package App\Console\Commands
 */
class MarketHotDownloadCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'markethot:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download JSON from markethot.ru and save on the disk';


    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * MarketHot JSON URL
     * @var string
     */
    protected $jsonUrl = 'https://markethot.ru/export/bestsp';

    /**
     * Create a new command instance.
     *
     * @param Filesystem $filesystem
     * @return void
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->filesystem = $filesystem;
        $this->jsonUrl = config('markethot.jsonUrl');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $raw = file_get_contents($this->jsonUrl);

        if (!$raw) {
            $this->error("Error retrieving data");
            return false;
        }

        //Check the data
        $data = json_decode($raw, true);

        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            $this->error('JSON data is incorrect');
            return false;
        }

        if (!$this->filesystem->put('markethot.json', $raw)) {
            $this->error("Can't save data to the disk");
            return false;
        }

        $this->info('Data successfully downloaded');

        if ($this->confirm('Import data into the database?')) {
            $this->call('markethot:import');
        }
    }
}
