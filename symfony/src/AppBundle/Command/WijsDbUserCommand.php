<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WijsDbUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('wijs:db:user')
            ->setDescription('Creates the database user based on the Symfony configuration')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        // Get variables from `app/config/parameters.yml`
        $dbName = $container->getParameter('database_name');
        $dbUsername = $container->getParameter('database_user');
        $dbPassword = $container->getParameter('database_password');
        $dbAdminUsername = $container->getParameter('database_admin_user');
        $dbAdminPassword = $container->getParameter('database_admin_password');

        // Add database user with all privileges on (nonexistent) database
        $sql = "GRANT ALL PRIVILEGES ON ${dbName}.* TO '${dbUsername}' IDENTIFIED BY '${dbPassword}'";
        $command = sprintf('MYSQL_PWD=%s mysql --user=%s --execute="%s"', $dbAdminPassword, $dbAdminUsername, $sql);
        exec($command);

        $output->writeln("Database user `${dbUsername}` created!");
    }

}
