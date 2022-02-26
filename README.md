## Yamin-movie app

This simple movie app is to demonstrate basic CRUD using laravel resources, concept of routing and more importantly the concept of Testing using phpunit. The feature for this app as follow:

- User can add perform artisan command to get data (in this case movie information from IMBP API), and automatically populate the data into database.
- User able to add movie into watchlist.
- User able to store when they watched the movie by simple clicking on Watched/Unwatched button.
- User able to create a new movie and store into the database.
- User also able to perform artisan command to create new user.

**Note: This app only serve for single user, meaning only 1 user able to create watchlist and update watched/unwatched for each movie (with default user id = 1)**

## Installation

1. Git pull from repo. Composer install and npm install.
2. Run *php artisan migrate*.
3. Run *php artisan create:newUser 1* (change 1 to you desired quantity).
4. Run *php artisan import:movieDatabase Avengers* (change Avengers to any other keyword search. 10 top movies according to that keyword will be pulled from IMDB API and automatically stored in the database)

## To run Test
1. Prepare the testing environment, change the *APP_ENV = local* to *APP_ENV = testing*.


2. Recommended to create a new database for testing, if you do this, change the *DB_DATABASE = "Your test DB"* in .env. Alternatively you also change it in phpunit.xml.

For example in phpunit.xml I used the following values:

    <server name="DB_CONNECTION" value="mysql"/>
    <server name="DB_DATABASE" value="moviedb_test"/>

Run the test using *php artisan test*

## Test Cases

These are the test cases in this app:

1. user can view movie index page (testing for route /movies)
2. user can view movie detail page (testing for route /movie/{id})
3. user can create new movie (testing for method /movie/create)
4. user can add movie to watchlist (testing for method movie/add_to_watchlist)
5. user can update movie to watched (testing for method movies/update_watch/{watchlist})
6. user can update movie to unwatched (testing for method movies/update_watch/{watchlist})
7. artisan command import new movies to db (testing artisan command php artisan import:movieDatabase Avengers)
8. artisan command create new user (testing php artisan create:newUser 1)

All test cases should be **Passed**, if you encounter any issue running the test, kindly check your .env or phpunit.xml setting.
