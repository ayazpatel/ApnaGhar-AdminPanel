<?php
class Costumers
{
    /**
     *
     */
    public function __construct()
    {
    }

    /**
     *
     */
    public function __destruct()
    {
    }
    
    /**
     * Set friendly columns\' names to order tables\' entries
     */
    public function setOrderingValues()
    {
        $ordering = [
            'id' => 'Id',
            'order_id' => 'Order Id',
            'name' => 'Name',
            'phone' => 'Phone No',
            'email' => 'Email Id',
            'payment_status' => 'Payment Status',
            'payment_date' => 'Payment Date'
        ];

        return $ordering;
    }
}
?>
