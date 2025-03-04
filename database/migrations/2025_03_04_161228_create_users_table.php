<!-- process_registration.php -->
<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

require_once DIR . '/vendor/autoload.php'; // Adjust path as needed

// Basic error handling
try {
    // Get form data
    $data = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'password' => Hash::make($_POST['password']), // Hash the password
        'birthdate' => $_POST['birthdate'],
        'phone' => $_POST['phone'],
        'sex' => $_POST['sex'],
        'address' => $_POST['address'],
        'street' => $_POST['street'],
        'neighborhood' => $_POST['neighborhood'],
        'city' => $_POST['city'],
        'state' => $_POST['state'],
    ];

    
    // Create new user
    User::create($data);

    // Redirect on success
    header('Location: success.html');
    exit;

} catch (Exception $e) {
    // Handle errors (you might want to redirect to an error page)
    echo "Error: " . $e->getMessage();
    // For production, you'd want proper error handling and logging
}