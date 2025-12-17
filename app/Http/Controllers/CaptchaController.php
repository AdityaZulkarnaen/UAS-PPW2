<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CaptchaController extends Controller
{
    public function generate()
    {
        // Generate random captcha text (mix of letters and numbers)
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $captchaText = '';
        for ($i = 0; $i < 6; $i++) {
            $captchaText .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        // Store in session
        session(['captcha' => $captchaText]);
        
        // Return captcha as JSON for text-based display
        return response()->json(['captcha' => $captchaText]);
    }
    
    public static function validate($input)
    {
        $sessionCaptcha = session('captcha');
        // Case-insensitive comparison
        return strtoupper($sessionCaptcha) === strtoupper($input);
    }
}
