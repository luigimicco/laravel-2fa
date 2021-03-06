<?php

namespace App\Http\Controllers;

use Crypt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

//use Cache;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Contracts\Auth\Authenticatable;
use Hash;

class Google2FAController extends Controller
{
    use ValidatesRequests;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function enableDisable(Request $request)
    {

        //get user
        $user = $request->user();

        if ($user->google2fa_secret) {
            return view('2fa/enable_disable');
        } else {
            //generate new secret
            $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());
            $secret = $google2fa->generateSecretKey();

            //generate image for QR barcode
            $imageDataUri = $google2fa->getQRCodeInline(
                env('APP_NAME', $request->getHttpHost()),
                $user->email,
                $secret,
                200
            );

            return view('2fa/enable_disable', [
                'image' => $imageDataUri,
                'secret' => $secret
            ]);
        }
    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function set2FA(Request $request)
    {

        $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());

        //get user
        $user = $request->user();
        $secret = $request->input('secret');
        $secretcode = $request->input('secretcode');


        // check code
        $valid = $google2fa->verifyKey($secretcode, $secret);
        if ($valid) {
            //encrypt and then save secret
            $user->google2fa_secret = Crypt::encrypt($secretcode);
            $user->save();
            return redirect('home')->with('alert_type', 'success')->with('alert_message', "2FA is enabled successfully.");
        } else {
            return redirect('home')->with('alert_type', 'danger')->with('alert_message', "Invalid verification Code, Please try again..");
        }
    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function unset2FA(Request $request)
    {
        $validatedData = $request->validate([
            'current-password' => 'required',
        ]);

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with('alert_type', 'danger')->with('alert_message', "Your password does not matches with your account password. Please try again.");
        }

        $user = Auth::user();
        $user->google2fa_secret = null;
        $user->save();
        return redirect('home')->with('alert_type', 'success')->with('alert_message', "2FA is now disabled.");
    }
}
