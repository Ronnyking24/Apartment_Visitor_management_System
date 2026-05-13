<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

$user = User::where('email', 'admin@avms.com')->first();
echo "User found: " . ($user ? "YES" : "NO") . "\n";
echo "Email: " . $user->email . "\n";
echo "Role: " . $user->role . "\n";
echo "Hash::check test: " . (Hash::check('password', $user->password) ? "PASS" : "FAIL") . "\n";

// Test Auth::attempt directly
$result = Auth::attempt(['email' => 'admin@avms.com', 'password' => 'password']);
echo "Auth::attempt result: " . ($result ? "SUCCESS" : "FAILED") . "\n";

if (!$result) {
    echo "\nDEBUG: Checking each step...\n";
    $provider = Auth::createUserProvider('users');
    $retrieved = $provider->retrieveByCredentials(['email' => 'admin@avms.com', 'password' => 'password']);
    echo "User retrieved by provider: " . ($retrieved ? "YES - {$retrieved->name}" : "NO") . "\n";

    if ($retrieved) {
        $valid = $provider->validateCredentials($retrieved, ['email' => 'admin@avms.com', 'password' => 'password']);
        echo "Credentials valid: " . ($valid ? "YES" : "NO") . "\n";
    }
}
