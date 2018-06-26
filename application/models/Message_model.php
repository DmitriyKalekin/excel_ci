<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Message_model extends CI_Model
{
        public function __construct()
        {
              $this->load->database();
        }

        public function getMessages()
        {
            $q = "SELECT * FROM intents WHERE 1 ORDER BY msg LIMIT 0, 20";

            // $q = "SELECT * FROM intents WHERE id='{?id}';";
            // PDO::query($q, array("id"=>5));
            $res = $this->db->query($q);
            return $res->result();
        }


}
?>
