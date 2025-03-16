<?php defined('BASEPATH') or exit('No direct script access allowed');

  class Model_OrderItem extends CI_Model
  {
    private $tableOrderItem = "order_item";

    public function getAllOrderItemMod()
    {
      $query = $this->db->query("
        SELECT oi.*, l.line, 
          CASE 
            WHEN oi.status = 0 THEN 'Belum Dikonfirmasi'
            WHEN oi.status = 1 THEN 'Dikonfirmasi'
            ELSE 'Ditolak'
          END AS statusText
        FROM " . $this->tableOrderItem . " oi
        JOIN location l ON l.locationId = oi.locationId
        ORDER BY oi.createdDate DESC, oi.status ASC"
      );

      return $query->result();
    }

    public function getOrderItemByIdMod($id)
    {
      $this->db->where('orderItemId', $id);
      return $this->db->get($this->tableOrderItem)->result();
    }

    public function saveOrderItemMod($data)
    {
      return $this->db->insert($this->tableOrderItem, $data);
    }

    public function updateBoxMod($data)
    {
      $where = array(
        'boxCode' => $data['boxCode'],
      );
      $this->db->where($where);
      return $this->db->update($this->tableOrderItem, $data);
    }

    public function getItemReadyOrderMod($itemCode)
    {
      $this->db->select('wbd.itemCode, i.itemName, SUM(wbd.quantity) as quantity');
      $this->db->from('wip_box_detail wbd');
      $this->db->join('wip_box wb', 'wbd.wipBoxId = wb.wipBoxId');
      $this->db->join('item i', 'wbd.itemCode = i.itemCode');
      $this->db->join('location l', 'l.locationId = wb.locationId');
      $this->db->where('wb.status', 1);
      if (!empty($itemCode)) {
        $this->db->where('wbd.itemCode', $itemCode);
      }
      $this->db->where('l.area', 'WIP');
      $this->db->group_by('wbd.itemCode');

      $query = $this->db->get();
      return $query->result_array();
    }

    public function getCavityReadyOrderMod($cavity)
    {
      $this->db->select('wb.cavity, SUM(wbd.quantity) as quantity');
      $this->db->from('wip_box wb');
      $this->db->join('wip_box_detail wbd', 'wb.wipBoxId = wbd.wipBoxId');
      $this->db->join('location l', 'l.locationId = wb.locationId');
      $this->db->where('wb.status', 1);
      if (!empty($cavity)) {
        $this->db->where('wb.cavity', $cavity);
      }
      $this->db->where('l.area', 'WIP');
      $this->db->group_by('wb.cavity');

      $query = $this->db->get();
      return $query->result_array();
    }

    public function getMatchingBoxItemMod($item, $quantity)
    {
      $sql = "
        WITH cte AS (
          SELECT 
            wb.wipBoxId,
              wb.boxCode,
              wbd.wipBoxDetailId, 
              wbd.itemCode, 
              wbd.cavity, 
              wbd.quantity, 
              SUM(wbd.quantity) OVER (PARTITION BY wbd.itemCode ORDER BY wipBoxDetailId) AS cumulative_quantity
            FROM wip_box_detail wbd
            JOIN wip_box wb ON wbd.wipBoxId = wb.wipBoxId
            WHERE wbd.itemCode = ? 
            OR wbd.cavity = ?
        )
        SELECT * FROM cte
        WHERE cumulative_quantity <= ?  
          OR (cumulative_quantity > ? AND cumulative_quantity - quantity < ?)
        ORDER BY wipBoxId;
      ";

      // Jalankan query dengan parameter binding untuk keamanan
      $query = $this->db->query($sql, [$item, $item, $quantity, $quantity, $quantity]);

      return $query->result_array();
    }
  }
?>