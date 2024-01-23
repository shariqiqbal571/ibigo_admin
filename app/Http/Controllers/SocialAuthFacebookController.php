<?php

namespace App\Http\Controllers;

use App\Services\FacebookLoginService\SocialFacebookAccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;


class SocialAuthFacebookController extends Controller
{
   /**
   * Create a redirect method to facebook api.
   *
   * @return void
   */
  public function redirect()
  {
      return Socialite::driver('facebook')->redirect();
  }

  /**
   * Return a callback method from facebook api.
   *
   * @return callback URL from facebook
   */
  public function callback(SocialFacebookAccountService $service)
    {
        $user = $service->createOrGetUser(Socialite::driver('facebook')->user());
        Auth::login($user);
        return redirect()->to('/home');
    }
}
