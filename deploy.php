<?php

namespace Deployer;

require 'recipe/laravel.php';

set('allow_anonymous_stats', false);
set('release_name', function () {
    return sprintf(
        '%s_%s_%s',
        date('YmdHis'),
        substr(base64_encode(random_bytes(8)), 0, 8),
        uniqid()
    );
});


set('repository', 'git@gitlab.com:andrey_schedrin/carsharing.git');
set('branch', 'main');

set('git_tty', false);
set('git_cache', false);
set('git_recursive', true);
set('repository_depth', 1);
set('keep_releases', 3);
set('update_code_strategy', 'clone');

set('ssh_multiplexing', false);
set('ssh_type', 'native');
set('ssh_arguments', [
    '-o UserKnownHostsFile=/dev/null',
    '-o StrictHostKeyChecking=no'
]);
set('git_ssh_command', 'ssh -o StrictHostKeyChecking=no');

set('composer_action', 'install');
set('composer_options', '--verbose --prefer-dist --no-progress --no-interaction --no-dev');
set('bin/composer', function () {
    if (commandExist('composer')) {
        return 'composer';
    }
    run('cd {{release_path}} && curl -sS https://getcomposer.org/installer | php');
    return 'php composer.phar';
});

set('writable_mode', 'chmod');
set('writable_chmod_mode', '0775');
set('writable_use_sudo', false);
set('cleanup_use_sudo', false);

set('log_level', 'debug');
set('verbosity', 3);


task('test:connection', function () {
    writeln('Testing connection...');
    run('echo "Connection successful"');
    run('pwd');
    run('whoami');
});

add('shared_files', ['.env']);
add('shared_dirs', [
    'storage',
    'bootstrap/cache'
]);

add('writable_dirs', [
    'bootstrap/cache',
    'storage',
    'storage/app',
    'storage/app/public',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs'
]);

add('copy_dirs', [
    'docker'
]);

host('91.197.96.214')
    ->set('remote_user', 'deploy')
    ->set('deploy_path', '/var/www/carsharing')
    ->set('identity_file', '~/.ssh/gitlab_deploy_key')
    ->set('deploy_path', '/var/www/carsharing')
    ->set('git_ssh_command', 'ssh -i ~/.ssh/gitlab_deploy_key -o StrictHostKeyChecking=no');

before('deploy:prepare', function () {
    run('rm -rf {{deploy_path}}/releases/* {{deploy_path}}/.dep {{deploy_path}}/release {{deploy_path}}/current || true');
});

task('deploy:check_release', function () {
    while (true) {
        $releaseName = get('release_name');
        $exists = test("[ -d {{deploy_path}}/releases/$releaseName ]");
        if (!$exists) {
            break;
        }

        set('release_name', sprintf(
            '%s_%s',
            date('YmdHis'),
            substr(base64_encode(random_bytes(8)), 0, 8)
        ));
    }
});

task('deploy:clean', function () {
    run('if [ -d {{deploy_path}} ]; then
        cd {{deploy_path}};
        if [ -d releases ]; then
            rm -rf releases/*;
        fi;
        if [ -d .dep ]; then
            rm -rf .dep;
        fi;
        if [ -h release ]; then
            rm -f release;
        fi;
        if [ -h current ]; then
            rm -f current;
        fi;
        if [ -d repo ]; then
            rm -rf repo;
        fi;
    fi');
});

task('docker:cleanup', function () {
    run('cd {{release_path}} && docker compose down --remove-orphans -v || true');
    run('docker system prune -f || true');
});

task('deploy:cleanup_node_modules', function () {
    if (test('[ -d "{{deploy_path}}/releases" ]')) {
        run('sudo -n find {{deploy_path}}/releases -type d -name "node_modules" -exec chmod -R u+w {} \; || true');
        run('sudo -n find {{deploy_path}}/releases -type d -name "node_modules" -exec rm -rf {} \; || true');
    }
});


task('deploy:env_check', function () {
    within('{{deploy_path}}/shared', function () {
        run('if [ ! -f .env ]; then
            cp {{release_path}}/.env.example {{deploy_path}}/shared/.env;
            echo "APP_NAME=CarSharing" >> {{deploy_path}}/shared/.env;
            echo "APP_ENV=production" >> {{deploy_path}}/shared/.env;
            echo "APP_DEBUG=false" >> {{deploy_path}}/shared/.env;
        fi');
    });
});

task('deploy:check_files', function () {
    within('{{release_path}}', function () {
        run('if [ ! -f "composer.json" ]; then echo "composer.json not found"; exit 1; fi');
        run('if [ ! -f "package.json" ]; then echo "package.json not found"; exit 1; fi');
    });
});

task('deploy:check_config', function () {
    within('{{release_path}}', function () {
        run('if [ -d "{{release_path}}" ]; then
            test -f .env || echo "Warning: .env file not found";
            test -d storage || echo "Warning: storage directory not found";
        fi');
    });
});

task('deploy:vendors', function () {
    if (!commandExist('unzip')) {
        run('apt-get update && apt-get install -y unzip');
    }
    run('cd {{release_path}} && {{bin/composer}} {{composer_action}} {{composer_options}}');
});

task('deploy:create_shared_dirs', function () {
    run('mkdir -p {{deploy_path}}/shared/storage/framework/cache');
    run('mkdir -p {{deploy_path}}/shared/storage/framework/sessions');
    run('mkdir -p {{deploy_path}}/shared/storage/framework/views');
    run('mkdir -p {{deploy_path}}/shared/storage/logs');
    run('mkdir -p {{deploy_path}}/shared/bootstrap/cache');
});


task('deploy:npm', function () {
    within('{{release_path}}', function () {

        run('mkdir -p {{release_path}}/.npm-cache');
        run('chown -R $(id -u):$(id -g) {{release_path}}/.npm-cache');
        run('chmod -R 775 {{release_path}}/.npm-cache');

        run('docker run --rm \
            -v {{release_path}}:/app \
            -w /app \
            -e HOME=/app \
            -e npm_config_cache=/app/.npm-cache \
            --user $(id -u):$(id -g) \
            node:20 npm install --no-audit');
    });
});


task('deploy:build', function () {
    within('{{release_path}}', function () {
        run('docker run --rm \
            -v {{release_path}}:/app \
            -w /app \
            -e HOME=/app \
            -e npm_config_cache=/app/.npm-cache \
            --user $(id -u):$(id -g) \
            node:20 npm run build');
    });
});

task('docker:build', function () {
    within('{{release_path}}', function () {
        run('docker compose build --no-cache app');
    });
});


task('deploy:copy_docker_files', function () {
    within('{{release_path}}', function () {
        writeln("\n Preparing docker configuration...");

        writeln("\n Current directory: " . run('pwd'));
        writeln("\n Directory contents:");
        run('ls -la');

        if (test('[ -f docker-compose.deploy.yml ]')) {
            writeln("\n Renaming docker-compose.deploy.yml to docker-compose.yml");
            run('cp docker-compose.deploy.yml docker-compose.yml');

            if (test('[ -f docker-compose.yml ]')) {
                writeln("\n docker-compose.yml created successfully");
                writeln("\n File contents:");
                run('cat docker-compose.yml');
            } else {
                throw new \Exception('Failed to create docker-compose.yml');
            }
        } else {
            throw new \Exception('docker-compose.deploy.yml not found in release directory');
        }
    });
})->desc('Prepare docker configuration files');


task('deploy:set_env', function () {
    within('{{release_path}}', function () {
        writeln('Setting environment variables...');
        $userId = run('id -u');
        $groupId = run('id -g');
        writeln("User ID: $userId");
        writeln("Group ID: $groupId");

        run('echo "WWWUSER=' . $userId . '" >> .env');
        run('echo "WWWGROUP=' . $groupId . '" >> .env');

        writeln('Verifying .env contents:');
        run('grep "WWWUSER\|WWWGROUP" .env || true');
    });
});

before('deploy:npm', function () {
    within('{{release_path}}', function () {
        run('id');
        run('ls -la');
    });
});

task('deploy:fix_npm_permissions', function () {
    within('{{release_path}}', function () {
        run('sudo chown -R deploy:www-data node_modules || true');
        run('sudo chmod -R 775 node_modules || true');
    });
});

before('deploy:npm', 'deploy:set_env');
before('deploy:npm', function () {
    run('docker pull node:20 || true');
});

task('deploy:permissions', function () {
    within('{{deploy_path}}', function () {
        try {
            run('if [ -d shared/storage ]; then sudo chmod -R 775 shared/storage; fi');
            run('if [ -d shared/bootstrap/cache ]; then sudo chmod -R 775 shared/bootstrap/cache; fi');
            run('if [ -d shared/storage ]; then sudo chown -R deploy:www-data shared/storage; fi');
            run('if [ -d shared/bootstrap/cache ]; then sudo chown -R deploy:www-data shared/bootstrap/cache; fi');
        } catch (\Exception $e) {
            writeln('<error>Permission setting failed: ' . $e->getMessage() . '</error>');
            return;
        }
    });
});


task('deploy:verify_symlink', function () {
    writeln('Verifying current symlink...');
    run('ls -la {{deploy_path}}/current');
    run('cd {{deploy_path}}/current && pwd && ls -la');
});


task('docker:restart', function () {
    within('{{release_path}}', function () {

        run('if [ ! -f docker-compose.deploy.yml ]; then echo "docker-compose.deploy.yml not found"; exit 1; fi');
        run('if [ ! -d docker ]; then echo "docker directory not found"; exit 1; fi');

        run('docker compose down --remove-orphans || true');
        run('docker compose pull || true');
        run('docker compose up -d --force-recreate --remove-orphans');

        run('docker compose ps');
    });
});

task('artisan:queue:restart', function () {
    within('{{release_path}}', function () {
        run('docker compose exec -T app php artisan queue:restart || true');
    });
});

task('artisan:cache:clear', function () {
    within('{{release_path}}', function () {
        run('docker compose exec -T app php artisan cache:clear || true');
    });
});

task('artisan:migrate', function () {
    within('{{release_path}}', function () {
        run('docker compose exec -T app php artisan migrate --force || true');
    });
});

task('deploy:symlink', function () {
    writeln('Creating symlink...');
    run('ls -la {{deploy_path}}');
    run('ln -sfn {{release_path}} {{deploy_path}}/current');
    writeln('Verifying symlink:');
    run('ls -la {{deploy_path}}/current');
});

task('deploy:check_permissions', function () {
    within('{{deploy_path}}', function () {
        run('id');
        run('groups');
        run('sudo -l');
    });
});

before('deploy:update_code', function () {
    $releasePath = get('release_path');
    run("if [ -d $releasePath ]; then rm -rf $releasePath; mkdir -p $releasePath; fi");
});

before('deploy', function () {
    run('docker ps -q | xargs -r docker stop || true');
    run('docker ps -aq | xargs -r docker rm || true');
});

after('deploy:copy_docker_files', function () {
    within('{{release_path}}', function () {
        writeln('Contents after copying docker files:');
        run('ls -la');
        run('ls -la docker || true');
    });
});

task('deploy', [
    'deploy:clean',
    'deploy:prepare',
    'deploy:check_release',
    'deploy:release',
    'deploy:update_code',
    'deploy:copy_docker_files',    
    'deploy:env_check',
    'deploy:check_config',
    'deploy:check_files',
    'deploy:create_shared_dirs',
    'deploy:shared',
    'deploy:vendors',
    'deploy:npm',
    'deploy:build',
    'deploy:symlink',
    'docker:restart',
    'deploy:permissions',
    'artisan:cache:clear',
    'artisan:migrate',
    'artisan:queue:restart',

]);
before('deploy', 'deploy:check_permissions');
before('deploy', 'test:connection');
before('deploy:prepare', 'deploy:cleanup_node_modules');
before('deploy:npm', 'deploy:fix_npm_permissions');
before('deploy:prepare', 'deploy:clean');
after('deploy:symlink', 'deploy:verify_symlink');
before('deploy:release', 'deploy:check_release');
after('artisan:migrate', 'artisan:cache:clear');
after('deploy:failed', 'deploy:unlock');
after('deploy:failed', 'deploy:clean');
after('deploy:shared', 'deploy:set_env');
