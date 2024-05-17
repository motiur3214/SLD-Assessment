<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UserMigrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if the 'users' table is created with correct columns.
     *
     * @return void
     */
    public function test_users_table_is_created_with_correct_columns()
    {
        $this->assertTrue(Schema::hasTable('users'));

        $columns = [
            'id',
            'prefixname',
            'firstname',
            'middlename',
            'lastname',
            'suffixname',
            'username',
            'email',
            'photo',
            'type',
            'email_verified_at',
            'password',
            'remember_token',
            'created_at',
            'updated_at',
            'deleted_at',
        ];

        foreach ($columns as $column) {
            $this->assertTrue(Schema::hasColumn('users', $column));
        }
    }

    /**
     * Test if the 'password_reset_tokens' table is created with correct columns.
     *
     * @return void
     */
    public function test_password_reset_tokens_table_is_created_with_correct_columns()
    {
        $this->assertTrue(Schema::hasTable('password_reset_tokens'));

        $columns = [
            'email',
            'token',
            'created_at',
        ];

        foreach ($columns as $column) {
            $this->assertTrue(Schema::hasColumn('password_reset_tokens', $column));
        }
    }

    /**
     * Test if the 'sessions' table is created with correct columns.
     *
     * @return void
     */
    public function test_sessions_table_is_created_with_correct_columns()
    {
        $this->assertTrue(Schema::hasTable('sessions'));

        $columns = [
            'id',
            'user_id',
            'ip_address',
            'user_agent',
            'payload',
            'last_activity',
        ];

        foreach ($columns as $column) {
            $this->assertTrue(Schema::hasColumn('sessions', $column));
        }
    }
}
