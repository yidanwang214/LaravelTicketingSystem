<?php

use App\Models\User;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Profile\AvatarController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use OpenAI\Laravel\Facades\OpenAI;
use Laravel\Socialite\Facades\Socialite;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');

    // normal query
    // $user = DB::insert('insert into users(name, email, password) values (?,?,?)', [
    //     'Yidan Wang',
    //     'yidan.eden.wang@gmail.com',
    //     'passowrd',
    // ]);
    // // query builder
    // $user = DB::table('users')->insert([
    //     'name' => 'Yidan Wang',
    //     'email' => 'yidan.wang02@adelaide.edu.au',
    //     'password' => 'password',
    // ]);
    // // eloquent
    // $user = User::create([
    //     'name' => 'Yidan Wang',
    //     'email' => 'yidanwang3@gmail.com',
    //     'password' => 'password',
    // ]);
    // hash password by bcrypt() function
    // $user =DB::table('users')->insert([
    //     'name' => 'Yidan Wang',
    //     'email' => 'yidanwang4@gmail.com',
    //     'password' => bcrypt('password'),
    // ]);
    // hash password by using setter() function
    // $user = User::create([
    //     'name' => 'Yidan Wang',
    //     'email' => 'yidanwang5@gmail.com',
    //     'password' => 'password',
    // ]);
    // accessor
    // $user = User::find('11');
    // dd($user->name);


    /*
    // 1. manage database using Eloquent
    // have to import User model to web.php before using it
    // 1.1 read
    // $users = User::where('id',1)->first();
    // create
    // $users = User::create([
    //     'name' => 'Alice',
    //     'email' => 'aliceM@gmail.com',
    //     'password' => 'alice_password',
    // ]);
    // 1.2 update
    // $users = User::where('id', 5)->update([
    //     'email' => 'aliceABC@gmail.com'
    // ]);
    // alternatively, we can also manipulate the varaible directly
    // $users = User::find(5);
    // $users->update([
    //     'email' => 'aliceM@test.com',
    // ]);
    // 1.3 delete
    // $users = User::find(6);
    // $users -> delete();
    // foreach(User::all() as $users){
    //     echo $users->email.' ';
    // };
    // User::where('id',1)->delete();
    // dd(User::all());
    */

    /* 
    // 2. manage database using query builder
    // ref: https://laravel.com/docs/10.x/queries#delete-statements
    // 1. select
    $users = DB::table('users')
    // ->where('id',1)
    ->get();
    // 2. insert
    // $users = DB::table('users')->insert([
    //     'name' => 'Yifan Wang',
    //     'email' => 'yifanwang@qq.com',
    //     'password' => 'YifanWang!!2024'
    // ]);
    // 3. update
    // $users = DB::table('users')
    // ->where('name', 'Yifan Wang')
    // ->update(['email' => 'yifanwangtest@qq.com']);
    // 4. delete
    // $users = DB::table('users')->where('name', 'Yifan Wang')->delete();
    // 5. get the first record in table
    // $users = DB::table('users')->first();
    // 6. replace where() with find()
    // $users = DB::table('users')->find(1); // get the row where id = 1
    dd($users);
    */

    /* 3. manage database using DB facade normal query
    // DB doc: https://laravel.com/docs/10.x/database
    // 1. fetch user 
    $users = DB::select('select * from users');
    // 2. create new users
    // DB::insert('insert into users (name, email, password) values (?, ?, ?)', ['Yifan Wang', 'yifanwang@gmail.com', 'YifanWang!2024']);
    // 3. update users
    // $users = DB::update('update users set email = ? where name = ?', ['yifanwangEB@qq.com','Yifan Wang']);
    // $users = DB::update("update users set email = 'yifanwangEBtest@qq.com' where name = 'Yifan Wang'");
    // 4. delete users
    // $users = DB::delete("delete from users where name = 'Yifan Wang'");
    dd($users); // dump and die
    */
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Middleware in Laravel is a way to filter HTTP requests entering your application. The 'auth' middleware, in particular, is often used to ensure that a user is authenticated before accessing certain routes.
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::patch is used for routes that handle partial updates to a resource.
    Route::patch('/profile/avatar', [AvatarController::class, 'update'])->name('profile.avatar');
    Route::post('/profile/avatar.ai', [AvatarController::class, 'generate'])->name('profile.avatar.ai');
    
    // // routes for tickets handling
    // Route::resource('ticket', TicketController::class);
});

Route::middleware('auth')->prefix('ticket')->name('ticket.')->group(function(){
    // routes for tickets handling
    Route::resource('/', TicketController::class);
});

require __DIR__.'/auth.php';


 
Route::post('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
})->name('login.github');

Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();
    $user = User::firstOrCreate(['email' => $user->email], [
        'name' => $user->nickname,
        'password' => 'password',
    ]);

    Auth::login($user);
    return redirect('/dashboard');
});
