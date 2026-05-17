<?php

namespace Deployer;

require 'recipe/symfony.php';

// Config

set('repository', 'git@github.com:AntoineAresu/buddy');

add('shared_files', ['.env', '.env.local']);
add('shared_dirs', []);
set('writable_dirs', []);

// Hosts

host('buddy_pp')
    ->set('remote_user', 'deploy')
    ->set('branch', 'feature/docker')
    ->set('deploy_path', '/var/www/buddy_pp');

// Tasks

task('docker:build', function () {
    run('cd {{release_path}} && make build_pp');
});

task('docker:up', function () {
    run('cd {{release_path}} && make up_pp');
});

task('docker:migrate', function () {
    run('cd {{release_path}} && make migrate');
});

task('docker:down', function () {
    run('cd {{previous_release}} && make down_pp || true');
});

task('deploy:vendors')->disable();
// Hooks

after('deploy:symlink', 'docker:build');
after('docker:build', 'docker:down');
after('docker:down', 'docker:up');
after('docker:up', 'docker:migrate');
after('deploy:failed', 'deploy:unlock');
