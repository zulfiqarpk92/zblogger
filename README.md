# ZBlogger Setup Guide

The project is created using Laravel and VueJS. Laravel is used as backend and VueJS is used for the frontend. The project is created with mono-repo style. The frontend is a single page application (SPA). 

Instructions for setting up the project on local machine.

## Requirements

Please install the following softwares before setting up the project:

- PHP 7.4 OR 8.0
- Composer: [Download and Install Composer](https://getcomposer.org/download/)
- Node.js 16: [Download and Install Node.js](https://nodejs.org/en/download/)

## Setup Steps

1. Open your terminal or command prompt.

2. Clone the repository `git clone https://github.com/zulfiqarpk92/zblogger` and then navigate to the root directory of the project.

3. Install the project dependencies:

   ```
   composer install
   ```

4. Copy the `.env.example` file and rename it to `.env` if it is not copied by the composer install command. 

   ```
   cp .env.example .env
   ```

5. Generate a application key:

   ```
   php artisan key:generate
   ```

6. Run the database migrations:

   ```
   php artisan migrate
   ```

7. Install frontend dependencies:

   ```
   npm install
   ```

8. Run backend project:

   ```
   php artisan serve
   ```
9. Open another terminal or command prompt window and run frontend in development mode (hot reloading):

   ```
   npm run dev
   ```
10. Open browser and visit localhost:8000 to see the project in action.

## Credits

- [Laravel](https://laravel.com/)
- [VueJS](https://v2.vuejs.org/)
- [VueX](https://v3.vuex.vuejs.org/)
- [Vuetify](https://vuetifyjs.com/en/)
