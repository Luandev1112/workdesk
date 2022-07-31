<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;
use Session;
use App\User;
use App\Models\Role;
use App\Models\Address;
use App\Models\UserRole;
use App\Models\UserProfile;
use Illuminate\Support\Str;
use CoreComponentRepository;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('frontend.default.user_login');
    }

    public function handleProviderCallback(Request $request, $provider)
    {
        try {
            if($provider == 'twitter'){
                $user = Socialite::driver('twitter')->user();
            }
            else{
                $user = Socialite::driver($provider)->stateless()->user();
            }
        } catch (\Exception $e) {
            flash("Something Went wrong. Try again.")->error();
            return redirect()->route('user.login');
        }

        // check if they're an existing user
        $existingUser = User::where('provider_id', $user->id)->orWhere('email', $user->email)->first();
        if($existingUser){
            // log them in
            auth()->login($existingUser, true);
            
            $user_profile = UserProfile::where('user_id', auth()->user()->id)->first();            
        } else {
            // create a new user
            $newUser                  = new User;
            $newUser->name            = $user->name;
            $newUser->user_name       = Str::slug($user->name, '-').date('Ymd-his');
            $newUser->email           = $user->email;
            $newUser->provider_id     = $user->id;

            $newUser->save();
            Session::put('new_user', true);            

            $user_profile = new UserProfile;
            $user_profile->user_id = $newUser->id;
            $user_profile->save();

            $address = new Address;
            $newUser->address()->save($address);

            auth()->login($newUser, true);
        }
        if(session('link') != null){
            return redirect(session('link'));
        }
        else{
            return redirect()->route('dashboard');
        }
    }


    public function authenticated()
    {
        if(auth()->user()->user_type == ' ' || auth()->user()->user_type == 'staff')
        {
            CoreComponentRepository::instantiateShopRepository();
            return redirect()->route('admin.dashboard');
        }
        else {
            if(auth()->user()->banned){
                flash('You are banned')->warning();
                return redirect()->route('home');
            }
            if(auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'staff')
            {
                CoreComponentRepository::instantiateShopRepository();
                return redirect()->route('admin.dashboard');
            }

            if(session('link') != null){
                return redirect(session('link'));
            }
            else{
                return redirect()->route('dashboard');
            }
        }
    }

    public function logout(Request $request)
    {
        if(auth()->user() != null && (auth()->user()->user_type != null && auth()->user()->user_type == "admin" || auth()->user()->user_type == "staff")){
            $redirect_route = 'admin.login';
        }
        else{
            $redirect_route = 'dashboard';
        }

        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect()->route($redirect_route);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
