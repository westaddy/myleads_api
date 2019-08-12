<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\ResponseBody;
use App\Services\UserImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use URL;
use App\User;

class LoginController extends Controller {

    public $userRepo;
    public $profileRepo;
    protected $jwt;
    public $responseBody;

    public function __construct(UserImpl $userRepo, JWTAuth $jwt,ResponseBody $response) {
        $this->userRepo = $userRepo;
        $this->jwt = $jwt;
        $this->responseBody = $response;
        $this->middleware('jwt.auth', ['only' => ['logout']]);
    }

    protected function authenticate(array $data) {



        $user = User::where('email', $data['email'])->first();

        if (Hash::check($data['password'], $user->password)) {

            return true;
        } else {

            return false;
        }
    }

    public function login(Request $request) {



        try {

            $token = $this->jwt->attempt($request->only('email', 'password'));

            if ($token == null) {
                $this->responseBody->setSuccess(false);
                $this->responseBody->setMessage('Email or Password is incorrect');
                $this->responseBody->setData(null);
                return response()->json($this->responseBody, 404);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            $this->responseBody->setSuccess(false);
            $this->responseBody->setMessage('Your token is expired, please login again');
            $this->responseBody->setData(null);
            return response()->json($this->responseBody, 500);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            $this->responseBody->setSuccess(false);
            $this->responseBody->setMessage('Your token is invalid');
            $this->responseBody->setData(null);
            return response()->json($this->responseBody, 500);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            $this->responseBody->setSuccess(false);
            $this->responseBody->setMessage($e->getMessage());
            $this->responseBody->setData(null);
            return response()->json($this->responseBody, 500);
        }

        $user = array(
            'token' => $token,
            'id' => Auth::id()
        );

        $this->responseBody->setSuccess(true);
        $this->responseBody->setMessage('Login successfully');
        $this->responseBody->setData($user);
        return response()->json($this->responseBody);

    }

    public function logout() {
        $this->jwt->invalidate($this->jwt->getToken());

        $this->responseBody->setSuccess(true);
        $this->responseBody->setMessage('Logout successful');
        $this->responseBody->setData(null);
        return response()->json($this->responseBody);
    }

}
