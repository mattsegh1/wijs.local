<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class WijsDbInitCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('wijs:db:init')
            ->setDescription('Initializes the database by creating database user, database and schema')
            ->addOption('migrate', null, InputOption::VALUE_NONE, 'Migrates Doctrine Migrations')
            ->addOption('seed', null, InputOption::VALUE_NONE, 'Loads Doctrine Fixtures')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        // Get variables from `app/config/parameters.yml`
        $dbName = $container->getParameter('database_name');

        $application = $this->getApplication();

        $commands = [
            'wijs:db:user',
            'doctrine:database:create',
            'doctrine:schema:create',
        ];

        if ($input->getOption('migrate')) {
            $commands[] = 'doctrine:migrations:migrate';
        }

        if ($input->getOption('seed')) {
            $commands[] = 'doctrine:fixtures:load';
        }

        foreach ($commands as $commandName) {
            $parameters = [
                'command' => $commandName,
            ];
            $commandInput = new ArrayInput($parameters);

            if (in_array($commandName, ['doctrine:fixtures:load', 'doctrine:migrations:migrate'])) {
                $commandInput->setInteractive(false);
            }

            $application
                ->find($commandName)
                ->run($commandInput, $output);
        }

        $output->writeln("Database `${dbName}` initialized!");
    }

}
