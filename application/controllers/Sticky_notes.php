<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sticky_notes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('sticky_notes_model');
    }

    public function index() {
        $data['notes'] = $this->sticky_notes_model->get_all_notes();
        $this->load->view('sticky_notes/index', $data);
    }

    // public function create() {
    //     $data = array(
    //         'title' => $this->input->post('title'),
    //         'content' => $this->input->post('content')
    //     );
    //     $this->sticky_notes_model->create_note($data);
    //     redirect('sticky_notes');
    // }

//     public function edit($id) {
//         $data = array(
//             'title' => $this->input->post('title'),
//             'content' => $this->input->post('content')
//         );
//         $this->sticky_notes_model->update_note($id, $data);
//         redirect('sticky_notes');
//     }

//     public function delete($id) {
//         $this->sticky_notes_model->delete_note($id);
//         redirect('sticky_notes');
//     }

//     public function get_note_json($id) {
//         $note = $this->sticky_notes_model->get_note($id);
//         echo json_encode($note);
//     }
// }
