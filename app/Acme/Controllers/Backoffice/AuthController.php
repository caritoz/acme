<?php
namespace Acme\Controllers\Backoffice;

class AuthController extends \BaseController
{
	/**
	 * Display the login page
	 * @return View
	 */
	public function getLogin()
	{
		return \View::make('admin.login');
	}

	/**
	 * Login action
	 * @return Redirect
	 */
	public function postLogin()
	{
		$credentials = array(
			'email'    => \Input::get('email'),
			'password' => \Input::get('password')
		);

        try
        {
            $user = \Sentry::authenticate($credentials, false);
            if ($user)
            {
                return \Redirect::route('admin.index');
//                if(Input::get('remember_me')=='true')
//                    \Sentry::loginAndRemember($user);
            }
        }
        catch(\Exception $e)
        {
            return \Redirect::route('admin.login')->withErrors(array('login' => $e->getMessage()));
        }

        try
        {
            \Sentry::login($user, false);
        }
        catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            return \Redirect::route('admin.login')->withErrors(array('login' => 'Login field is required.'));
        }
        catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
        {
            return \Redirect::route('admin.login')->withErrors(array('login' => 'User not activated.'));
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            return \Redirect::route('admin.login')->withErrors(array('login' => 'User not found.'));
        }
        catch(\Exception $e)
		{
			return \Redirect::route('admin.login')->withErrors(array('login' => $e->getMessage()));
		}

	}

	/**
	 * Logout action
	 * @return Redirect
	 */
	public function getLogout()
	{
		\Sentry::logout();

		return \Redirect::route('admin.login');
	}

    public function activate($id, $activationCode)
    {
        try
        {
            $user = \Sentry::findUserById($id);
            /* @var $user \Acme\Models\User */

            if ($user->attemptActivation($activationCode))
            {
                $resetPasswordCode = $user->getResetPasswordCode();

                return \Redirect::route('admin.reset-password', array('id' => $user->id, 'reset-password-code' => $resetPasswordCode))
                    ->with(['success' => 'You have activated your account! Please choose your new password.']);
            }

//            return \View::make('admin.auth.activation-expired', [
//                'adminEmail' => \PublishrSetting::get('SystemEmailToAddress')
//            ]);
        }
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            return \Redirect::route('admin.login')->with(['danger' => 'The user requested does not exist.']);
        }
        catch (\Cartalyst\Sentry\Users\UserAlreadyActivatedException $e)
        {
            return \Redirect::route('admin.login')->with(['warning' => 'This user has already been activated.']);
        }
    }
}