<?php


namespace Hamsoft\DirFactory;


use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CreateDirectory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hamsoft:create-directories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create default directories';

    /**
     * Execute the console command.
     * @param Filesystem $filesystem
     */
    public function handle(Filesystem $filesystem): void
    {
        $directories = config('directories.make');

        foreach ($directories as $directory => $options) {
            if (!is_array($options)) {
                $directory = $options;
                $options = [];
            }

            $path = base_path($directory);

            $mode = $options['mode'] ?? 0755;
            $force = $options['force'] ?? true;
            $filesystem->makeDirectory($path, $mode, true, $force);

            if (isset($options['gitignore']) && $options['gitignore']) {
                $this->createIgnoreFileInPath($path);
            }

        }
    }

    private function createIgnoreFileInPath(string $path): void
    {
        $gitignorePath = $path . '/.gitignore';
        if (file_exists($gitignorePath)) {
            return;
        }

        $file = fopen($gitignorePath, 'wb');
        fwrite($file, "*\n");
        fwrite($file, '!.gitignore');
        fclose($file);
    }
}
