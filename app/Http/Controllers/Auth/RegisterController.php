<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\ResponseBody;
use App\Services\UserImpl;
use Illuminate\Http\Request;
use App\Events\UserRegistered;
use Tymon\JWTAuth\JWTAuth;
use App\Wallet;
use App\ReferalCode;
use App\Referal;
use App\User;
use DB;

class RegisterController extends Controller {
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $userRepo;
    public $profileRepo;
    protected $jwt;
    public $responseBody;

    public function __construct(UserImpl $userRepo, JWTAuth $jwt,ResponseBody $response) {
        $this->userRepo = $userRepo;
        $this->jwt = $jwt;
        $this->responseBody = $response;
        $this->middleware('jwt.auth', ['only' => ['changePassword']]);
    }

    public function register(Request $request) {

        $count = User::whereEmail($request->email)->count();
        if ($count > 0) {
            $this->responseBody->setSuccess(false);
            $this->responseBody->setMessage('Email already exist. Please login');
            $this->responseBody->setData(null);
            return response()->json($this->responseBody,422);
        }

        $data = [
            'full_name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'company' => $request->company,
        ];

        $user = $this->userRepo->create($data);
        //event(new UserRegistered($user));

        $this->responseBody->setSuccess(true);
        $this->responseBody->setMessage('Login successfully');
        $this->responseBody->setData([
            'token' => $this->jwt->fromUser($user),
            'id' => $user->id
        ]);
        return response()->json($this->responseBody);
    }

}
