<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yurijmalcev
 * Email: yuriy.m@visiontechglobal.com
 * Date: 14.03.13
 * Time: 23:00
 */

namespace Yaw\AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\ArrayInput;

class UpdateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('aw:fullup')->setDescription('Update the Angelwishes Project');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Update Doctrine collation
        $output->writeln('Update Doctrine default collation');
        $file = $this->getContainer()->get('kernel')->getRootdir().'/../vendor/doctrine/dbal/lib/Doctrine/DBAL/Platforms/MySqlPlatform.php';

        try
        {
            $content = file_get_contents($file);
            $content = str_replace('utf8_unicode_ci', 'utf8_general_ci', $content);

            file_put_contents($file, $content);
            $output->writeln('Finished succesfully.');
        }
        catch(\Exception $e)
        {
            $output->writeln($e->getMessage());
        }

        // Update DB schema
        $command = $this->getApplication()->find('doctrine:schema:update');
        $arguments = array(
            'command' => 'doctrine:schema:update',
            '--force' => true
        );
        $input = new ArrayInput($arguments);
        $command->run($input, $output);

        // Update doctrine migrations
        $command = $this->getApplication()->find('doctrine:migrations:migrate');
        $arguments = array(
            'command' => 'doctrine:migrations:generate'
        );
        $input = new ArrayInput($arguments);
        $command->run($input, $output);

        //Install assets
        $command = $this->getApplication()->find('assets:install');
        $arguments = array(
            'command' => 'assets:install',
            'target' => 'web',
            '--symlink' => true
        );
        $input = new ArrayInput($arguments);
        $command->run($input, $output);

        //Dump assets
        $command = $this->getApplication()->find('assetic:dump');
        $arguments = array(
            'command' => 'assetic:dump'
        );
        $input = new ArrayInput($arguments);
        $command->run($input, $output);
    }
}