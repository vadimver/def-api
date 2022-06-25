<?php

//use App\Models\User;
use Illuminate\Http\Response;
use function Pest\Laravel\postJson;

it('should register a user', function () {
    $testName = 'Test name';
    $testNickname = 'Test nickname';
    $testEmail = 'test@gmail.com';
    $password = 'test_password';

    $user = postJson('api/register', [
        'name' => $testName,
        'nickname' => $testNickname,
        'email' => $testEmail,
        'password' => $password,
        'password_confirmation' => $password,
    ])->json('data');

    expect($user)
        ->attributes->name->toBe($testName)
        ->attributes->nickname->toBe($testNickname)
        ->attributes->email->toBe($testEmail);
});

it('should wrong register a user', function () {
    $testName = 'Test name';
    $testNickname = 'Test nickname';
    $testEmail = 'test@gmail.com';
    $password = 'test_password';

    $response = postJson('api/register', [
        'name' => $testName,
        'nickname' => $testNickname,
        'email' => $testEmail,
        'password' => $password,
        'password_confirmation' => $password,
    ]);

    $response->assertStatus(Response::HTTP_CREATED);
});
