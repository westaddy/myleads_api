<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use App\User;
use App\Contracts\User as UserContract;
use DB;
use App\Bidding;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
/**
 * Description of UserRepo
 *
 * @author root
 */
class UserImpl implements UserContract {

    public $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function all() {
        return $this->user->all();
    }

    public function get($id) {
        return $this->user->where('id', $id)->whereDeleted(false)->first();
    }

    public function create(array $data) {
        dd(app('hash')->make($data['password']));
        return $this->user->create([
                    'full_name' => $data['full_name'],
                    'email' => $data['email'],
                    'company' => $data['company'],
                    'phone' => $data['phone'],
                    'password' => app('hash')->make($data['password']),
        ]);
    }

    public function update(array $data) {
        $this->user->where('id', Auth::user()->id)->update($data);
    }

    public function userExists($email) {
        if ($this->user->where('email', $email)->where('deleted',false)->value('email') != '') {
            return true;
        }
        return false;
    }

    public function passwordExists($email, $password) {

        if (Hash::check($password, $this->user->where('email', $email)->value('password'))) {
            return true;
        }
        return false;
    }

}
