<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

/**
 * @author          Moisés Herrera
 */
class Historiales extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['historiales_get']['limit'] = 500; // 500 requests per hour per user/key
    }

    public function historiales_get()
    {
        $this->load->model('Expedientes_model');
        //http://localhost/restserver/index.php/users/users/id/1
        // Users from a data store e.g. database
        $numero = $this->get('numero');
        $id_historial = $this->get('id');
        $exps = $this->Expedientes_model->buscarHistoriales($numero);


        // If the id parameter doesn't exist return all the users

        if ($id_historial === NULL)
        {
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($exps)
            {
                // Set the response and exit
                $this->response($exps, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No se encontraron expedientes'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }

        // Find and return a single record for a particular user.

        $id_historial = (int) $id_historial;

        // Validate the id.
        if ($id_historial <= 0)
        {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.

        $exp = NULL;

        if (!empty($exps))
        {
            foreach ($exps as $ex)
            {
                if ($ex->id_historial == $id_detalle_expediente)
                {
                    $exp = $ex;
                }
            }
        }

        if (!empty($exp))
        {
            $this->set_response($exp, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Expediente no pudo ser encontrado'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
}
