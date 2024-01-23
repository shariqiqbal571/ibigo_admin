<?php

namespace App\Repositories\Core;


abstract class CoreRepository implements CoreInterface
{

    protected $model;


    public function __construct($model)
    {
        $this->model = new $model;
    }


    public function model(): object
    {
        return $this->model;
    }


    public function index($options = [])
    {
        return $this->model()->all();
    }


    public function show($id)
    {
        return $this->model()->find($id);
    }


    public function store($params = [])
    {
        /**todo: more enhancement required**/
        return $this->model()->create($params);
    }


    public function update($id, $params = [], $where = [])
    {
        $record = $this->model()->find($id);
        if ($where) {
            $record->where($where);
        }
        $record->update($params);
        $record = $this->model()->find($id);


        return $record;
    }

    public function edit($column,$params = [],$id)
    {
        return $this->model()->where($column,$id)->update($params);
    }

    public function destroy($id)
    {
        return $this->model()->destroy($id);
    }

    public function delete($column,$id)
    {
        return $this->model()->where($column,$id)->delete();
    }

    public function where($column, $value)
    {
        return $this->model()->where($column, $value)->get()->toArray();
    }

    public function relation($relation = [])
    {
        return $this->model()->with($relation)->get()->toArray();
        
    }


}