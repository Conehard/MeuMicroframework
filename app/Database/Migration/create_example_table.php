<?php
namespace MeuMicroframework\Database\Migration;

use MeuMicroframework\Database\Migration;

class CreateExampleTable extends Migration{
    /*
     * Id: Auto Increment
     * Description: Product Description
     * Category: Foreign Key of category table
     * Dimensions: Product Dimensions
     * Code: Product Code
     * Reference: Product Reference
     * Stock: Product Stock
     * Price: Product Price
     * Active: Active or Inactive
     * */
    public function up(){
        $sql = "CREATE TABLE IF NOT EXISTS `example` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `description` varchar(255) NOT NULL,
            `dimensions` varchar(255) NOT NULL,
            `product_code` varchar(255) NOT NULL,
            `reference` varchar(255) NOT NULL,
            `stock` int(11) NOT NULL,
            `price` double NOT NULL,
            `active` tinyint(1) NOT NULL DEFAULT '1',
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        return $this->db->execute($sql);
    }
}
