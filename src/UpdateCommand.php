<?php

declare(strict_types=1);

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2017 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace Jose\Component\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Humbug\SelfUpdate\Updater;

/**
 * Class UpdateCommand.
 */
final class UpdateCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('selfupdate')
            ->setDescription('Update the application if needed.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $updater = new Updater();
        $updater->getStrategy()->setPharUrl('https://github.com/web-token/jwt-app/raw/gh-pages/jose.phar');
        $updater->getStrategy()->setVersionUrl('https://github.com/web-token/jwt-app/raw/gh-pages/jose.phar.version');

        try {
            $result = $updater->update();
            if ($result) {
                $new = $updater->getNewVersion();
                $old = $updater->getOldVersion();
                $output->writeln(sprintf('Updated from %s to %s', $old, $new));
            } else {
                $output->writeln('Already up-to-date.');
            }
        } catch (\Exception $e) {
            $output->writeln('Something went wrong during the update.');
        }
    }
}
