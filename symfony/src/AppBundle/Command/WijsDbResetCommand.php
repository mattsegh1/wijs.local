<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class WijsDbResetCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('wijs:db:reset')
            ->setDescription('Drops and initializes the database')
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
            'wijs:db:drop' => null,
            'wijs:db:init' => null,
        ];

        if ($input->getOption('migrate') || $input->getOption('seed')) {
            $options = [];

            if ($input->getOption('migrate')) {
                $options['--migrate'] = true;
            }

            if ($input->getOption('seed')) {
                $options['--seed'] = true;
            }

            $commands['wijs:db:init'] = $options;
        }

        foreach ($commands as $commandName => $commandParameters) {
            $parameters = [
                'command' => $commandName,
            ];
            if (is_array($commandParameters)) {
                foreach ($commandParameters as $commandParameter => $value) {
                    $parameters[$commandParameter] = $value;
                }
            }
            $commandInput = new ArrayInput($parameters);

            $application
                ->find($commandName)
                ->run($commandInput, $output);
        }

        $output->writeln("Database `${dbName}` reset!");
    }

}
