<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'     => $data[ 'name' ],
            'email'    => $data[ 'email' ],
            'password' => bcrypt($data[ 'password' ]),
        ]);
    }


    /**
     * Get the guard to be used during authentication.
     *
     * Extension to check which guard to use
     *
     * @return string|null
     */
    protected function getGuard()
    {
        if ( $this->userAccountIsMigrated() ) {
            return property_exists($this, 'guard') ? $this->guard : null;
        }

        return 'legacy';
    }

    /**
     * Business logic to determine if the user is migrated already and we can use the Laravel guard
     *
     * @return bool
     */
    protected function userAccountIsMigrated()
    {
        return User::where('email', request('email'))->count() > 0;
    }
}
