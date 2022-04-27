<?php namespace Deployer;
require 'recipe/laravel.php';

// Configuration
set('repository', 'git@github.com:TODO');
//set('default_stage', 'production');
set('git_tty', true);

// [Optional] Allocate tty for git on first deployment
set('ssh_type', 'native');
set('keep_releases', 1000000);

// Make sure uploads & published aren't overwritten by deploying
set('shared_dirs', [
    'public/uploads',
    'public/published',
    'storage/tls/sites.d',
    'storage/logs',
    'storage/app/public/avatars',
    // 'storage/framework/sessions'
]);
set('shared_files', [
    '.env',
]);
set('writable_dirs', [
    'public/uploads',
    'public/published',
    //   'storage',
    'storage/tls',
    //'storage/framework',
    //'storage/framework/sessions'
]);
set('writable_mode', 'chmod');
set('writable_chmod_mode', '0775');

// SMART CUSTOM DEPLOY COMMANDS
task('db:migrate', function () {
    run("cd {{release_path}} && php artisan migrate --force");
});
task('group:write', function () {
    run("chmod -R g+w {{release_path}}");
});
task('horizon:terminate', function () {
    run("cd {{release_path}} && php artisan horizon:terminate");
})->onStage('production');
task('supervisor:restart', function () {
    run("supervisorctl reread && supervisorctl restart all");
})->onStage('production');

// Hosts
// dep deploy production

host('production')
    ->stage('production')
    ->hostname('TODO')
    ->user('deployer')
    ->identityFile('~/.ssh/TODO')
    ->forwardAgent()
    ->set('deploy_path', 'TODO');


// Run database migrations
after('deploy:symlink', 'db:migrate');
after('deploy:vendors', 'group:write');
#after('db:migrate', 'horizon:terminate');
#after('horizon:terminate', 'supervisor:restart');
