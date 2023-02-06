<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseEloquentRepository
{
	protected Model $model;

	/**
	 * Class Constructor
	 * @param    $model
	 */
	public function __construct($model)
	{
		$this->model = $model;
	}

	/**
	 * Get all
	 * @param  array  $columns
	 * @return \Illuminate\Support\Collection
	 */
	public function all($columns = ["*"])
	{
		return $this->model->get($columns);
	}

	/**
	 * Paginate all
	 * @param  integer $perPage
	 * @param  array   $columns
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function paginate($perPage = 15, $columns = ['*'])
	{
		return $this->model->paginate($perPage, $columns);
	}

	/**
	 * Create new model
	 * @param  array  $data
	 * @return mixed
	 */
	public function create($data = [])
	{
		return $this->model->create($data);
	}

	/**
	 * Update model by the given ID
	 * @param  array  $data
	 * @param  integer $id
	 * @return mixed
	 */
	public function update($data, $id, $attribute = 'id')
	{
		return $this->model->where($attribute, $id)->update($data);
	}

	/**
	 * Delete model by the given ID
	 * @param  integer $id
	 * @return boolean
	 */
	public function delete($id)
	{
		return $this->model->destroy($id);
	}

	/**
	 * Find model by the given ID
	 * @param  integer $id
	 * @param  array  $columns
	 * @return mixed
	 */
	public function find($id, $columns = ['*'])
	{
		return $this->model->find($id, $columns);
	}

	/**
	 * Find model by a specific column
	 * @param  string $field
	 * @param  mixed $value
	 * @param  array  $columns
	 * @return mixed
	 */
	public function findBy($field, $value, $columns = ['*'])
	{
		return $this->model->where($field, $value)->first($columns);
	}
	/**
	 * Get many by a specific column
	 * @param  string $field
	 * @param  mixed $value
	 * @param  array  $columns
	 * @return \Illuminate\Support\Collection
	 */
	public function manyBy($field, $value, $columns = ['*'])
	{
		return $this->model->where($field, $value)->get($columns);
	}
}
