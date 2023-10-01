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
            'name' => 'Name',
            'phone' => 'Phone No',
            'email' => 'Email Id',
            'property_id' => 'Property Id',
            'booked_at' => 'Booking Date'
        ];

        return $ordering;
    }
}
?>
