<?php
namespace Tests;

use App\Models\User;

class AuthTest {
    public static function run(): array {
        $results = [];

        // TC 1: Verify admin credentials
        $admin = User::verifyCredentials('admin@electro.vn', 'admin123');
        $results[] = [
            'name' => 'AuthTest: Authenticate admin with bcrypt password hash',
            'passed' => $admin !== null && $admin['role'] === 'admin' && !isset($admin['password_hash'])
        ];

        // TC 2: Reject wrong password
        $invalid = User::verifyCredentials('admin@electro.vn', 'wrongpassword');
        $results[] = [
            'name' => 'AuthTest: Reject invalid password',
            'passed' => $invalid === null
        ];

        // TC 3: Create customer account & verify
        $testEmail = 'test_' . uniqid() . '@electro.vn';
        $userId = User::create([
            'name' => 'Automated Test User',
            'email' => $testEmail,
            'password' => 'secret123',
            'phone' => '0988776655',
            'address' => '789 Test Boulevard',
            'role' => 'customer'
        ]);
        $verifiedUser = User::verifyCredentials($testEmail, 'secret123');
        $results[] = [
            'name' => 'AuthTest: Register new user and verify credentials',
            'passed' => $userId > 0 && $verifiedUser !== null && $verifiedUser['name'] === 'Automated Test User'
        ];

        return $results;
    }
}
