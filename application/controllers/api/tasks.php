<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class tasks extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tasks_model', 'tasks');
    }

    public function index_get()
    {
        $id = $this->get('id');

        if (is_null($id)) {
            $tasks = $this->tasks->getTasks();
        } else {
            $tasks = $this->tasks->getTasks($id);
        }

        if ($tasks) {
            $this->response([
                'status' => true,
                'data' => $tasks
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
            if ($this->tasks->deleteTasks($id) > 0) {
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
            'category_id' => $this->post('category_id'),
            'title' => $this->post('title'),
            'description' => $this->post('description'),
            'start_date' => $this->post('start_date'),
            'finish_date' => $this->post('finish_date'),
            'status' => $this->post('status'),
        ];

        if ($this->tasks->createTasks($data) > 0) {
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
            'category_id' => $this->put('category_id'),
            'title' => $this->put('title'),
            'description' => $this->put('description'),
            'start_date' => $this->put('start_date'),
            'finish_date' => $this->put('finish_date'),
            'status' => $this->put('status'),
        ];

        if (is_null($id)) {
            $this->response([
                'status' => false,
                'message' => 'please provide an id'
            ], RestController::HTTP_BAD_REQUEST);
        } else {
            if ($this->tasks->updateTasks($data, $id) > 0) {
                // ok
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'tasks has been updated'
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
