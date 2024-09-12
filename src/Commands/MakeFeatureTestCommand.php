<?php

namespace Davion153808\MiniCRUDGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeFeatureTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:customFeatureTest {model} {pluralModel} {smallModel} {logicPath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This cmd will make feature test';

    ///////////////////////////////This is Method Divider///////////////////////////////////////////

    public function getFeatureTest()
    {
        return __DIR__ . '/stubs/customFeatureTest.stub';
    }

    ///////////////////////////////This is Method Divider///////////////////////////////////////////

    public function getFeatureTestVariables()
    {
        return [
            'MODEL' => $this->argument('model'),
            'SMALL_MODEL' => $this->argument('smallModel'),
            'PLURAL_MODEL' => $this->argument('pluralModel'),
        ];
    }

    ///////////////////////////////This is Method Divider///////////////////////////////////////////

    public function getFeatureTestSourceFile()
    {
        return $this->getStubFeatureTestContents($this->getFeatureTest(), $this->getFeatureTestVariables());
    }

    ///////////////////////////////This is Method Divider///////////////////////////////////////////

    public function getFeatureTestFilePath(): string
    {
        return base_path("tests" . DIRECTORY_SEPARATOR . "Feature" . DIRECTORY_SEPARATOR . ($this->argument('model') . "FeatureTest.php"));
    }

    ///////////////////////////////This is Method Divider///////////////////////////////////////////

    public function getStubFeatureTestContents($stub, $stubVariables = [])
    {
        $contents = file_get_contents($stub);
        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$' . $search . '$', $replace, $contents);
        }
        return $contents;
    }

    ///////////////////////////////This is Method Divider///////////////////////////////////////////
    //Make Directory For custom Artisan
    protected $files;

    public function __construct(
        Filesystem $files,
        private MakeCommonCommand $commonCommand,
    ) {
        parent::__construct();
        $this->files = $files;
    }

    protected function makeDirectory($path): mixed
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }
        return $path;
    }

    ///////////////////////////////This is Method Divider///////////////////////////////////////////

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = $this->getFeatureTestFilePath();
        $this->makeDirectory(dirname($path));
        $contents = $this->getFeatureTestSourceFile();

        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            $this->info("File : {$path} created");
        } else {
            $this->info("File : {$path} already exits");
        }
    }
}