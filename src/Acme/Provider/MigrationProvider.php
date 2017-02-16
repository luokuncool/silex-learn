<?php
namespace Acme\Provider;

use Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

use Knp\Console\ConsoleEvents;
use Knp\Console\ConsoleEvent;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;

class MigrationProvider implements ServiceProviderInterface
{

    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $app A container instance
     */
    public function register(Container $app)
    {
        $app['db.migrations.namespace']  = 'DoctrineMigrations';
        $app['db.migrations.path']       = null;
        $app['db.migrations.table_name'] = null;
        $app['db.migrations.name']       = null;

        $app['dispatcher']->addListener(
            ConsoleEvents::INIT,
            function (ConsoleEvent $event) use ($app) {
                $application = $event->getApplication();
                $application->setHelperSet(
                    new HelperSet(
                        [
                            'db'     => new ConnectionHelper($app['db']),
                            'dialog' => new QuestionHelper(),
                        ]
                    )
                );
                $commands = [
                    new DiffCommand(new CustomSchemaProvider()),
                    new ExecuteCommand(),
                    new GenerateCommand(),
                    new MigrateCommand(),
                    new StatusCommand(),
                    new VersionCommand()
                ];
                $application->addCommands($commands);
            }
        );
    }
}