<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

    // num of records per page
    private $limit = 100;

    function __construct() {
        parent::__construct();

        // load library
        $this->load->library(array('table'));

        // load helper
        $this->load->helper('url');

        // load model
        $this->load->model('unico_Model', '', TRUE);
    }

    function index2() {
        $this->load->helper('url');
         $users = $this->db->get('un_unico')->result();
        $this->load->library('rest', array(
            'server' => 'http://localhost/sg/index.php/api/example/',
            'http_user' => 'admin',
            'http_pass' => '1234',
            'http_auth' => 'basic' // or 'digest'
        ));

        //

        //$user = $this->rest->get('http://localhost/sg/index.php/api/example/user/id/1/format/json', array('nome' => 'Gerton Martins'));
        echo "<pre>",print_r($users, 1), "</pre>";

        //die('a');
        $this->load->view('welcome_message');
    }

    function index($offset = 0) {
        // offset
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);

        // load data
        $unicos = $this->unico_Model->get_paged_list($this->limit, $offset)->result();

        // generate pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('person/index/');
        $config['total_rows'] = $this->unico_Model->count_all();
        $config['per_page'] = $this->limit;
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        // generate table data
        $this->load->library('table');
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('No', 'nome', 'sexo', 'Date of Birth (dd-mm-yyyy)', 'Actions');
        $i = 0 + $offset;
        foreach ($unicos as $unico) {
            $this->table->add_row(++$i, $unico->nome, strtoupper($unico->sexo) == 'M' ? 'Male' : 'Female', date('d-m-Y', strtotime($unico->dtnasc)), anchor('person/view/' . $unico->codigo, 'view', array('class' => 'view')) . ' ' .
                    anchor('person/update/' . $unico->codigo, 'update', array('class' => 'update')) . ' ' .
                    anchor('person/delete/' . $unico->codigo, 'delete', array('class' => 'delete', 'onclick' => "return confirm('Are you sure want to delete this person?')"))
            );
        }
        echo $data['table'] = $this->table->generate();

        die();
        // load view
        $this->load->view('personList', $data);
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */