<?php

namespace Botble\Base\Commands;

use Botble\Setting\Supports\SettingStore;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;

class InstallCommand extends Command
{

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'cms:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install CMS';

    /**
     * Execute the console command.
     * @author DGL Custom
     * @param SettingStore $settingStore
     * @return bool
     */
    public function handle(SettingStore $settingStore)
    {
        $this->info('Starting installation...');
        try {
            $this->call('migrate:fresh');
        } catch (QueryException $exception) {
            $this->call('migrate:fresh');
        }

        if (config('database.default') !== 'sqlite' && $this->confirm('Do you want to install sample data? [yes|no]')) {
            $this->call('cms:theme:install-sample-data');
        } else {
            $settingStore
                ->set('site_title', __('A site using Botble CMS'))
                ->save();
        }

        if ($this->confirm('Do you want to new admin user? [yes|no]')) {
            $this->call('cms:user:create');
        }

        $this->info('Installed Botble CMS successfully!');

        return true;
    }
}
