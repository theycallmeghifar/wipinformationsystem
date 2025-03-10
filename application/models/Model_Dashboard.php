<?php defined('BASEPATH') or exit('No direct script access allowed');

  class Model_Dashboard extends CI_Model
  {
  
///////////////////////////////////////////////////////////////////////////////////////////////LEMARI

    public function getLemariMod()
    {
      $query = $this->db->query(
        "SELECT 
          idLemari, 
          deskripsiLemari, 
          ukuranLemari, 
          status, 
          createdBy, 
          (CASE WHEN createdDate = '0000-00-00 00:00:00' THEN '-' ELSE createdDate END) AS createdDate,
          modifiedBy, 
          (CASE WHEN modifiedDate = '0000-00-00 00:00:00' THEN '-' ELSE modifiedDate END) AS modifiedDate    
        FROM lemari");

      return $query->result();
    }

///////////////////////////////////////////////////////////////////////////////////////////////ITEM

    public function getItemMod($warehouse)
    {
      $sql = "
          SELECT
              itemCode, 
              (CASE WHEN itemCode = '' THEN '-' ELSE itemName END) AS itemName, 
              jumlahItem,
              netQuantity, 
              status, 
              createdBy, 
              (CASE WHEN createdDate = '0000-00-00 00:00:00' THEN '-' ELSE createdDate END) AS createdDate, 
              modifiedBy, 
              (CASE WHEN modifiedDate = '0000-00-00 00:00:00' THEN '-' ELSE modifiedDate END) AS modifiedDate
          FROM item 
          WHERE warehouse = ?
      ";

      // Menggunakan query binding untuk keamanan
      $query = $this->db->query($sql, array($warehouse));

      return $query->result();
    }

///////////////////////////////////////////////////////////////////////////////////////////////MAIN ITEM

    public function getMainItemMod()
    {
      $query = $this->db->query(
        "SELECT 
            id,
            mainItemCode,
            (case when mainItemCode = '' THEN '-' else mainItemName end) as mainItemName,  
            itemCode, 
            position, 
            status, 
            createdBy, 
            (case when createdDate = '0000-00-00 00:00:00' THEN '-' else createdDate end) as createdDate, 
            modifiedBy, 
            (case when modifiedDate = '0000-00-00 00:00:00' THEN '-' else modifiedDate end) as modifiedDate 
        from mainitem");

      return $query->result();
    }

///////////////////////////////////////////////////////////////////////////////////////////////RAK

    public function getRakMod()
    {
      $query = $this->db->query(
        "SELECT 
            idRak, 
            idLemari,
            deskripsiRak, 
            currentVolume, 
            maxVolume,
            status, 
            createdBy, 
            (case when createdDate = '0000-00-00 00:00:00' THEN '-' else createdDate end) as createdDate, 
            modifiedBy, 
            (case when modifiedDate = '0000-00-00 00:00:00' THEN '-' else modifiedDate end) as modifiedDate 
        from rak");

      return $query->result();
    }

///////////////////////////////////////////////////////////////////////////////////////////////BARANG

    public function getBarangMod()
    {
      $query = $this->db->query(
        "SELECT 
            b.idBarang, 
            b.idPalet,
            (case when b.itemCode = '' THEN '-' else b.itemCode end) as itemCode,
            i.jumlahItem,
            b.tanggalMasuk,
            b.status, 
            b.createdBy, 
            (case when b.createdDate = '0000-00-00 00:00:00' THEN '-' else b.createdDate end) as createdDate, 
            b.modifiedBy, 
            (case when b.modifiedDate = '0000-00-00 00:00:00' THEN '-' else b.modifiedDate end) as modifiedDate 
        from barang as b
        
        INNER join item as i
        on b.itemCode = i.itemCode
        ");

      return $query->result();
    }

///////////////////////////////////////////////////////////////////////////////////////////////PALET

    public function getPaletMod()
    {
      $query = $this->db->query(
        "SELECT 
            p.idPalet,
            p.idRak,
            p.deskripsiPalet,
            p.maxBarang,
            i.jumlahItem,
            p.status,
            p.ipAddress,
            p.gpio1,
            p.gpio2,
            p.gpio3,  
            p.createdBy, 
            (case when p.createdDate = '0000-00-00 00:00:00' THEN '-' else p.createdDate end) as createdDate, 
            p.modifiedBy, 
            (case when p.modifiedDate = '0000-00-00 00:00:00' THEN '-' else p.modifiedDate end) as modifiedDate 
        from palet as p
        
        LEFT JOIN barang as b ON p.idPalet = b.idPalet
        LEFT JOIN item as i ON b.itemCode = i.itemCode
        
        ");

      return $query->result();
    }

  }
?>