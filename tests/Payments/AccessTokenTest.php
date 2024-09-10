<?php
use Stadem\VivaPayments\Services\AccessToken;
use Stadem\VivaPayments\Config\Config;

test('creates an access token from config defaultProvider', function () {

  $config = new Config();
  $accessToken = new AccessToken($config);
  $token = $accessToken->getAccessToken();

  expect($token)->not->toBeNull();

});


test('creates an access token for Viva DEMO environment', function () {

  $config = new Config();
  $accessToken = new AccessToken($config);
  $token = $accessToken->getAccessToken();

  expect($token)->not->toBeNull();

});



test('status Code for Viva DEMO environment', function () {

  $config = new Config();
  $accessToken = new AccessToken($config);
  $token = $accessToken->getAccessToken();

  expect($accessToken->getStatusCode())->toBe(200);

});


// test('status Code for Viva Production environment', function () {

//   $accessToken = new AccessToken(environment:'vivaPROD');
//   $token = $accessToken->getAccessToken();
//   expect($accessToken->getStatusCode())->toBe(200);

// });


// test('creates an access token for Viva Production environment', function () {

//   $accessToken = new AccessToken(environment:'vivaPROD');
//   $token = $accessToken->getAccessToken();

//   expect($token)->not->toBeNull();

// });


