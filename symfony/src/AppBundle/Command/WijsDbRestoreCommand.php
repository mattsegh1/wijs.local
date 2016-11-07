<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WijsDbRestoreCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('wijs:db:restore')
            ->setDescription('Restores the database from latest backup SQL dump')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        // Get variables from `app/config/parameters.yml`
        $dbName = $container->getParameter('database_name');
        $dbUsername = $container->getParameter('database_user');
        $dbPassword = $container->getParameter('database_password');
        $dbDumpPath = $container->getParameter('database_dump_path');

        $command = "MYSQL_PWD=${dbPassword} mysql --user=${dbUsername} ${dbName} < ${dbDumpPath}/latest.sql";

        exec($command);

        $output->writeln("Backup for database `${dbName}` restored!");
    }

}
