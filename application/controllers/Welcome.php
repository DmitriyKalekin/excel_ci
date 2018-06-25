<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
        $this->load->model('message_model');

        $data["messages"] = $this->message_model->getMessages();
		$this->load->view('welcome_message', $data);
	}
}
