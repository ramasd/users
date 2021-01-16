<?php

namespace Tests\Feature;

use Illuminate\Support\Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    private $apiKey;
    private $invalidApiKey;
    private $users;
    private $usersFullNames;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->apiKey = 'secret';
        $this->invalidApiKey = 'invalidApiKey';

        for ($i = 0; $i <= 2; $i++) {
            $users['users'][$i]['first_name'] = Str::random(5 + $i);
            $users['users'][$i]['last_name'] = Str::random(5 + $i);
            $usersFullNames[$i]['full_name'] = $users['users'][$i]['first_name'] . ' ' . $users['users'][$i]['last_name'];
        }

        $this->users = $users;
        $this->usersFullNames = ['users' => $usersFullNames];
    }

    /**
     * @test
     * @return void
     */
    public function testStoreMethodWhenApiKeyNotProvided()
    {
        $response = $this->postJson('/api/users', $this->users);
        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => config('api.messages.invalid_api_key')]);
    }

    /**
     * @test
     * @return void
     */
    public function testStoreMethodWhenInvalidApiKeyProvided()
    {
        $response = $this->postJson('/api/users', $this->users, ['Authorization' => $this->invalidApiKey]);
        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => config('api.messages.invalid_api_key')]);
    }

    /**
     * @test
     * @return void
     */
    public function testUsersStoredCorrectly()
    {
        $response = $this->postJson('/api/users', $this->users, ['X-API-Key' => $this->apiKey]);

        $response->assertStatus(200);
        $response->assertJsonFragment($this->usersFullNames);
    }

    /**
     * @test
     * @return void
     */
    public function testStoreMethodWhenUserFirstNameNotProvided()
    {
        unset($this->users['users'][0]['first_name']);

        $response = $this->postJson('/api/users', $this->users, ['X-API-Key' => $this->apiKey]);

        $response->assertStatus(422);
        $response->assertJsonFragment(['message' => 'The given data was invalid.']);
        $response->assertJsonFragment([
            "errors"  => [
                "users.0.first_name" => ["The users.0.first_name field is required when users.0.last_name is present."]
            ]
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function testStoreMethodWhenProvidedEmptyUserFirstName()
    {
        unset($this->users['users'][0]['first_name']);
        $this->users['users'][0]['first_name'] = null;

        $response = $this->postJson('/api/users', $this->users, ['X-API-Key' => $this->apiKey]);

        $response->assertStatus(422);
        $response->assertJsonFragment(['message' => 'The given data was invalid.']);
        $response->assertJsonFragment([
            "errors"  => [
                "users.0.first_name" => ["The users.0.first_name field is required when users.0.last_name is present."]
            ]
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function testStoreMethodWhenProvidedUserFirstNameDataTypeIsNotString()
    {
        $this->users['users'][0]['first_name'] = [$this->users['users'][0]['first_name']];

        $response = $this->postJson('/api/users', $this->users, ['X-API-Key' => $this->apiKey]);

        $response->assertStatus(422);
        $response->assertJsonFragment(['message' => 'The given data was invalid.']);
        $response->assertJsonFragment([
            "errors"  => [
                "users.0.first_name" => ["The users.0.first_name must be a string."]
            ]
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function testStoreMethodWhenUserLastNameNotProvided()
    {
        unset($this->users['users'][0]['last_name']);

        $response = $this->postJson('/api/users', $this->users, ['X-API-Key' => $this->apiKey]);

        $response->assertStatus(422);
        $response->assertJsonFragment(['message' => 'The given data was invalid.']);
        $response->assertJsonFragment([
            "errors"  => [
                "users.0.last_name" => ["The users.0.last_name field is required when users.0.first_name is present."]
            ]
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function testStoreMethodWhenProvidedEmptyUserLastName()
    {
        unset($this->users['users'][0]['last_name']);
        $this->users['users'][0]['last_name'] = null;

        $response = $this->postJson('/api/users', $this->users, ['X-API-Key' => $this->apiKey]);

        $response->assertStatus(422);
        $response->assertJsonFragment(['message' => 'The given data was invalid.']);
        $response->assertJsonFragment([
            "errors"  => [
                "users.0.last_name" => ["The users.0.last_name field is required when users.0.first_name is present."]
            ]
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function testStoreMethodWhenProvidedUserLastNameDataTypeIsNotString()
    {
        $this->users['users'][0]['last_name'] = rand();

        $response = $this->postJson('/api/users', $this->users, ['X-API-Key' => $this->apiKey]);

        $response->assertStatus(422);
        $response->assertJsonFragment(['message' => 'The given data was invalid.']);
        $response->assertJsonFragment([
            "errors"  => [
                "users.0.last_name" => ["The users.0.last_name must be a string."]
            ]
        ]);
    }
}
