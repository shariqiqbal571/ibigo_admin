<?php 

namespace App\Services\Interest;

use App\Repositories\Interest\InterestInterface;
use App\Repositories\Filter\FilterInterface;
use Illuminate\Http\Request;
use App\Models\Interest;
use App\Repositories\Spot\SpotInterface;
use App\Repositories\Event\EventInterface;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Factory as Validator;
use Illuminate\Contracts\Routing\ResponseFactory as Response;

class InterestService
{
    private $interest;
    private $filter;
    private $spot;
    private $event;
    private $validator;
    private $response;
    private $request;
    private $data = [];

    public function __construct(
        Validator $validator,
        InterestInterface $interest,
        SpotInterface $spot,
        EventInterface $event,
        FilterInterface $filter,
        Response $response,
        Request $request
    )
    {
        $this->interest = $interest;
        $this->spot = $spot;
        $this->event = $event;
        $this->filter = $filter;
        $this->response = $response;
        $this->validator = $validator;
        $this->request = $request;
    }

    public function validateInterest($request)
    {
        return $this->validator->make($request,[
            'title'=>'required',
            'description'=>'required',
            'icon'=>'required',
            'image'=>'required'
        ]);
    }

    public function get()
    {
        $user = Auth::user();
        if($user)
        {
            $data = $this->interest->getData('status',1,'show_in',0,2);
            return response()->json([
                'interests'=>$data,
                'status'=>true
            ],400);
        }
    }

    public function add($request)
    {
        $validate = $this->validateInterest($request);

        if($validate->fails())
        {
            $response['message'] = $validate->errors();
            $response['status'] = false;
            return response()->json($response,401);
        }
        else
        {
            // echo "<pre>";
            // print_r($request['description']);
            // exit();
            if($image = $request['image']){
                 
                $destination = 'public/images/interests';
                // $image = $request->file('image');
                $image_name = $image->getClientOriginalName();
                $path = $image->storeAs($destination,$image_name);

                $request['image'] = $image_name;
            }
            $this->data = [
                'title' => $request['title'],
                'description' => $request['description'],
                'icon'=>$request['icon'],
                'image' => $request['image'],
                'unique_id' => Str::uuid()
            ];
            $addData = $this->interest->store($this->data);
            $response['message'] = 'Interest successfully created!';
            $response['status'] = true;
            return response()->json($response,200);
        }
    }


    public function show($id)
    {
        $data = $this->interest->show($id);
        return response()->json([
            'interest'=>$data,
            'status'=>true
        ],400);
    }

    public function update($request,$id)
    {
        $validate = $this->validateInterest($request);

        if($validate->fails())
        {
            $response['message'] = $validate->errors();
            $response['status'] = false;
            return response()->json($response,401);
        }
        else
        {
            // echo "<pre>";
            // print_r($request['description']);
            // exit();
            if($image = $request['image']){
                 
                $destination = 'public/images/interests';
                // $image = $request->file('image');
                $image_name = $image->getClientOriginalName();
                $path = $image->storeAs($destination,$image_name);

                $request['image'] = $image_name;
            }

            $this->data = [
                'title' => $request['title'],
                'description' => $request['description'],
                'icon'=>$request['icon'],
                'image' => $request['image']
            ];
            $addData = $this->interest->update($id,$this->data,$id);
            $response['message'] = 'Interest successfully updated!';
            $response['status'] = true;
            return response()->json($response,200);
        }
    }

    public function delete($delete)
    {
        $this->interest->destroy($delete);
        $response['message'] = 'Interest successfully deleted!';
        $response['status'] = true;
        return response()->json($response,200);

    }

    public function view()
    {
        $user = Auth::user();
        if($user)
        {
            $address = $this->filter->twoWhere('status',1,'category','address');
            $who = $this->filter->twoWhere('status',1,'category','who');
            $what = $this->filter->twoWhere('status',1,'category','what');
            if($what)
            {
                foreach($what as $key => $value)
                {
                    if($value['name'] == 'Spot')
                    {
                        $spots = $this->spot->index();
                        $what[$key]['count'] = count($spots);
                    }
                    if($value['name'] == 'Event')
                    {
                        $event = $this->event->currentEvents('start_date_time',now());
                        $what[$key]['count'] = count($event);
                    }
                }
            }
            $when = $this->filter->twoWhere('status',1,'category','when');
            $categorieen = $this->filter->twoWhere('status',1,'category','categorieen');
            if($categorieen)
            {
                foreach($categorieen as $key => $value)
                {
                    $interest = $this->interest->findInterest('title',$value['name']);
                    if($interest)
                    {
                        $spots = $this->spot->spotsOfInterest(['userSpot'],'user_interests',$interest[0]['id']);
                        $categorieen[$key]['count'] = count($spots);
                    }
                    else{
                        $categorieen[$key]['count'] = 0;
                    }
                }
            }
            $specials = $this->filter->twoWhere('status',1,'category','specials');
            if($specials)
            {
                foreach($specials as $key => $value)
                {
                    $interest = $this->interest->findInterest('title',$value['name']);
                    if($interest)
                    {
                        $spots = $this->spot->spotsOfInterest(['userSpot'],'user_interests',$interest[0]['id']);
                        $specials[$key]['count'] = count($spots);
                    }
                    else{
                        $specials[$key]['count'] = 0;
                    }
                }
            }
            $interest = $this->interest->getData('status',1,'show_in',1,2);
            $response['address'] = $address;
            $response['who'] = $who;
            $response['what'] = $what;
            $response['when'] = $when;
            $response['categorieen'] = $categorieen;
            $response['specials'] = $specials;
            $response['interest'] = $interest;
            $response['status'] = true;
            $response['status_code'] = 201;
        }
        else{
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['status_code'] = 404;
        }
        return response()->json($response);
    }


}