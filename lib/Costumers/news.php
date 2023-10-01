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
            'id' => 'ID',
            'title' => 'News Title',
            'content' => 'News Content',
            'content_region_state' => 'Target State Audience',
            'content_region_city' => 'Target City Audience',
            'created_at' => 'News Release Date'
        ];

        return $ordering;
    }
}
?>
