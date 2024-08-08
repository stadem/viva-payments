<?php
// https://github.com/sebdesign/laravel-viva-payments/blob/main/src/Enums/Environment.php
namespace Stadem\VivaPayments\Enums;

enum Environment: string
{
    case Production = 'production';
    case Demo = 'demo';
}