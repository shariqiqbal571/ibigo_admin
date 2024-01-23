<?php 

namespace App\Repositories\Agreegate;

interface AgreegateInterface{
    public function findFoursquare();
    public function foursquareSearch($request,$all_spots);
    public function subscription($user,$request);
    public function getPayment($request);
    public function mailTestFor($request);
    public function getAllCms();
    public function viewSingleCms($id);
}