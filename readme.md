## UMBC SGA -- iTracker

#### Credits
Original Works: Matthew Landen and Josh Massey

Rewrite and Rearchitected: [Christopher Sidell](https://christophersidell.com)

#### Resources

- Repo: [Bitbucket](https://bitbucket.org/sieabah/cmsc447/overview) [Github](https://github.com/Sieabah/iTracker)
- SGA: [Github](https://github.com/umbc-sga/iTracker)

Code Resources
- [Laravel](https://laravel.com/)
- [AngularJS](https://angularjs.org/)
- [NodeJS](https://nodejs.org/en/) and [NPM](https://www.npmjs.com/)

## Prerequisites

For this application to work you will need to have the following:
- Basecamp API Access from (integrate.37signals.com)
- Google Cloud API Access

### Getting Basecamp API access

1. Login with the root basecamp account into [https://integrate.37signals.com](https://integrate.37signals.com).
2. Register an application and fill out all fields.
3. Give the application `Basecamp 3` integration
4. The Redirect URI field should be the root domain of the application appened with auth/basecamp, for local this is `http://itracker.dev/auth/basecamp`.
5. Take the client_id and secret and put them into the .env file present in the root application directory
6. The User agent is the name of your application followed by the domain in parenthesis.

### Getting Google Social API access

1. Create a google cloud account at [https://console.cloud.google.com](https://console.cloud.google.com)
2. [Create a new project](https://cloud.google.com/resource-manager/docs/creating-project)
3. Enable Google+ Api on your [project](https://console.cloud.google.com/apis)
4. Create an OAuth client ID in [credentials](https://console.cloud.google.com/apis/credentials)
5. Give it a descriptive name
6. The Javascript origins should be the root application URL
7. The Authorized redirect url is similar to the basecamp one, the root app url with auth/callback instead. (`itracker.dev/auth/callback`)
8. Take the ID and Secret and put them into your .env file

### Database

1. Install a database somewhere, or use someone elses
2. Get the `username`, `password`, and `database` and put them into the .env file

## Starting the Project

These steps will take you from a completely clean installation to working

1. Set the superadmin account email in the .env file
    - Super admin editing only applies to people in departments, you cannot directly edit profiles
    - You can only edit accounts that are made.
2. Assuming you have the prerequisites finished and your .env file is filled out you can continue on.
3. Firstly run `php artisan migrate --seed` from the root project directory to setup all databases for the project
4. Run `php artisan storage:link` to link picture storage to the public directory
5. Go to the web url and enable access to your basecamp
    - If you enabled access to the wrong account you can destroy credentials with `php artisan basecamp:dropAuth`
6. Log into the application by clicking in the top right *Login*
    - If you're found in basecamp it will ask you to fill out your profile, this isn't required for now.
7. When finished setting up correct accounts for departments 

## Contributing

### Getting Local Development Running
1. [Install virtualbox](https://www.virtualbox.org/wiki/Downloads)
2. Also install [Vagrant](https://www.vagrantup.com)
3. Add [hostsupdater extension](https://github.com/cogitatio/vagrant-hostsupdater) to vagrant
4. Copy `.env.example` to `.env`, adjust for production and development environments.
5. Start the VM from the root app diretory and run `vagrant up`.

This will start the VM and you can connect to it after it's done by running `vagrant ssh`. This web directory will
be found in `/srv/web`. Run `php artisan key:generate` and try to access your application from [itracker.dev](itracker.dev).

As of right now it should be a page that doesn't look quite right, but it shouldn't fail outright. (Other than missing assets)

### Getting everything built
This environment heavily uses npm and node to build our dependencies.
1. Connect to the VM with `vagrant ssh` and navigate to `/srv/web`. 
2. From this directory you can run `npm install` and it will install all of our dependencies.
3. After we have installed that we need to install gulp globally to run the command `gulp`.
    1. Run `sudo npm install -g gulp` if you want to have it be a command run anywhere
4. Gulp should now be installed and you can run `gulp build` to build a development copy of the assets or `gulp` to have
it continually watch the directory for changes and rebuild. (Alternative: `npm dev`)
5. Production builds will be minified and optimized and can be generated by `gulp prod` or the alias `npm prod`

Now you can visit [itracker.dev](http://itracker.dev) and see the websites' current state. 

## Notes about building

With the way it is setup we can leverage _most_ of the [ES2015(ES6)](http://es6-features.org/#Constants) features with [babel](https://babeljs.io/)

Any `*.js` files in the `resources/assets/angular/` folder will be compiled after `core.js` is loaded.

Any `*.scss` files mentioned or imported in `resources/assets/sass/core.scss` will be compiled, everything else **is ignored**