<?php

namespace App\Console\Commands;

use App\Garages\Utility\ReflectionHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Process\Exception\RuntimeException;
use Symfony\Component\Process\Process;

class QualityAssuranceCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qa:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Quality Assurance Check';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $process = Process::fromShellCommandline(
            'git diff --cached --name-only --diff-filter=ACM | grep ".php\{0,1\}$"'
        );
        $process->run();

        $stagedFiles = $this->splitByNewLine($process->getOutput());

        foreach ($stagedFiles as $index => $stagedFile) {
            # Ignore root files
            # All of the QA tools here lack of excluding files in the root.
            if (! Str::contains($stagedFile, ['/', '\\'])) {
                unset($stagedFiles[$index]);
            }
        }

        if (count($stagedFiles) == 0) {
            return;
        }

        $phpcs = $this->findInstallation('phpcs', 'PHPCS', 'squizlabs/php_codesniffer');

        $larastan = $this->findInstallation('phpstan', 'Larastan', 'nunomaduro/larastan');

        $phplint = $this->findInstallation('phplint', 'PHPLint', 'overtrue/phplint');

        $this->callCommand('PHPCS', $phpcs, array_merge([
           '--standard=./.phpcs.xml',
        ], $stagedFiles));

        $this->callCommand('Larastan', $larastan, array_merge([
            'analyse',
            '--no-progress',
        ], $stagedFiles));

        $this->callCommand('PHPLint', $phplint, array_merge([
            '--configuration=./.phplint.yml',
        ], $stagedFiles), 'Linting');

        $this->autoPrependOutputBlock();
        $this->displaySuccess(' COMMIT SUCCEEDED ');
        $this->output->newLine();
    }

    /**
     * Execute the given command.
     *
     * @param  string  $name
     * @param  string  $command
     * @param  array  $params
     * @param  string  $processName
     * @return void
     */
    protected function callCommand($name, $command, array $params, $processName = 'Analysing'): void
    {
        $this->autoPrependOutputBlock();

        $process = (new Process(array_merge(
            [$command],
            $params
        )))->setTimeout(null);

        try {
            $process->setTty(true);
        } catch (RuntimeException $e) {
            $this->output->writeln('Warning: ' . $e->getMessage());
        }

        $this->displayInfo(" ⏱  {$name}: $processName code ... ");
        $this->output->newLine();

        $process->run();

        $this->autoPrependOutputBlock();

        if ($process->isSuccessful()) {
            $this->displaySuccess(" {$name}: Pass 🔥 ");
        } else {
            $this->displayError(" COMMIT FAILED ");
            $this->output->newLine();
            $this->output->writeln(
                "Your commit contains files that should pass code standard but do not.\n" .
                "Please fix the errors and try again."
            );
            die(1);
        }
    }

    /**
     * Find command installation.
     *
     * @param  string  $command
     * @param  string  $name
     * @param  string  $packageName
     * @return string
     */
    protected function findInstallation($command, $name, $packageName): string
    {
        $this->autoPrependOutputBlock();
        $this->displayWarning(" Finding $name installation: ");
        $this->output->newLine();
        $command = $this->commandBinary($command);

        if (! $command) {
            $this->displayError(" Please install $name (composer require $packageName --dev) ");
            die(1);
        }

        $this->displaySuccess(" Found $name installation. ");
        return $command;
    }

    protected function commandBinary($command)
    {
        $exist = $this->checkCommandExistence($command);

        if (! $exist) {
            $path = base_path(join_paths('vendor/bin', $command));

            if (File::exists($path)) {
                return $path;
            }

            return false;
        }

        return $command;
    }

    /**
     * Determine command existence.
     *
     * @param  string  $command
     * @return bool
     */
    protected function checkCommandExistence($command): bool
    {
        if ('\\' === DIRECTORY_SEPARATOR) {
            $cmd = 'where';
            $null = '2> nul';
        } else {
            // https://stackoverflow.com/a/677212/4484016
            $cmd = 'command -v';
            $null = '2> /dev/null';
        }

        $process = Process::fromShellCommandline(
            sprintf('%s %s %s', $cmd, $command, $null)
        );
        $process->run();

        return $process->isSuccessful();
    }

    protected function displayWarning($message): void
    {
        $this->output->writeln('<fg=black;bg=yellow>' . $message . '</>');
    }

    protected function displayInfo($message): void
    {
        $this->output->writeln('<fg=white;bg=blue>' . $message . '</>');
    }

    protected function displaySuccess($message): void
    {
        $this->output->writeln('<fg=black;bg=green>' . $message . '</>');
    }

    protected function displayError($message): void
    {
        $this->output->writeln('<fg=white;bg=red>' . $message . '</>');
    }

    protected function autoPrependOutputBlock(): void
    {
        ReflectionHelper::callRestrictedMethod($this->output, 'autoPrependBlock');
    }

    /**
     * Split string to array by new line.
     *
     * @param  string  $value
     * @return array
     */
    protected function splitByNewLine($value): array
    {
        $values = preg_split('/\r\n|\r|\n/', $value);

        return Arr::where($values, function ($val) {
            return trim($val) !== '';
        });
    }
}
