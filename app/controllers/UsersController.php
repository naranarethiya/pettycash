<?php



/**
 * UsersController Class
 *
 * Implements actions regarding user management
 */
class UsersController extends BaseController
{

    /**
     * Displays the login form
     */
    public function login() {
    	 if (Auth::check()) {
    		return Redirect::to('/dashboard')->with("error","already loggedin");;	
    	}	
		return View::make('login');
    }

    /**
     * Attempt to do login
     */
    public function doLogin() {
       $rules = array(
			'email'    => 'required|email',
			'password' => 'required|min:3'
		);
		$validator = Validator::make(Input::all(), $rules);
		
		if ($validator->fails()) {
			return Redirect::to('login')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} 
		else {

			$userdata = array(
				'email' 	=> Input::get('email'),
				'password' 	=> Input::get('password')
			);

			// attempt to do the login
			if (Auth::attempt($userdata)) {
				return Redirect::to("/dashboard");
			} 
			else {
				return Redirect::to('/login')->with("error","Invalid username or password");;
			}
		}

    }
	
    public function logout() {
		Auth::logout();
		return Redirect::to('/'); 
    }
}
