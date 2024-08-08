<?php
namespace Stadem\VivaPayments\Enums;
enum OrderStatus : int
{
    case PENDING  = 0;
    case EXPIRED = 1;
    case CANCELED = 2;
    case PAID = 3;

    
    
    public function type(): int
    {
        return match($this) 
        {
            OrderStatus::PENDING => 'Pending',
            OrderStatus::EXPIRED => 'Expired', 
            OrderStatus::CANCELED => 'Canceled',   
            OrderStatus::PAID => 'Paid', 
        };
    }

    public static function fromValue(int $value): string
    {
        foreach (self::cases() as $status) {
            if( $value === $status->value ){
                return $status->name;
            }
        }
        throw new \ValueError("$value is not a valid backing value for enum " . self::class );
    }

}

// https://developer.viva.com/apis-for-payments/payment-api/#tag/Payments/paths/~1api~1orders~1{orderCode}/get
