<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Contracts;

/**
 * Description of UserContract
 *
 * @author root
 */
interface User {

    public function all();

    public function get($id);

    public function create(array $data);

    public function userExists($email);

    public function update(array $data);

    public function passwordExists($email, $password);

}
