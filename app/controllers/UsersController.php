<?php



/**
 * UsersController Class
 *
 * Implements actions regarding user management
 */
class UsersController extends BaseController
{

	protected $layout = 'layouts.master';
    /**
     * Displays the login form
     */
    public function login() {
    	 if (Auth::check()) {
    		return Redirect::to('/dashboard');
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
				if(Auth::user()->user_type == 'admin') {
					return Redirect::to("/user/add");
				}
				else {
					return Redirect::to("/dashboard");	
				}
				
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

    public function addUserForm($id=false) {
    	$this->layout->title="Add User";
    	$data['users']=DB::table('users as u1')
    		->rightJoin('users as u2','u1.uid','=','u2.parent')
    		->select('u1.name as parent_name','u2.*')
    		->get();
		$user=false;
		if($id) {
			$user=User::find($id);
		}
		$data['parent']=User::where('parent','=','0')->where('user_type','=','user')->get();
    	$this->layout->content =View::make('userAddForm')
    		->with('data',$data)
    		->with('user',$user);
    }

    public function addUser($id=false) {
    	$rules=array(
			'name'=>'required',			
			'mobile'=>'required|digits:10',
			'user_type'=>'required|in:user,admin,viewer'
		);

		if(!$id) { 
			$rules['confirm_password']='required|same:password';
			$rules['password']='required|min:5';
			$rules['email']='required|email|unique:users';
		}

		$messages =array(
			'name.required'=>'Name is required',
			'password.min' =>'Password must long than 5 character',
			'confirm_password.same'=>'Confirm password does not match',
			'mobile.digits'=>'Invali mobile number',
			'email.email'=>'Invali email address',
			'email.unique' =>'Email already register',
			'user_type.in' =>'Invalid user type'
		);

		$validator = Validator::make(Input::all(),$rules,$messages);

		if($validator->fails()) {
			return Redirect::back()
				->with('error','Plsease Fix the errors')
				->withInput()
				->withErrors($validator);
		}

		if($id) {
			$user=User::find($id);
			if(Input::get('password')!='') {
				$user->password=Hash::make(Input::get('password'));
				$user->temp=Input::get('password');	
			}
		}
		else {
			$user=new User;	
			$user->password=Hash::make(Input::get('password'));
			$user->temp=Input::get('password');	
			$user->email=Input::get('email');
		}
		
		$user->name=Input::get('name');
		$user->mobile=Input::get('mobile');
		$user->user_type=Input::get('user_type');
		$user->save();
		
		if(!$id) {
			GlobalHelper::setMessage('User Added successfully','suceess');
		}	
		else {
			GlobalHelper::setMessage('User Updated successfully','success');	
		}
		return Redirect::to('user/add');
    }
}
