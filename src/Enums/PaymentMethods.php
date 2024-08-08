<?php

namespace Stadem\VivaPayments\Enums;

enum PaymentMethods: int
{
    case CreditCard = 0;
    case Cash = 3;
    case eBanking = 4;
    case VivaWallet = 8;
    case iDEAL = 10;
    case P24 = 11;
    case BLIK = 12;
    case PayU = 13;
    case giropay = 15;
    case Sofort = 16;
    case EPS = 17;
    case WeChatPay = 18;
    case BitPay = 19;
    case PayPal = 23;
    case Trustly = 24;
    case Klarna = 26;
    case BancontactQR = 27;
    case Payconiq = 28;
    case IRIS = 29;
    case PayByBank = 30;
    case MBWAY = 31;
    case MULTIBANCO = 32;
    case TbiBank = 34;
    case PayOnDelivery = 35;
    case MobilePayOnline = 36;
    case BANCOMATPay = 37;
    case Bluecode = 41;
    case Satispay = 43;
    case Swish = 221;

    /**
     * Return value as string 
     * Enums\PaymentMethods::fromName('Dias');
    */


public static function fromName(string $name): int
{
    foreach (self::cases() as $status) {
        if( $name === $status->name ){
            return $status->value;
        }
    }
    throw new \ValueError("$name is not a valid backing value for enum " . self::class );
}



    /**
     * Return value as string 
     * Enums\PaymentMethods::fromValue(15);
    */
    
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