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
            'id' => 'id',
            'BS_Type' => 'BS_Type',
            'BS_Sub_Type' => 'BS_Sub_Type',
            'BS_Sub_Type2' => 'BS_Sub_Type2',
            'BS_For' => 'BS_For',
            'Image1' => 'Image1',
            'Image2' => 'Image2',
            'Image3' => 'Image3',
            'Price' => 'Price',
            'Address' => 'Address',
            'Landmark' => 'Landmark',
            'State' => 'State',
            'City' => 'City',
            'Description' => 'Description',
            'Owner' => 'Owner',
            'Phone_No' => 'Phone_No',
            'Email_Id' => 'Email_Id',
            'is_Featured' => 'is_Featured',
            'is_Sold' => 'is_Sold',
            'created_at' => 'Created at'
        ];

        return $ordering;
    }
}
?>