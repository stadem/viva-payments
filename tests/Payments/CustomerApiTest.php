<?php

use Stadem\VivaPayments\Request\Customer;
use Stadem\VivaPayments\Enums\RequestLang;


it('retrieves the correct data from the customer', function () {
    $customer = new Customer(
        $email = 'example@test.com',
        $fullName = 'John Doe',
        $phone = '+306987654321',
        $countryCode = 'GR',
        $requestLang = RequestLang::Greek
    );

    expect($customer->toJson())->toBe('{"email":"example@test.com","fullName":"John Doe","phone":"+306987654321","countryCode":"GR","requestLang":"el-GR"}');

});


it('retrieves the correct data from the customer with from', function () {
    $requestLang = 'el-GR';
    $customer = new Customer(
        $email = 'example@test.com',
        $fullName = 'John Doe',
        $phone = '+306987654321',
        $countryCode = 'GR',
        $requestLang = RequestLang::from($requestLang),
    );

    expect($customer->toJson())->toBe('{"email":"example@test.com","fullName":"John Doe","phone":"+306987654321","countryCode":"GR","requestLang":"el-GR"}');

});


it('retrieves the correct data from the customer with Name parameter Greek ', function () {
    $requestLang = 'Greek';
    $customer = new Customer(
        $email = 'example@test.com',
        $fullName = 'John Doe',
        $phone = '+306987654321',
        $countryCode = 'GR',
        $requestLang = RequestLang::fromName($requestLang),
    );

    expect($customer->toJson())->toBe('{"email":"example@test.com","fullName":"John Doe","phone":"+306987654321","countryCode":"GR","requestLang":"el-GR"}');

});


it('retrieves the correct data from the customer with String parameter el-GR ', function () {

    $customer = new Customer(
        $email = 'example@test.com',
        $fullName = 'John Doe',
        $phone = '+306987654321',
        $countryCode = 'GR',
        $requestLang = 'el-GR',
    );

    expect($customer->toJson())->toBe('{"email":"example@test.com","fullName":"John Doe","phone":"+306987654321","countryCode":"GR","requestLang":"el-GR"}');

});

