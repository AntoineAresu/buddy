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

after('deploy:failed', 'deploy:unlock');
