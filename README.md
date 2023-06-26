# Back-end Developer Exam 2021

This is a web application that allows users to view, create, and update product listings. It also includes a filter feature and a search feature that allows users to search for products by name or description. Additionally, there is a bonus video player feature included.

## Features
- Complete listing of products
- Create and update products
- Filter products
- Search by "name" and "description"
- Bonus video player

## Tech
This application uses several open-source projects to work correctly:

- [VueJS 3](https://vuejs.org/) - An approachable, performant, and versatile framework for building web user interfaces.
- [Laravel 10](https://laravel.com/) - Laravel is a web application framework with expressive, elegant syntax. It provides the foundation for creating web applications without worrying about the small things.
- [Bootstrap](https://getbootstrap.com/) - A powerful, extensible, and feature-packed frontend toolkit. Build and customize with Sass, utilize prebuilt grid system and components, and bring projects to life with powerful JavaScript plugins.
- [VideoJS](https://github.com/videojs/video.js) - Video.js is a web video player built from the ground up for an HTML5 world. It supports HTML5 video and Media Source Extensions, as well as other playback techs like YouTube and Vimeo (through plugins). It supports video playback on desktops and mobile devices.
- [vue3-editor](https://github.com/sunkint/vue3-editor) - A rich-text editor for Vue.js.
- [vee-validate](https://vee-validate.logaretm.com/v4/) - VeeValidate is the most popular Vue.js form library. It takes care of value tracking, validation, errors, submissions, and more.
- [lodash](https://lodash.com/) - A modern JavaScript utility library delivering modularity, performance & extras.
- [yup](https://www.npmjs.com/package/yup) - Yup is a schema builder for runtime value parsing and validation. Define a schema, transform a value to match, assert the shape of an existing value, or both. Yup schema is extremely expressive and allows modeling complex, interdependent validations or value transformation.
- [axios](https://axios-http.com/docs/intro) - Axios is a promise-based HTTP Client for node.js and the browser. It is isomorphic (= it can run in the browser and Node.js with the same codebase). On the server-side, it uses the native node.js http module, while on the client (browser), it uses XMLHttpRequests.

## Installation
This application requires PHP 8.1 or higher, Composer, and Node.js version 16 or higher to run.

Once you have the requirements needed to run this application, clone this repository and navigate into the project directory.

## Application Setup
To get all the dependencies, run this command in your terminal:

```sh
npm install
```

Next, get all the dependencies of the Laravel application by running:

```sh
composer update
```

## Database Setup
Copy the `.env.example` file from the root directory and paste it within the directory. Rename it to `.env` and look for the `DB_DATABASE` variable. Change it to whatever you want and add the username and password of your MySQL connection:

```
DB_DATABASE=praxxys_db
DB_USERNAME=root
DB_PASSWORD=
```

## Table Migration & Seeding Data
Once you have set up the database, run this Laravel artisan command. Note that if you don't wish to populate or seed some data, you can remove the `--seed` flag:

```sh
php artisan migrate --seed
```

If you haven't created a database on your MySQL, you will see this message. Type "yes" to let the application generate a database:

```sh
WARN  The database 'praxxys_db' does not exist on the 'mysql' connection.  
Would you like to create it? (yes/no) [no]
```

When you see this message, you have successfully migrated all the needed tables of this application:

```sh
INFO  Preparing database.

Creating migration table .............................................................................................................. 165ms DONE

INFO  Running migrations.
2014_10_12_000000_create_users_table ................................................................................................... 58ms DONE
2014_10_12_100000_create_password_reset_tokens_table ................................................................................... 19ms DONE
2014_10_12_100000_create_password_resets_table ......................................................................................... 21ms DONE
2019_08_19_000000_create_failed_jobs_table ............................................................................................. 35ms DONE
2019_12_14_000001_create_personal_access_tokens_table .................................................................................. 23ms DONE
2023_06_23_080948_create_products_table ................................................................................................. 6ms DONE
2023_06_23_081Continued:

490_create_filters_table .................................................................................................... 4ms DONE
2023_06_23_081540_create_videos_table ................................................................................................... 3ms DONE
2023_06_23_082310_create_product_filter_table .......................................................................................... 7ms DONE
2023_06_24_091535_add_description_column_to_products_table .......................................................................... 4ms DONE
2023_06_24_091857_add_video_id_to_products_table ...................................................................................... 4ms DONE
2023_06_24_092049_add_slug_to_products_table ........................................................................................... 3ms DONE
2023_06_24_092221_add_brand_id_to_products_table ...................................................................................... 7ms DONE
2023_06_24_092703_add_price_to_products_table ......................................................................................... 3ms DONE
2023_06_24_092831_add_image_url_to_products_table .................................................................................... 3ms DONE
2023_06_24_093349_create_brands_table .................................................................................................. 4ms DONE
2023_06_24_093456_create_product_brand_table .......................................................................................... 4ms DONE
2023_06_24_094144_create_categories_table ............................................................................................ 4ms DONE
2023_06_24_094251_create_product_category_table ..................................................................................... 4ms DONE
2023_06_24_094821_add_is_featured_to_products_table .................................................................................. 3ms DONE
2023_06_24_095005_create_product_reviews_table ...................................................................................... 4ms DONE
2023_06_24_095109_add_rating_to_product_reviews_table ............................................................................... 3ms DONE
2023_06_24_095216_create_product_ratings_table ...................................................................................... 4ms DONE
2023_06_24_095433_create_product_images_table ...................................................................................... 3ms DONE
2023_06_24_095559_add_is_primary_to_product_images_table ........................................................................... 3ms DONE
2023_06_24_095830_create_product_videos_table ...................................................................................... 3ms DONE
2023_06_24_095943_add_is_primary_to_product_videos_table ........................................................................... 4ms DONE
2023_06_24_100108_add_is_featured_to_product_videos_table ......................................................................... 3ms DONE
2023_06_24_100235_create_filter_options_table ...................................................................................... 3ms DONE
2023_06_24_100313_create_filter_option_filter_table ................................................................................ 3ms DONE
2023_06_24_100443_create_product_filter_options_table .............................................................................. 3ms DONE

Database seeding completed successfully.
```

## Running the Application
After you have completed the installation and database setup, you can run the application using the following command:

```sh
php artisan serve
```

This will start the Laravel development server, and you can access the application by visiting `http://localhost:8000` on your web browser.

## Code Structure
The code structure of this application is organized into different directories, each serving a specific purpose:

- `app`: This directory contains the core application code, including models, controllers, and services.
- `config`: This directory contains all the application configuration files, including the database configuration, cache configuration, and more.
- `database`: This directory contains the database migration files, as well as the seeds for the database.
- `public`: This directory contains all the public assets, including the CSS, JavaScript, and images used in the application.
- `resources`: This directory contains all the resources used in the application, including the views, translations, and assets.
- `routes`: This directory contains all the application routes, including the web routes and API routes.
- `tests`: This directory contains all the application tests, including unit tests and feature tests.