<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;

class Recaptcha implements Rule
{
    public function passes($attribute, $value)
    {
        // Kunin ang Secret Key mula sa .env
        $secret = config('services.recaptcha.secret');

        // Kung walang key — hindi gagana
        if (empty($secret)) {
            return false;
        }

        // Ipadala ang kahilingan sa Google
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secret,
            'response' => $value,
        ]);

        $result = $response->json();

        // I-log para makita kung ano ang sinasabi ng Google
        logger()->info('reCAPTCHA Result:', $result);

        return isset($result['success']) && $result['success'] === true;
    }

    public function message()
    {
        return 'Please verify that you are not a robot.';
    }
}