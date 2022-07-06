#!/bin/bash

setup_laravel() {
    [ -z "${LARAVEL_URL}" ] && LARAVEL_URL="https://${DDEV_HOSTNAME}"
    [ -z "${PHPMYADMIN_URL}" ] && PHPMYADMIN_URL="https://${DDEV_HOSTNAME}:8037"
    [ -z "${MAILHOG_URL}" ] && MAILHOG_URL="https://${DDEV_HOSTNAME}:8026"

    printf "Installing Laravel Composer dependencies...\n"
    composer install

    cp ./.env.example ./.env
    php artisan key:generate
    php artisan db:wipe
    php artisan migrate
    php artisan db:seed
    php artisan cache:clear

    npm i
    npm run dev

    tput setaf 2
    printf "All done! Here's some useful information:\n"
    printf "🔒 The default login is email0@domain.com/password\n"
    printf "🌐 To open the Laravel instance, go to ${LARAVEL_URL} in your browser.\n"
    printf "🌐 To open PHPMyAdmin for managing the database, go to ${PHPMYADMIN_URL} in your browser.\n"
    printf "🌐 To open MailHog for seeing all emails that Laravel sent, go to ${MAILHOG_URL} in your browser.\n"
    printf "🚀 Run \"ddev exec artisan test\" to run PHPUnit tests.\n"
    printf "🚀 Run \"ddev exec artisan COMMAND\" (like key:generate) to use the artisan commands."
    printf "🔴 If you want to stop the instance, simply run \"ddev stop\".\n"
    tput sgr0
}

# Check if the user has indicated their preference for the Laravel installation
# already (DDEV-managed or self-managed)
if ! test -f ./.ddev/laravel-preference
then
    tput setab 3
    tput setaf 0
    printf "Do you want us to set up the Laravel instance for you with the recommended settings for DDEV?\n"
    printf "If you answer \"no\", you will have to set up the Laravel instance yourself."
    tput sgr0
    printf "\nAnswer [yes/no]: "
    read Laravel_PREF
    echo $Laravel_PREF

    if [ $Laravel_PREF == "y" ] ;
    then
        printf "Okay, setting up your Laravel instance... 🚀\n"
        echo "ddev-managed" > ./.ddev/laravel-preference
        setup_laravel
    else
        printf "Okay, you'll have to set up the Laravel instance yourself. That's what pros do, right? Good luck! 🚀\n"
        echo "unmanaged" > ./.ddev/laravel-preference
    fi
fi
