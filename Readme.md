# Project - MIN...OU ? - Symfony 6
     __   __   _   ___    _    _____     _    _
    /  | |  | | | |   \  | |  /  _  \   | |  | |
   /   |/   | | | | |\ \ | | |  / \  |  | |  | |
  /  /|__/| | | | | | \ \| | | |   | |  | |  | |
 /  /     | | | | | |  \   | |  \_/  |  | |__| |
/__/      |_| |_| |_|   \__|  \_____/    \____/

## Presentation

**  Minou is an application developed to make it easier for an owner to find his lost cat, and this :
- thanks to reports made by whistleblowers
- thanks to a visualization of the alerts on a map

 
## Getting Started

### Prerequisites

1. Check composer is installed
2. Check yarn & node are installed

### Install

1. Clone this project
2. Run `composer install`
3. Run `yarn install`
4. Run `yarn encore dev` to build assets
5. Create a file `.env.local` in root (copy of `.env` file)
6. Configure your database in `.env.local`
7. Configuring an SMTP server
8. Create an environment variable `MAILER_FROM_ADDRESS` with the address of the site administrator in the `.env.local` file.
9. Check that the "picture" folder is in the public directory. If not, create this folder to store the photos of cats.

### Working

1. Run the command `symfony console d:m:m`
3. Run `symfony server:start` to launch your local php web server
4. Run `yarn run dev --watch` to launch your local server for assets

==> By default, the role "ROLE_USER" is given for all new registration

### Routing

#### Routes accessible only to the administrator role :

"/power/article/" (name: 'app_article_index') : to display all the articles
"/power/article/new" (name: 'new-article') : to write a new article
"/power/article/{id}" (name: 'app_article_show') : to show the details of the article with id
"/power/article/{id}/edit" (name: 'app_article_edit') : to edit the article with id
"/power/article/{id}" (name: 'app_article_delete') : to delete the article whith id
"/power/breed/" (name: 'app_breed_index') : list of breeds
"/power/breed/new" (name: 'app_breed_new') : to create a new breed
"/power/breed/{id}" (name: 'app_breed_show') : to show details of breed with id
"/power/breed/{id}/edit" (name: 'app_breed_edit') : to edit breed with id
"/power/breed/{id}' (name: 'app_breed_delete') : to delete the breed with id
"/power/user/" (name: 'app_user_index') : to display the users list
"/power/user/{id}" (name: 'app_user_show') : to display details about user with id
"/power/user/{id}" (name: 'app_user_delete') : to delete a user


#### Routes accessible to the administrator and user role :

"/cat/new" (name:'new_cat') : to register a new cat
"/cat/displayreport/{id}" (name :"displayreport") : to display all reports about a lost cat with id
"/cat/lost/{id}" (name :'catlost') : to change the status of a cat from lost to found or the opposite
"/cat/list" (name: 'cat-list') : to display all the owner's cats (based on app.user email)
"/cat/delete/{id}" (name: 'deletecat') : to delete cat with id
"/found/{id}" (name: 'found') : to indicate that cat with id is not lost anymore
"/storereports/{id}" (name: 'storereports') : when a cat is not lost anymore, to store all previus reports
"/deletereports/{id}" (name: 'deletereports'): when a cat is not lost anymore, to delete all previus reports
"/logout" (name: 'app_logout') : to logout the app
"/report/{cat_id}" (name: 'report') : to make a report for a lost cat with id


#### Routes accessible to every role : 

"/" : home page
"/cgu" (name: 'app_cgu') : terms and conditions of use
"/contact" (name: 'contact') : to send a mail to the administrator
"/login" (name: 'login') : to login the app
"/register" (name: 'app_register') : to register on the app
"/disconnected" (name: 'app_disconnected') : to find all cats lots in one place when geoloc is out of order
"/place/{lat}/{long}" (name: 'place') : to determine place name according to lat and long coordinates

## Author

Sébastien Violante

