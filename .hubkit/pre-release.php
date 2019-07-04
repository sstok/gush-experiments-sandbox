<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface as Container;
use Rollerworks\Component\Version\Version;
use Symfony\Component\Console\Helper\ProgressIndicator;

return function (Container $container, Version $version, string $branch, ?string $releaseTitle, string $changelog) {
    /** @var \Psr\Log\LoggerInterface $logger */
    $logger = $container->get('logger');
    /** @var \HubKit\Service\GitHub $github */
    $github = $container->get('github');
    /** @var \HubKit\Service\Git\GitBranch $gitBranch */
    $gitBranch = $container->get('git.branch');

    /** @var \Symfony\Component\Console\Style\SymfonyStyle $style */
    $style = $container->get('style');

    $logger->info('Preparing new release branch');
    $gitBranch->checkoutNew($releaseBranch = 'release-'.$version->full);

        $logger->info('Updating composer branch-alias');
        $container->get('process')->mustRun(['composer', 'config', 'extra.branch-alias.dev-'.$branch, sprintf('%d.%d-dev', $version->major, $version->minor)]);

        $gitBranch->add('composer.json');
        $gitBranch->commit('Update composer branch-alias');

    $gitBranch->pushToRemote('origin', $releaseBranch);

    $pr = $github->openPullRequest($branch, $releaseBranch, 'Release v'.$version->full, 'This might be a good place for a changelog.');

    $style->warning([
        'Pull request '.$pr['html_url'].' was opened for this release.',
        'The process will automatically continue once this pull request it merged.',
        '!! DO NOT ABORT THE COMMAND !!'
    ]);

    $progress = new ProgressIndicator($style);
    $progress->start('Waiting for pull request to be merged.');

    // Wait till the pull-request is merged. This might crash if the API limit is exceeded.
    while ($github->getPullRequest($pr['number'])['state'] === 'open') {
        sleep(30); // sleep for 30 seconds

        $progress->advance();
    }

    if ($github->getPullRequest($pr['number'])['state'] === 'closed') {
        $progress->finish('Pull request was closed. Aborting.');

        exit(1);
    }

    $progress->finish('Pull request was merged, continuing.');
    $gitBranch->pullRemote('upstream', $branch);
};
