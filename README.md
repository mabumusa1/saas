## Getting Started
We want to build a simple SaaS application to control a backend API server, as a developer we recommend that you have the folloiwng tools installed on your machine before you start writing code for the system: 
 1. Ubuntu as the OS, you can use Windows or MacOS but we recommend Ubuntu
 2. Use DDEV as a development environment
 3. Use Visual Studio code as IDE
 4. We use Laravel Mix to generate assets so you should have basic knowldge of NPM and Laravel Mix
 5. We use Metronic theme to add a theme and style to the system, you may use all the compments of Metoric theme

## How to prepare your development environment?

In order to make sure that all developers are using the same enviroment for development, please follow these steps to prepeare your development enviroment

1. Install DDEV as mentioned on [this page](https://ddev.readthedocs.io/en/stable/)
2. Fork the repo on Github
3. After the installation clone the repo using
 `git clone git@github.com:USERNAME/saas.git`
4. Checkout the `dev` branch
5. Run ddev using `ddev start`, this will install composer packags and run Laravel Mix package.json packages and generate assets, **also it will delete the existing database,** migrate the database,  and seed it. 
6. Once running `ddev` will show your the url of the project that is running on your localhost where you can start using the system


## Writing code for the front end

  We use Metronic theme which has two components: 
  1. PHP config files under `config` folder
  2. Assets under `resources` folder
  3. While you are developing front end changes like style changes or JavaScript changes you can use `npm run watch` which will reflect the changes directly so you can see them


## Code Quality

We implement three methods to control the quality of the code: 
1. CS Fixer: to style the code and make it easy to read
2. PHP Unit: we run tests on the code using unit tests
3. PHPStan: to check if you are using reduant code or unsed variables
4. Code Coverage: to verify that tests are covering all the aspects of the code 

Each code you push to Github or PR you start will be evaluated using these scripts on Github

