<?

class unico_Model extends CI_Model {

    // table name
    private $table = 'un_unico';

    function unico_Model() {
        parent::__construct();
    }

    // get number of unicos in database
    function count_all() {
        return $this->db->count_all($this->table);
    }

    // get unicos with paging
    function get_paged_list($limit = 10, $offset = 0) {
        $this->db->order_by('codigo', 'asc');
        return $this->db->get($this->table, $limit, $offset);
    }

    // get unico by id
    function get_by_id($id) {
        $this->db->where('codigo', $id);
        return $this->db->get($this->table);
    }

    // add new unico
    function save($unico) {
        $this->db->insert($this->table, $unico);
        return $this->db->insert_id();
    }

    // update unico by id
    function update($id, $unico) {
        $this->db->where('codigo', $id);
        $this->db->update($this->table, $unico);
    }

    // delete unico by id
    function delete($id) {
        $this->db->where('codigo', $id);
        $this->db->delete($this->table);
    }

}