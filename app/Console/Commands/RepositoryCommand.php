<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;


use function PHPUnit\Framework\isEmpty;

class RepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repo:make {name}';

    /**
     * The console name of repository.
     *
     * @var string
     */
    protected $name;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ropistory created successfully';

    protected $file;

    public function __construct(Filesystem $file)
    {
        parent::__construct();
        $this->file = $file;
    }


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->name = $this->argument('name');
        if (isEmpty($this->argument('name'))) {
            $this->name = $this->ask('Please Enter Name of Repository');
        }
        $this->createFile($this->name);
        Artisan::call("make:provider {$this->name}ServiceProvider");

        dd('Copy $this->app->bind('.$this->name.'Interface::class,'.$this->name.'::class); and Paste into '.$this->name.'ServiceProvider register method');
        return Command::SUCCESS;
    }

    public function createFile($name)
    {
        $this->makeFile($name);
        $this->makeInterface($name);
    }

    public function makeFile($name)
    {
        $path = getcwd() . '/app/Repository';
        if (!$this->file->isDirectory($path)) {
            $this->file->makeDirectory($path);
            $content = $this->fileContent($name);
            $this->file->put($path . "/{$name}.php", $content);
        } else {
            $content = $this->fileContent($name);
            $this->file->put($path . "/{$name}.php", $content);
        }
    }

    public function makeInterface($name)
    {
        $path = getcwd() . '/app/Repository/Interface';
        if (!$this->file->isDirectory($path)) {
            $this->file->makeDirectory($path);
            $content = $this->IntefaceContent($name);
            if (!$this->file->exists($path . "/{$name}Interface.php")) {
                $this->file->put($path . "/{$name}Interface.php", $content);
            }
        } else {
            $content = $this->IntefaceContent($name);
            if (!$this->file->exists($path . "/{$name}Interface.php")) {
                $this->file->put($path . "/{$name}Interface.php", $content);
            }
        }
    }



    public function fileContent($name)
    {
        $content = "<?

        namespace App\Repository;

        use App\Repository\Interface\ ".$name." as Interface{$name};

        class {$name} implements Interface{$name}
        {
            public function index()
            {
            }
            public function store()
            {
            }
            public function update()
            {
            }
            public function delete()
            {
            }
        }
        ";
        return $content;
    }


    public function IntefaceContent($name)
    {
        $content = "<?php

        namespace App\Repository\Interface;

        interface {$name}
        {
            public function index();
            public function store();
            public function update();
            public function delete();
        }";
        return $content;
    }
}
