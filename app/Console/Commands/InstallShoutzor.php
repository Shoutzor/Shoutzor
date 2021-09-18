<?php

namespace App\Console\Commands;

use App\HealthCheck\HealthCheckManager;
use App\Installer\Installer;
use \Exception;
use Illuminate\Console\Command;

/**
 * An Artisan command allowing for command-line installation of Shoutzor.
 * The Functionality of this installer is identical to the graphical installer of Shoutzor.
 */
class InstallShoutzor extends Command
{
    /**
     * The name and signature of the console command.
     * --useenv indicates that the existing .env file should be used during installation.
     * @var string
     */
    protected $signature = 'shoutzor:install {--useenv}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs Shoutz0r via the command line';

    /**
     * Instance of the Installer class
     * @var Installer
     */
    private Installer $installer;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->installer = new Installer();
    }

    /**
     * Runs the shoutzor install command.
     * This will execute the same steps as the graphical installation wizard.
     * @return int
     */
    public function handle()
    {
        $this->line('Shoutz0r CLI Installer');

        try {
            // Running the installer while shoutzor is already installed will break & reset things. Bad idea.
            if(config('shoutzor.installed')) {
                throw new Exception('Shoutz0r is already installed, aborting.');
            }

            $useEnv = $this->option('useenv');

            $this->checkHealth();
            $this->performInstall($useEnv);
        } catch(Exception $e) {
            $this->error($e->getMessage());
            return 1;
        }

        return 0;
    }

    /**
     * Runs the healthchecks and will perform an auto-fix if any issues are detected
     * @throws Exception
     */
    private function checkHealth() {
        $this->info('Performing installation health-check..');

        $checks = app(HealthCheckManager::class)->getHealthStatus(true);

        // Keep track if any of the healthchecks are unhealthy
        $healthy = true;

        // Iterate over every healthcheck
        foreach($checks as $check) {
            //Print the name & description of the healthcheck
            $this->line('[HealthCheck] ' . $check['name'] . ' - ' . $check['description']);

            // If unhealthy, print the reason
            if($check['healthy'] === false) {
                $this->error($check['status']);
                $healthy = false;
            }
        }

        // Check if any of the healthchecks returned an unhealthy status
        if($healthy === false) {
            $this->info('Found unhealthy healthchecks, performing auto-fix');

            // Perform the auto-fix
            $result = app(HealthCheckManager::class)->performAutoFix(true);

            // Check if any of the health-checks still failed
            if($result['result'] === false) {
                throw new Exception('Auto-fix failed on one or more healtchecks, manual fix required');
            } else {
                $this->info('Auto-fix succeeded in fixing the issues.');
            }
        }

        $this->info('All healthchecks are healthy!');
    }

    /**
     * Performs the actual installation of Shoutzor
     * @throws Exception
     */
    private function performInstall($useEnv) {
        $this->info('Starting installation');

        try {
            // Check if the useEnv option is in-use
            if($useEnv) {
                // Inform the user about the --useenv option being used.
                $this->info('--useenv is used, existing .env file will be used.');

                // Check if the .env file actually exists
                if(file_exists(base_path('.env')) === false) {
                    throw new Exception('.env file not found in application root! Exiting.');
                }

                // Rebuild config cache
                $step = $this->installer->rebuildConfigCache();

                // Check if rebuilding the config cache worked
                if($step->succeeded() === false) {
                    throw new Exception('Failed to rebuild the config cache, reason: ' . $step->getOutput());
                }
            }

            //Fetch the valid DB settings
            $dbFields = $this->installer->getDbFields();

            // if --useenv is in-use, fetch the values from the .env file, otherwise, ask the user.
            if($useEnv) {
                $dbtype = config('database.default');
                $host = config($dbFields[$dbtype]['host']['dotconfig']);
                $port = config($dbFields[$dbtype]['port']['dotconfig']);
                $database = config($dbFields[$dbtype]['database']['dotconfig']);
                $username = config($dbFields[$dbtype]['username']['dotconfig']);
                $password = config($dbFields[$dbtype]['password']['dotconfig']);

                $step = $this->installer->configureSql($dbtype, $host, $port, $database, $username, $password);

                // Check if SQL configuration succeeded, if not, exit with error.
                if($step->succeeded() === false) {
                    throw new Exception('SQL Configuration failed, reason: ' . $step->getOutput());
                }
            } else {
                $sqlConfig = false;

                // Create a loop, this way the user can keep trying if the configuration fails.
                while($sqlConfig === false) {
                    // Ask the user what database type we should be configuring
                    $dbtype = $this->choice('Enter the sql type', array_keys($dbFields), 0);
                    $host = $this->anticipate('Enter the hostname of the sql server [ie: localhost or 127.0.0.1]', ['localhost', '127.0.0.1']);
                    $port = $this->anticipate('Enter the port of the sql server [ie: '.$dbFields[$dbtype]['port']['default'].']', [$dbFields[$dbtype]['port']['default']]);
                    $database = $this->anticipate('Enter the name of the database [ie: shoutzor]', ['shoutzor']);
                    $username = $this->anticipate('Enter the username of the SQL account [ie: shoutzor]', ['shoutzor']);
                    $password = $this->secret('Enter the password of the SQL account');

                    $step = $this->installer->configureSql($dbtype, $host, $port, $database, $username, $password);

                    //Check if the SQL configuration succeeded, if so: break the loop
                    if($step->succeeded()) {
                        $sqlConfig = true;
                    }
                }
            }

            // Retrieve the installation steps from the installer
            $installationSteps = $this->installer->getSteps();

            // Run each installation step in-order
            foreach($installationSteps as $step) {
                // Dynamic method, the method names are in the array
                $this->installer->{$step['method']}();
            }
        } catch (Exception $e) {
            throw new Exception('Installation failed, reason: ' . $e->getMessage());
        }

        $this->info('Installation finished!');
    }
}
