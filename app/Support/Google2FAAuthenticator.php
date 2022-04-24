<?php

namespace App\Support;

use Crypt;
use PragmaRX\Google2FALaravel\Support\Authenticator;

class Google2FAAuthenticator extends Authenticator
{
    protected function canPassWithoutCheckingOTP()
    {

        if($this->getUser()->google2fa_secret == null)
            return true;
        return
            !$this->getUser()->google2fa_secret ||
            !$this->isEnabled() ||
            $this->noUserIsAuthenticated() ||
            $this->twoFactorAuthStillValid();
    }

    protected function getGoogle2FASecretKey()
    {
        $secret = Crypt::decrypt($this->getUser()->{$this->config('otp_secret_column')}); //$this->getUser()->google2fa_secret; // ->{$this->config('otp_secret_column')};

        if (is_null($secret) || empty($secret)) {
            throw new InvalidSecretKey('Secret key cannot be empty.');
        }

        return $secret;
    }

}