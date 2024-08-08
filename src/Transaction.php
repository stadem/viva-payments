<?php


namespace VivaPayments;


class Transaction
{
    private float $amount;

    public function __construct(float $amount)
    {
        $this->amount = $amount;

    }

    public function process(){
           echo 'Price =  '.$this->amount; 

    }

}