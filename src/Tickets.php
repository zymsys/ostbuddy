<?php
namespace Buddy;

class Tickets
{
    private $db;
    private $table_prefix;

    private $baseSQL = "select ticket_id, ost_ticket.number, ost_form_entry_values.value
            from ost_ticket
              left join ost_form_entry on ost_form_entry.object_id = ticket_id
              left join ost_form_entry_values on ost_form_entry.id = entry_id
              where ost_form_entry_values.field_id = 5";

    private $filter = array();

    function __construct(Database $db, $table_prefix)
    {
        $this->db = $db;
        $this->table_prefix = $table_prefix;
    }

    public function get()
    {
        $sql = $this->baseSQL;
        if (count($this->filter) > 0) {
            $sql .= " AND (" . implode(") AND (", $this->filter) . ")";
        }
        $rows = $this->db->get($sql);
        return $rows;
    }

    public function getByName($ticketList)
    {
        $sql = $this->baseSQL . " and ost_ticket.number in (" .
            join(',', $ticketList) .
            ")";
        $rows = $this->db->get($sql);
        return $rows;
    }

    /**
     * @param $numbers array|string
     */
    public function filterByNumber($numbers)
    {
        if (!is_array($numbers)) {
            $numbers = array($numbers);
        }
        $this->filter[] = $this->table_prefix . "ticket.number in (" . join(',', $numbers) . ")";
    }
}