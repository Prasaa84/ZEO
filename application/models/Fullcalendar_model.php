<?php
// all events are in the year_plan_tbl
class Fullcalendar_model extends CI_Model
{
	function fetch_all_event(){
		$this->db->order_by('id');
        $this->db->where('is_deleted','0');
		return $this->db->get('year_plan_tbl');
	}

	function insert_event($data)
	{
		$this->db->insert('events', $data);
	}

	function update_event($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('events', $data);
	}

	function delete_event($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('events');
	}
}

?>