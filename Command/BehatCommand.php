<?php

namespace Behat\BehatBundle\Command;

use Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputOption;

use Behat\Behat\Console\Command\BehatCommand as BaseCommand,
    Behat\Behat\Console\Processor;

use Behat\BehatBundle\Console\Processor as BundleProcessor;

/*
 * This file is part of the Behat\BehatBundle.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Behat testing command.
 *
 * @author      Konstantin Kudryashov <ever.zet@gmail.com>
 */
class BehatCommand extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('behat')
            ->setDescription('Tests Behat feature(s) in specified bundle')
            ->setProcessors(array(
                new BundleProcessor\LocatorProcessor(),
                new BundleProcessor\InitProcessor(),
                new BundleProcessor\ContextProcessor(),
                new Processor\FormatProcessor(),
                new Processor\HelpProcessor(),
                new Processor\GherkinProcessor(),
                new Processor\RerunProcessor(),
            ))
            ->setDefinition(new \Behat\Behat\Console\Input\InputDefinition())
            ->addArgument('features', InputArgument::REQUIRED,
                "Feature(s) to run. Could be:".
                "\n- a dir (<comment>src/to/Bundle/Features/</comment>), " .
                "\n- a feature (<comment>src/to/Bundle/Features/*.feature</comment>), " .
                "\n- a scenario at specific line (<comment>src/to/Bundle/Features/*.feature:10</comment>). " .
                "\n- Also, you can use short bundle notation (<comment>@BundleName/*.feature:10</comment>)"
            )
            ->configureProcessors()
            ->addOption('--strict', null, InputOption::VALUE_NONE,
                'Fail if there are any undefined or pending steps.'
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function getContainer()
    {
        return $this->getApplication()->getKernel()->getContainer();
    }
}
