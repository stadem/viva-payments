<?php

// declare(strict_type = 1);

namespace App\VivaPayments;

// use App\VivaPayments\Enums\Status;

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




// class Transaction{

//     // private const STATUS_PAID = 'paid';
//     // private const STATUS_PENDING = 'pending';

//     private string $status = 'pending';

//    public function __construct()
//    {
//     $this->setStatus('pending');
//     // var_dump(self::STATUS_PAID);
    
//    }

//    public function setStatus(string $status):self
//    {

//     $this->status = $status;

//     return $status;


//    }




// }