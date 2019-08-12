<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use App\Contracts\Lead as LeadContract;
use App\Lead;
use DB;
use App\Bidding;
use Illuminate\Support\Facades\Auth;
/**
 * Description of UserRepo
 *
 * @author root
 */
class LeadImpl implements LeadContract {

    public $lead;

    public function __construct(Lead $lead) {
        $this->lead = $lead;
    }

    public function all() {
        return $this->lead->all();
    }

    public function get($id) {
        return $this->lead->where('id', $id)->whereDeleted(false)->first();
    }

    public function create(array $data) {
        return $this->lead->create($data);
    }

    public function update(array $data,$id) {
        $this->lead->where('id', $id)->update($data);
    }

    public function delete($id) {
        return $this->lead->where('id', $id)->delete();
    }

    public function leadExists($email) {
        if ($this->lead->where('email', $email)->exists()) {
            return true;
        }
        return false;
    }


}
