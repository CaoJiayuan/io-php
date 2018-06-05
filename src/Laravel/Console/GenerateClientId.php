<?php
/**
 * Created by PhpStorm.
 * User: cjy
 * Date: 2018/6/5
 * Time: 下午2:58
 */

namespace CaoJiayuan\Io\Laravel\Console;


use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateClientId extends Command
{
    protected $signature = 'io-php:id
        {--f|force : Skip confirmation when overwriting an existing id.}';


    protected $description = 'Generate io client id';

    public function handle()
    {
        $id = Str::random(32);


        if (file_exists($path = $this->envPath()) === false) {
            return $this->displayId($id);
        }

        if (Str::contains(file_get_contents($path), 'IO_CLIENT_ID') === false) {
            // update existing entry
            file_put_contents($path, PHP_EOL."IO_CLIENT_ID=$id", FILE_APPEND);
        } else {
            if ($this->isConfirmed() === false) {
                $this->comment('No changes were made to your client id.');

                return;
            }

            // create new entry
            file_put_contents($path, str_replace(
                'IO_CLIENT_ID='.$this->laravel['config']['io-php.credentials._id'],
                'IO_CLIENT_ID='.$id, file_get_contents($path)
            ));
        }

        $this->displayId($id);
    }

    /**
     * Check if the modification is confirmed.
     *
     * @return bool
     */
    protected function isConfirmed()
    {
        return $this->option('force') ? true : $this->confirm(
            'Client id exists. Are you sure you want to override the it?'
        );
    }

    /**
     * Get the .env file path.
     *
     * @return string
     */
    protected function envPath()
    {
        if (method_exists($this->laravel, 'environmentFilePath')) {
            return $this->laravel->environmentFilePath();
        }

        return $this->laravel->basePath('.env');
    }

    /**
     * Display the key.
     *
     * @param  string  $id
     *
     * @return void
     */
    protected function displayId($id)
    {
        $this->laravel['config']['io-php.credentials._id'] = $id;

        $this->info("IO client id: [$id]");
    }
}
