<?php

namespace App\Console\Commands;

use App\Exceptions\formValidationException;
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
     * --dev indicates that this is a development environment and will populate the database with dummy data
     * @var string
     */
    protected $signature = 'shoutzor:install {--useenv} {--dev}';

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
            $this->performInstall($useEnv, $this->option('dev'));
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

            // Print the results of the auto-fix
            foreach($result['data'] as $fix) {
                $this->line('[HealthCheck] ' . $fix['name'] . ' Auto-fix result:');
                $this->line($fix['result']);
            }

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
    private function performInstall($useEnv, $isDev) {
        $this->info('Starting installation');

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
        $dbFields = Installer::$dbFields;

        // if --useenv is in-use, fetch the values from the .env file, otherwise, ask the user.
        if($useEnv) {
            $this->info("Configuring SQL settings using the config values in the environment file");

            $dbtype = config('database.default');
            $host = config($dbFields[$dbtype]['host']['dotconfig']);
            $port = config($dbFields[$dbtype]['port']['dotconfig']);

            $this->line("Testing connection to $host:$port...");

            if (!$socket = @fsockopen($host, $port, $errno, $errstr, 3)) {
                throw new Exception("Could not connect to $host:$port; please ensure the correct hostname/IP address & port are used, and not being blocked by a firewall.");
            } else {
                $this->info("Connection success!");
                fclose($socket);
            }

            $database = config($dbFields[$dbtype]['database']['dotconfig']);
            $username = config($dbFields[$dbtype]['username']['dotconfig']);
            $password = config($dbFields[$dbtype]['password']['dotconfig']);

            $step = $this->installer->configureSql($dbtype, $host, $port, $database, $username, $password);

            // Check if SQL configuration succeeded, if not, exit with error.
            if($step->succeeded()) {
                $this->info("SQL Configuration succeeded");
            } else {
                // Check if it's a formValidation exception, or regular exception
                if($step->getException() instanceof formValidationException) {
                    // $errors will now contain formValidationFieldError[] from the exception
                    $errors = $step->getException()->getErrors();

                    // Convert the array of formValidationFieldError objects into an array
                    foreach($errors as $e) {
                        $this->error($e->getField() . ": " . $e->getMessage());
                    }

                    throw new Exception('SQL Configuration failed, reason: Validation failed');
                } else {
                    throw new Exception('SQL Configuration failed, reason: '.$step->getOutput());
                }
            }
        } else {
            $this->info("Configuring SQL settings");

            // Create a loop, this way the user can keep trying if the configuration fails.
            while(true) {
                // Ask the user what database type we should be configuring
                $dbtype = $this->choice('Enter the sql type', array_keys($dbFields), 0);
                $host = $this->anticipate('Enter the hostname of the sql server [ie: localhost or 127.0.0.1]', ['localhost', '127.0.0.1']);
                $port = $this->anticipate('Enter the port of the sql server [ie: '.$dbFields[$dbtype]['port']['default'].']', [$dbFields[$dbtype]['port']['default']]);

                $this->line("Testing connection to $host:$port...");

                if (!$socket = @fsockopen($host, $port, $errno, $errstr, 3)) {
                    $this->error("Could not connect to $host:$port; please ensure the correct hostname/IP address & port are used, and not being blocked by a firewall.");
                    fclose($socket);
                    continue;
                } else {
                    $this->info("Connection success!");
                    fclose($socket);
                }

                $database = $this->anticipate('Enter the name of the database [ie: shoutzor]', ['shoutzor']);
                $username = $this->anticipate('Enter the username of the SQL account [ie: shoutzor]', ['shoutzor']);
                $password = $this->secret('Enter the password of the SQL account');

                $step = $this->installer->configureSql($dbtype, $host, $port, $database, $username, $password);

                //Check if the SQL configuration succeeded, if so: break the loop
                if($step->succeeded()) {
                    $this->info("SQL Configuration succeeded");
                    break;
                } else {
                    // Check if it's a formValidation exception, or regular exception
                    if($step->getException() instanceof formValidationException) {
                        // $errors will now contain formValidationFieldError[] from the exception
                        $errors = $step->getException()->getErrors();

                        // Convert the array of formValidationFieldError objects into an array
                        foreach($errors as $e) {
                            $this->error($e->getField() . ": " . $e->getMessage());
                        }
                    } else {
                        // Configuration failed, display error and restart the loop
                        $this->error("SQL Configuration failed, reason: " . $step->getOutput());
                    }
                }
            }
        }

        // Retrieve the installation steps from the installer
        $installationSteps = Installer::$installSteps;

        // Run each installation step in-order
        foreach($installationSteps as $step) {
            $this->info("Executing installation step '" . $step['name'] . "': " . $step['description']);
            // Dynamic method, the method names are in the array
            $stepResult = $this->installer->{$step['method']}();

            if($stepResult->succeeded() === false) {
                throw new Exception("Installation step failed. Reason: " . $stepResult->getOutput());
            }
        }

        if($isDev) {
            $this->info('Seeding database with the DevelopmentSeeder');
            $this->installer->developmentSeedDatabase();
            if($stepResult->succeeded() === false) {
                throw new Exception("Installation step failed. Reason: " . $stepResult->getOutput());
            }
        }

        $this->info('Installation finished!');
    }
}
