# config valid only for current version of Capistrano
lock '3.4.0' 

set :application, 'bound'
set :repo_url, 'https://github.com/Kafei59/bound'

set :ssh_user, 'kafei'
server '5.196.69.122', user: fetch(:ssh_user), roles: %w{web app}

set :ssh_options, {
    forward_agent: true,
    auth_methods: ["publickey"],
    keys: ["~/.ssh/id_rsa_blih.pub"]
}

set :scm, :git
set :format, :pretty

set :log_level, :debug
set :pty, true

set :keep_releases, 3

set :composer_working_dir, -> { "#{release_path}/desk/" }
set :composer_install_flags, '--no-dev --no-interaction --optimize-autoloader'
set :controllers_to_clear, ["app_*.php"]
set :linked_files, %w{desk/app/config/parameters.yml}
set :linked_dirs, %w{desk/app/logs web/uploads}

set :symfony_env, "prod"
set :app_path, "desk/app"
set :web_path, "desk/web"
set :cache_path, fetch(:app_path) + "/cache"
set :log_path, fetch(:app_path) + "/logs"
set :app_config_path, fetch(:app_path) + "/config"
set :controllers_to_clear, ["app_*.php"]
set :linked_dirs, [fetch(:cache_path), fetch(:log_path), fetch(:web_path) + "/uploads"]
set :file_permissions_paths, [fetch(:log_path), fetch(:cache_path)]
set :file_permissions_users, ['www-data']
set :webserver_user, "www-data"
set :permission_method, false
set :use_set_permissions, false
set :symfony_console_path, fetch(:app_path) + "/console"
set :symfony_console_flags, "--no-debug"
set :assets_install_path, fetch(:web_path)
set :assets_install_flags, '--symlink'
set :assetic_dump_flags, ''
fetch(:default_env).merge!(symfony_env: fetch(:symfony_env))

namespace :cache do
    desc 'Force chmod on cache folders'
    task :clear do
        on roles(:app) do
            execute "mkdir -p " + fetch(:cache_path) + " " + fetch(:log_path)
            execute "chmod -R 777 " + fetch(:cache_path) + " " + fetch(:log_path)
        end
    end
end

after 'deploy:finishing', 'cache:clear'
after 'deploy:finishing', 'deploy:cleanup'
