<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\BadRequestException;
use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Login\LoginRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    private $__route = 'auth.login';
    private $__title = 'Login';

    public function index()
    {
        $data = [
            'route' => $this->__route,
            'title' => $this->__title,
        ];

        return view($this->__route . '.' . __FUNCTION__, $data);
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws BadRequestException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
//            $resultCheckCaptcha = $this->__checkCaptcha($request->input('token'), $request->input('action'));
//
//            if (!$resultCheckCaptcha) {
//                throw new BadRequestException('Invalid Captcha');
//            }

            $credential = $request->only('username', 'password');

            if (!Auth::attempt($credential)) {
                throw new BadRequestException('Email or password is wrong');
            }

            return response()->json([
                'success' => true,
                'message' => 'Login Success',
                'data' => null,
                'errors' => null
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            LogHelper::exception($e, __METHOD__);

            throw $e;
        }
    }

    /**
     * Check Captcha
     *
     * @param string $token
     * @param string $action
     * @return bool
     */
    private function __checkCaptcha(string $token, string $action): bool
    {
        $curl = curl_init();

        $headers = [
            'Content-type: application/x-www-form-urlencoded'
        ];

        $data = [
            'secret' => env('recaptcha3.secretKey'),
            'response' => $token,
//			    'remoteip' => $ipAddress
        ];

        $url = 'https://www.google.com/recaptcha/api/siteverify';

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => $headers
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);
        $errno = curl_errno($curl);

        curl_close($curl);

        if ($errno) {
            LogHelper::error($error, __METHOD__);

            return false;
        }

        $response = json_decode($response);

        return $response->success && $response->action === $action && $response->score >= 0.5;
    }
}
