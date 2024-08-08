<?php

namespace Stadem\VivaPayments\Enums;

enum RequestLang: string
{
    case Greek = 'el-GR';
    case Bulgarian = 'bg-BG';
    case Croatian = 'hr-HR';
    case Czech = 'cs-CZ';
    case Danish = 'da-DK';
    case Dutch_Netherlands  = 'nl-NL';
    case Dutch_Belgium  = 'nl-BE';
    case English_UK = 'en-GB';
    case English_US = 'en-US';
    case Finnish = 'fi-FI';
    case French_Belgium = 'fr-BE';
    case French  = 'fr-FR';
    case German = 'de-DE';
    case Hungarian = 'hu-HU';
    case Italian = 'it-IT';
    case Polish = 'pl-PL';
    case Portuguese = 'pt-PT';
    case Romanian = 'ro-RO';
    case Russian = 'ru-RU';
    case Spanish = 'es-ES';
    case Swedish = 'sv-SE';


    public static function fromName(string $name): string
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
     * Enums\RequestLang::fromValue('el-GR');
    */
    
    public static function fromValue(string $value): string
    {
        foreach (self::cases() as $status) {
            if( $value === $status->value ){
                return $status->name;
            }
        }
        throw new \ValueError("$value is not a valid backing value for enum " . self::class );
    }

}