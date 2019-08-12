<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Contracts;

/**
 * Description of UserInterface
 *
 * @author root
 */
interface Lead {

    public function all();

    public function allByCreatedAt($created_at);

    public function get($id);

    public function create(array $data);

    public function leadExists($email);

    public function update(array $data,$id);

    public function delete($id);

}
