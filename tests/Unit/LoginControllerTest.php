<?php

use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    /**
     * Test a successful user registration
     */
    public function testSuccessfulLogin()
    {
        // register new user
        $this->json('POST', '/api/register', [
            'email' => 'holly@molly.com',
            'password' => 'hollymolly'
        ]);

        $response = $this->json('POST', '/api/login', [
            'email' => 'holly@molly.com',
            'password' => 'hollymolly'
        ]);

        $response->assertSuccessful();
        $response->assertStatus(201);
    }

    /**
     * Test failed login
     */
    public function testFailedLogin()
    {
        // register new user
        $this->json('POST', '/api/register', [
            'email' => 'holly@cow.com',
            'password' => 'hollymolly'
        ]);

        /**
         * attempt to login with invalid cred
         */
        $response = $this->json('POST', '/api/login', [
            'email' => 'holly@cow.com',
            'password' => 'hollycowcamolly:)'
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Invalid credentials',
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
        $response = $this->json('POST', '/api/login', []);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The given data was invalid.',
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
