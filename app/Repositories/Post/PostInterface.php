<?php 

namespace App\Repositories\Post;

use App\Repositories\Core\CoreInterface;

interface PostInterface extends CoreInterface{
    public function get($column,$key,$value,$params = []);
    public function relationPost($relation = [],$column,$id = []);
    public function wherePost($column1,$value1,$column2,$value2);
    public function post($relation = [],$column1,$operator,$value1,$column2,$value2 = [],$table,$value3);
    public function businessPost($relation = [],$table,$column1,$value1,$column2,$value2 = [],$table2,$value3);
    public function userPost($relation = [],$column1,$column2,$column3,$value1,$column,$value = [],$table,$value3);
    public function postForUserProfile($relation=[],$select=[],$column,$value);
    public function homePost($column1,$value1);
    public function getAllPostHome($relation = [],$column2,$value2 = [],$table,$column,$column1,$column3,$value1,$value3,$skip,$take);
    public function getAllGroupPosts($column1,$column2,$value1,$relation = []);
}