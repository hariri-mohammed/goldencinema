<?php

use App\Http\Controllers\manager\MovieController;
use App\Http\Controllers\manager\TrailerController;
use App\Http\Controllers\manager\auth\LoginController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use Faker\Guesser\Name;
use App\Http\Middleware\ManagerAuthenticate;

use App\Http\Controllers\manager\ManagerProfileController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\manager\MovieShowController;

//admin routes

require __DIR__ . '/admin/admin.php';
require __DIR__ . '/admin/admin_profile.php';
require __DIR__ . '/admin/managers.php';

//manager routes
require __DIR__ . '/manager/manager.php';
require __DIR__ . '/manager/categores.php';
require __DIR__ . '/manager/movies.php';
require __DIR__ . '/manager/move_shows.php';
require __DIR__ . '/manager/profile.php';
require __DIR__ . '/manager/theaters.php';
require __DIR__ . '/manager/screens.php';
require __DIR__ . '/manager/seats.php';
require __DIR__ . '/cinema/cinema.php';
require __DIR__ . '/manager/trailers.php';


// Client Routes
require __DIR__ . '/client/auth.php';
require __DIR__ . '/client/client.php';
require __DIR__ . '/client/public.php';

Route::get('/', [CinemaController::class, 'index']);
