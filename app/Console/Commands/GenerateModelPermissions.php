<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class GenerateModelPermissions extends Command
{
    /**
     * The name and signature of the console command.
     * php artisan permissions:generate Post
     * @var string
     */
    // protected $signature = 'app:generate-model-permissions';
    protected $signature = 'permissions:generate {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';
    protected $description = 'Generate CRUD permissions for a model';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $model = $this->argument('model');
        $permissions = [
            "view-any {$model}",
            "view {$model}",
            "create {$model}",
            "update {$model}",
            "delete {$model}",
            "restore {$model}",
            "force-delete {$model}",
            "replicate {$model}",
            "reorder {$model}",
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        $this->info("Permissions for {$model} generated successfully!");
    }
}
