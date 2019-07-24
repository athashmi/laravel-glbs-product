<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use App\Shopaholic;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return  User::create([
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'first_name' => $data['first_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }


    public function register(Request $request)
    {
       
        $this->validator($request->all())->validate();
        $user = $this->create($request->all());
        $role = Role::where('name','shopaholic')->first();
        $user->roles()->attach($role->id);
        $shopaholic = new Shopaholic();
        $shopaholic->logged_in  = 1;
        $shopaholic->sn         = 'sn-'.$user->id;
        $shopaholic_saved = $user->shopaholic()->save($shopaholic);
        if($shopaholic_saved)
        {
            $this->guard()->login($user);
            event(new Registered($user));
            if ($user) {
                $msg['status'] = 1;
                $msg['url']    = route('client_dashboard');
                return json_encode($msg);
            } else {
                $msg['status'] = 0;
                return json_encode($msg);
            }
        }
        else {
                $msg['status'] = 0;
                return json_encode($msg);
            }
        
    }


    public function showRegistrationForm(Request $request)
    {
        $current_url = $request->path(); 
        if($current_url == 'register')
        {
          return view('frontend.auth.register'); 
        }else
        {
            $previous_url = url()->previous();
            return redirect($previous_url);
        }
        
    }
}
