<?php

namespace Davion153808\MiniCRUDGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Pluralizer;

class MakeCustomRoot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:coreFeature--all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This cmd will make SOP ( A Standard Operating Procedure, or SOP, is a set of step-by-step instructions compiled by an organization to help workers carry out routine operations in a clear and consistent manner )for Repo design full mini crud.Including for Model , Logic and Ui.';

    public function getSingularClassName($name)
    {
        return ucwords(Pluralizer::singular($name));
    }

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $password = $this->secret('What is the password?(Hint : can you guess my current girlfriend count! It should be probably more than 15!)');
        if ($password < 15) {
            $this->info("");
            $this->info("========================= You don't have access to use this command! You still think of me. (developed by  Davion)==========================");
            $this->info("");
            die();
        }
        $nameSpace = config('minicrud.namespace');
        $module = config('minicrud.modules');
        $this->info("Enter the feature name.It should be plural.");
        $feature = $this->ask('For example (if you implement demo feature the input should be "Demos" )');
        if ($feature != "") {
            $this->info('Put your path root paths of');
            $logic = $this->choice('Controller , Resource , Service and Validation.', ['Mobile', 'Spa', 'Web', 'false'], '0');
            $view = false;
            if ($logic != 'false' && $logic == 'Web') {
                $view = $this->ask("Enter the view path(UI directory resources/views/??)['admin/user']");
            }
            $migrationAndSeeder = $this->confirm('Do you wish to create migration and seeder?');
            $logic != "false" ?
            $this->allRun($module, $logic, $nameSpace, $feature, $view, $migrationAndSeeder)
            :
            $this->allRun($module, false, $nameSpace, $feature, $view, $migrationAndSeeder);
        } else {
            $this->info("");
            $this->info("========================= Sorry you can't use repo features (developed by  Davion)==========================");
            $this->info("");
        }

    }

    private function allRun($pathName, $logicPath, $nameSpace, $feature, $view, $migrationAndSeeder)
    {
        $model = ucwords(Pluralizer::singular($feature));
        $smallLetterPlural = lcfirst($feature);
        $smallLetter = lcfirst($model);
        $moduleRepoCommand = "$pathName~$nameSpace.$feature/$model";
        $controllerCommand = "{$pathName}~{$nameSpace}.{$feature}/{$model}Controller?path={$logicPath}";
        $resourceCommand = "{$pathName}~{$nameSpace}.{$feature}/{$model}Resource?path={$logicPath}";
        $serviceCommand = "{$pathName}~{$nameSpace}.{$feature}/{$model}Service?path={$logicPath}";
        $requestCommand = "{$pathName}~{$nameSpace}.{$feature}/{$model}Request?path={$logicPath}";

        switch ($logicPath) {
            case "false" :
                $this->moduleCmd($moduleRepoCommand, $smallLetterPlural, $migrationAndSeeder);
                $this->repoMessageReval();
                break;
            default:
                $this->moduleCmd($moduleRepoCommand, $smallLetterPlural, $migrationAndSeeder);
                $this->allCmd($controllerCommand, $resourceCommand, $serviceCommand, $requestCommand, $view, $model, $smallLetter, $logicPath);
                $this->featureTestCmd($model, $smallLetter, $feature, $logicPath);
                $this->allMessageReval($smallLetter, $model, $logicPath);
        }
    }

    private function moduleCmd($moduleRepoCommand, $smallLetterPlural, $migrationAndSeeder)
    {
        if ($migrationAndSeeder) {
            $this->call("make:migration", [
                'name' => "create_" . $smallLetterPlural . "_table",
            ]);
        }
        $this->call("make:module", [
            'name' => $moduleRepoCommand,
        ]);
        $this->call("make:repo", [
            'name' => $moduleRepoCommand,
        ]);
    }

    private function allCmd($controllerCommand, $resourceCommand, $serviceCommand, $requestCommand, $view, $model, $smallLetter, $logicPath)
    {
        $this->call("make:customController", [
            'name' => $controllerCommand,
        ]);
        $this->call("make:customResource", [
            'name' => $resourceCommand,
        ]);
        $this->call("make:customService", [
            'name' => $serviceCommand,
        ]);
        $this->call("make:customValidation", [
            'name' => $requestCommand,
        ]);
        if ($logicPath == "Web") {
            $this->call("make:customView", [
                'name' => "." . $view . " ",
                'model' => $model,
            ]);
            $this->call("make:customLanguage", [
                'name' => $smallLetter,
            ]);
        }
    }

    private function featureTestCmd($model, $smallModel, $pluralModel, $logicPath)
    {
        $this->call("make:customFeatureTest", [
            'model' => $model,
            'smallModel' => $smallModel,
            'pluralModel' => $pluralModel,
            'logicPath' => $logicPath,
        ]);
    }

    private function repoMessageReval()
    {
        $this->info("");
        $this->info("========================= Congratulation you unlock repo features (developed by  Davion :feat.hfourpsix38) =========================");
        $this->info("");
    }

    private function allMessageReval($smallLetter, $model, $logicPath)
    {
        $this->info("");
        $this->info("========================= Congratulation you unlock all features (developed by  Davion :feat.hfourpsix38 ) =========================");
        if ($logicPath == "Web") {
            $this->info("");
            $this->info(" please continue the below direction for fully mini crud feature");
            $this->info(" ");
            $this->info("===============================Language Step==========================================");
            $this->info("The first step.You need to add in lang/both(en and mm)/sidebar.php.The string is '" . $smallLetter . "' => '" . $model . "'");
            $this->info(" ");
            $this->info("===============================Blade View Step==========================================");
            $this->info("The second step.You need to add some code in resources/views/components/sidebar.blade.php");
            $this->info(" ");
            $this->info("===============================Route Step==========================================");
            $this->info("The third step.You need to add some code in routes/web.php The code is ---- Route::resource('" . $smallLetter . "s' ," . $model . "Controller::class);");
            $this->info(" ");
            $this->info("===============================Permission Step==========================================");
            $this->info("The fourth step.You need to add '$smallLetter' in permissions array in config/numbers.php and run [ php artisan migrate:fresh, php artisan db:seed ]. [Hint.You can check in PermissionSeeder]");
            $this->info(" ");
            $this->info("===============================Service Container Binding Step==========================================");
            $this->info("The fifth step.You need to add " . '$this->app->bind(' . $model . 'RepositoryInterface::class,' . $model . 'Repository::class);  in the register method and import necessary interface and repository class in app/provider/RepositoryBindingProvider');
            $this->info(" ");
            $this->info("===============================Reminder: Artisan is always at your service. It can boost your development speed, but it won't heal a broken heart. ==========================================");
        }
    }

}
