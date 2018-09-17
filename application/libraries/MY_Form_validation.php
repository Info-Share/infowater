<?php
class MY_Form_validation extends CI_Form_validation {
    
    public function __construct($rules = array())
    {
        parent::__construct($rules);
    }
    
    
    public function valid_date($date)
    {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }
}