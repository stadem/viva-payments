<?php
use Stadem\VivaPayments\Services\AccessToken;


test('creates an access token from config defaultProvider', function () {

  $accessToken = new AccessToken();
  $token = $accessToken->getAccessToken();

  expect($token)->not->toBeNull();

});


test('creates an access token for Viva DEMO environment', function () {

  $accessToken = new AccessToken(environment:'vivaDEMO');
  $token = $accessToken->getAccessToken();

  expect($token)->not->toBeNull();

});



test('status Code for Viva DEMO environment', function () {

  $accessToken = new AccessToken(environment:'vivaDEMO');
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


