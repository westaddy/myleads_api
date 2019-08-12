<?php

namespace App\Http\Controllers;

use App\ResponseBody;
use App\Services\LeadImpl;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $leadRepo;
    public $responseBody;
    public function __construct(LeadImpl $leadRepo,ResponseBody $response)
    {
        $this->leadRepo = $leadRepo;
        $this->responseBody = $response;
        $this->middleware('jwt.auth');
    }

    public function index(Request $request){
        $leads = $this->leadRepo->allByCreatedAt();
        $this->responseBody->setSuccess(true);
        $this->responseBody->setMessage(null);
        $this->responseBody->setData($leads);
        return response()->json($this->responseBody);
    }

    public function store(Request $request){

        if ($this->leadRepo->leadExists($request->email)) {
            $this->responseBody->setSuccess(false);
            $this->responseBody->setMessage('Contact exists');
            $this->responseBody->setData(null);
            return response()->json($this->responseBody,422);
        }
        $lead = $this->leadRepo->create($request->all());
        $this->responseBody->setSuccess(true);
        $this->responseBody->setMessage('Lead Created successfully');
        $this->responseBody->setData(null);
        return response()->json($this->responseBody);
    }

    public function update(Request $request,$id){

        $this->leadRepo->update($request->all(),$id);
        $this->responseBody->setSuccess(true);
        $this->responseBody->setMessage('Lead Updated successfully');
        $this->responseBody->setData(null);
        return response()->json($this->responseBody);
    }

    public function destroy($id){

        if($this->leadRepo->delete($id)){
            $this->responseBody->setSuccess(true);
            $this->responseBody->setMessage('Lead Deleted successfully');
            $this->responseBody->setData(null);
            return response()->json($this->responseBody);
        }
        else{
            $this->responseBody->setSuccess(false);
            $this->responseBody->setMessage('Error occured while deleting lead');
            $this->responseBody->setData(null);
            return response()->json($this->responseBody);
        }

    }

}
