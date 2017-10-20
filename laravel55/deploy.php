<?php

namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'gideon');

// Project repository
set('repository', '');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

set('ssh_multiplexing', true);

set('http_user', 'cp1otoitncsu');

// Shared files/dirs between deploys 
add('shared_files', [
    '.env'
]);

add('shared_dirs', []);
add('rsync', [
    'exclude' => [
        '.git',
        'deploy.php',
        'node_modules',
    ],
]);

// Writable dirs by web server 
add('writable_dirs', []);


// Hosts
host('cp1ot.oit.ncsu.edu')
    ->user('cp1otoitncsu')
    ->port(24)
    ->set('deploy_path', '~/public_html/{{application}}')
    ->forwardAgent();



// Run tests
task('local:phpunit', function () {
    runLocally("php vendor/bin/phpunit");
});

// event handlers
before('deploy', 'local:phpunit');
after('deploy:failed', 'deploy:unlock');
before('deploy:symlink', 'artisan:migrate');


