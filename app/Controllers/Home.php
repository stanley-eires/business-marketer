<?php namespace App\Controllers;

use Config\Services;

class Home extends BaseController
{
    public function index()
	{
		return $this->login();

	}
	public function login()
	{
		$data['title'] = "Login";
        return view('general/login', $data);

	}
	public function attemptLogin()
    {
        $throttler = Services::throttler();

        if ($throttler->check($this->request->getIPAddress(), 2, MINUTE) === false) {
            return Services::response()->setStatusCode(429)->setBody("Too many requests. Please wait " .$throttler->getTokentime()." Seconds");
        }

        if (! $this->validate(['username'	=> 'required', 'password' => 'required|min_length[6]'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

		$credentials = $this->request->getPost(['username',"password"]);
	
        if (! auth_attempt($credentials)) {
            return redirect()->back()->withInput();
        }
        if (session()->has("redirect_url") && session("redirect_url")) {
            $redirectURL = session('redirect_url');
            unset($_SESSION['redirect_url']);
            return redirect()->to($redirectURL);
        } else {
            return redirect()->to("bulk");
        }
	}
	
	    public function logout()
    {
        session()->destroy();
        return redirect()->to("login");
    }

	//--------------------------------------------------------------------

}
