<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

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

    use AuthenticatesAndRegistersUsers;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {

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
            'level' => 'required|between:1,4',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function firstConnexionValidator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'school_year' => 'required',
            'department_id' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function login()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        if($request->email != '' && $request->password != '')
        {
            $test = User::where('email', $request->email)->first();
            if(empty($test))
            {
                Flash::error("Impossible de vous connecter, l'adresse renseignée n'est pas valide.");
                return redirect('auth/login');
            }

            if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
            {
            	$user = Auth::user();
                if($user->first_name == '')
                {
                    return redirect('auth/firstconnexion');
                }

                Flash::success('Vous êtes maintenant connecté !');
                return redirect('/');
            }

            Flash::error('Impossible de vous connecter, le mot de passe est incorrect.');
            return redirect('auth/login');
        } 

        Flash::error('Vous devez remplir tous les champs pour vous connecter.');
        return redirect('auth/login');
    }

    public function firstConnexion()
    {
        return view('auth/first_connexion');
    }

    /**
    *  @param $request : [first_name, last_name, password, password_confirmation, school_year, department_id]
    */
    public function postFirstConnexion(Request $request)
    {
        $validator = $this->firtConnexionValidator($request->all());
        if($validator->fails())
        {
            return Redirect::back()->withErrors($validator->errors())->withInput();
        }
        else
        {
            $user = Auth::user();
            $user->logout();
            $user->update([$request->all()]);
            if(Auth::login($user))
            {
                Flash::success('Votre compte a bien été mis à jour !');
                return redirect('/');
            }

            Flash::error('Une erreur est survenue. S\'il vous est impossble de vous reconnecter, contactez un administrateur.');
            return redirect('/');
        }
    }

    public function register()
    {
        return view('auth.register');
    }

    /**
    * @param $request : [email, password, password_confirmation, level{1,2,3,4.}]
    */
    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if($validator->fails())
        {
        	return Redirect::back()->withErrors($validator->errors())->withInput();
        }

        if($user = User::create($request->all()));
        {
        	Flash::sucess("Le compte associé à l'adresse \"$request->email\" a bien été créé.");
        	return Redirect::back();
        }

        Flash::error('Une erreur est survenue. Si le problème persiste, contactez un administrateur.');
    	return Redirect::back()->withInput();
    }

    public function logout()
    {
    	Auth::logout();
    	FLash::success('Vous êtes maintenant déconnecté.');
    	return redirect('/');
    }
}
