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
            'user_id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email_id' => 'Email',
            'password' => 'password',
            'verification_token' => 'Verification Token',
            'is_verified' => 'Verification Status',
            'phone_no' => 'Phone',
            'wallet' => 'Wallet Balance',
            'prefered_state' => 'prefered_city',
            'created_at' => 'Created at'
        ];

        return $ordering;
    }
}
?>