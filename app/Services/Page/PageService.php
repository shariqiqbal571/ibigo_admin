<?php 

namespace App\Services\Page;

use App\Repositories\Page\PageInterface;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Factory as Validator;
use Illuminate\Contracts\Routing\ResponseFactory as Response;
use Illuminate\Support\Facades\Auth;


class PageService
{
    private $page;
    private $validator;
    private $response;
    private $request;
    private $data = [];

    public function __construct(
        Validator $validator,
        PageInterface $page,
        Response $response,
        Request $request
    )
    {
        $this->page = $page;
        $this->response = $response;
        $this->validator = $validator;
        $this->request = $request;
    }

    public function get()
    {
        $user = Auth::user();
        if($user)
        {
            $pages = $this->page->where('page_status',1);
            $response['pages'] = $pages;
            $response['status'] = true;
            $response['code'] = 201;
        }
        else{
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['code'] = 404;
        }
        return response()->json($response);
    }

    public function view($id)
    {
        $user = Auth::user();
        if($user)
        {
            $pages = $this->page->show($id);
            $response['pages'] = $pages;
            $response['status'] = true;
            $response['code'] = 201;
        }
        else{
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['code'] = 404;
        }
        return response()->json($response);
    }
}