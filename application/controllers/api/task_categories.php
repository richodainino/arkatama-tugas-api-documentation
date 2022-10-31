<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class task_categories extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('task_categories_model', 'task_categories');
    }

    public function index_get()
    {
        $id = $this->get('id');

        if (is_null($id)) {
            $task_categories = $this->task_categories->getTaskCategories();
        } else {
            $task_categories = $this->task_categories->getTaskCategories($id);
        }

        if ($task_categories) {
            $this->response([
                'status' => true,
                'data' => $task_categories
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'id not found'
            ], RestController::HTTP_NOT_FOUND);
        }
    }
    
    public function index_delete()
    {
        $id = $this->delete('id');
        
        if (is_null($id)) {
            $this->response([
                'status' => false,
                'message' => 'please provide an id'
            ], RestController::HTTP_BAD_REQUEST);
        } else {
            if ($this->task_categories->deleteTaskCategories($id) > 0) {
                // ok
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'deleted'
                ], RestController::HTTP_OK);
            } else {
                // id not found
                $this->response([
                    'status' => false,
                    'message' => 'id not found'
                ], RestController::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'name' => $this->post('name'),
        ];

        if ($this->task_categories->createTaskCategories($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new task categories has been created'
            ], RestController::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to create new data'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id = $this->put('id');
        $data = [
            'name' => $this->put('name'),
        ];

        if (is_null($id)) {
            $this->response([
                'status' => false,
                'message' => 'please provide an id'
            ], RestController::HTTP_BAD_REQUEST);
        } else {
            if ($this->tasks->updateTaskCategories($data, $id) > 0) {
                // ok
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'task categories has been updated'
                ], RestController::HTTP_OK);
            } else {
                // id not found
                $this->response([
                    'status' => false,
                    'message' => 'id not found'
                ], RestController::HTTP_BAD_REQUEST);
            }
        }
    }
}