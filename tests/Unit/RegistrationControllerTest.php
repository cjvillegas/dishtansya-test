<?php

use Tests\TestCase;

class RegistrationControllerTest extends TestCase
{
    /**
     * Test a successful user registration
     */
    public function testSuccessfulRegistration()
    {
        $response = $this->json('POST', '/api/register', [
            'email' => 'johndoe@testcode.com',
            'password' => 'testcode'
        ]);

        $response->assertSuccessful();
        $response->assertStatus(201);
        $response->assertJson([
            'message' => 'User successfully registered'
        ]);
    }

    /**
     * Test a successful user registration
     */
    public function testFailedRegistrationDuplicateEmail()
    {
        /**
         * Create a new user
         */
        $this->json('POST', '/api/register', [
            'email' => 'jane@testcode.com',
            'password' => 'testcode'
        ]);

        /**
         * attempt to create new user with same email
         */
        $response = $this->json('POST', '/api/register', [
            'email' => 'jane@testcode.com',
            'password' => 'testcode'
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => 'Email already taken',
            'errors' => [
                'email' => [
                    'The email has already been taken.'
                ]
            ]
        ]);
    }

    /**
     * Test failed validation
     */
    public function testFailedValidation()
    {
        /**
         * attempt to make a request with invalid request body
         */
        $response = $this->json('POST', '/api/register', []);

        $response->assertStatus(400);
        $response->assertJson([
            'errors' => [
                'email' => [
                    'The email field is required.'
                ],
                'password' =>[
                    'The password field is required.'
                ]
            ]
        ]);
    }
}
