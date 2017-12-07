<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

/**
 * @author          Moisés Herrera
 */
class Compras extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['compras_get']['limit'] = 500; // 500 requests per hour per user/key
    }

    public function compras_get()
    {
        $this->load->model('Compras_model');
        //http://localhost/restserver/index.php/users/users/id/1
        // Users from a data store e.g. database
        $numero = $this->get('numero');
        $arvs = $this->Compras_model->buscarAntiretrovirales();


        // If the id parameter doesn't exist return all the users

        if ($numero == NULL)
        {
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($arvs)
            {
                // Set the response and exit
                $this->response($arvs, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No se encontraron compras de ARV'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }

        // Find and return a single record for a particular user.

        $numero = (int) $numero;

        // Validate the id.
        if ($numero <= 0)
        {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.

        $arv = NULL;

        if (!empty($arvs))
        {
            foreach ($arvs as $ar)
            {
                if ($ar->id_antiretrovirales == $numero)
                {
                    $arv = $ar;
                }
            }
        }

        if (!empty($arv))
        {
            $this->set_response($arv, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Compras de ARV no pudieron ser encontradas'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
}
