## CMSC 447 Team 5

Steps to start on the team

1. Clone the repo
2. Add your name to contributers.txt

## Contributing

1. [Install virtualbox](https://www.virtualbox.org/wiki/Downloads)
2. Also install [Vagrant](https://www.vagrantup.com)
3. Add [hostsupdater extension](https://github.com/cogitatio/vagrant-hostsupdater) to vagrant
4. Copy `.env.example` to `.env`, adjust for production and development environments.
5. Start the VM from the root app diretory and run `vagrant up`.

This will start the VM and you can connect to it after it's done by running `vagrant ssh`. This web directory will
be found in `/srv/web`. Run `php artisan key:generate` and try to access your application from [itracker.dev](itracker.dev).

If everything worked correctly this should show the application homepage.