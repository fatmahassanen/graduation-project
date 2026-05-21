<?php

/**
 * Manual test script for generateCode method
 * 
 * This script tests the AdmissionsApiController::generateCode() method
 * by creating test admissions and verifying the responses.
 */

require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Admission;
use App\Http\Controllers\Api\AdmissionsApiController;

echo "=== Testing AdmissionsApiController::generateCode() ===\n\n";

// Clean up any existing test data
echo "Cleaning up test data...\n";
Admission::where('email', 'LIKE', 'test%@example.com')->delete();

// Test 1: Create a pending admission and generate code
echo "\nTest 1: Generate code for pending admission\n";
$admission1 = Admission::create([
    'user_id' => 1,
    'first_name' => 'Test',
    'second_name' => 'Student',
    'third_name' => 'One',
    'fourth_name' => 'Last',
    'phone' => '01234567890',
    'email' => 'test1@example.com',
    'student_photo' => 'photo1.jpg',
    'birth_certificate' => 'cert1.jpg',
    'qualification_certificate' => 'qual1.jpg',
    'student_id_document' => 'id1.jpg',
    'parent_name' => 'Parent Name',
    'parent_phone' => '01234567891',
    'parent_id_document' => 'parent_id1.jpg',
    'status' => 'pending',
]);

$controller = new AdmissionsApiController();
$response1 = $controller->generateCode($admission1->id);
$data1 = json_decode($response1->getContent(), true);

echo "Response Status: " . $response1->getStatusCode() . "\n";
echo "Response Data: " . json_encode($data1, JSON_PRETTY_PRINT) . "\n";

if ($response1->getStatusCode() === 200 && $data1['success'] === true) {
    echo "✓ Test 1 PASSED: Code generated successfully\n";
    echo "  Generated code: {$data1['code']}\n";
    echo "  Year: {$data1['year']}\n";
    echo "  Sequence: {$data1['sequence']}\n";
} else {
    echo "✗ Test 1 FAILED\n";
}

// Test 2: Try to generate code for non-existent admission
echo "\nTest 2: Generate code for non-existent admission (should return 404)\n";
$response2 = $controller->generateCode(99999);
$data2 = json_decode($response2->getContent(), true);

echo "Response Status: " . $response2->getStatusCode() . "\n";
echo "Response Data: " . json_encode($data2, JSON_PRETTY_PRINT) . "\n";

if ($response2->getStatusCode() === 404 && $data2['success'] === false) {
    echo "✓ Test 2 PASSED: Correctly returned 404 for non-existent admission\n";
} else {
    echo "✗ Test 2 FAILED\n";
}

// Test 3: Create an accepted admission and try to generate code
echo "\nTest 3: Generate code for accepted admission (should return 400)\n";
$admission3 = Admission::create([
    'user_id' => 1,
    'first_name' => 'Test',
    'second_name' => 'Student',
    'third_name' => 'Two',
    'fourth_name' => 'Last',
    'phone' => '01234567892',
    'email' => 'test2@example.com',
    'student_photo' => 'photo2.jpg',
    'birth_certificate' => 'cert2.jpg',
    'qualification_certificate' => 'qual2.jpg',
    'student_id_document' => 'id2.jpg',
    'parent_name' => 'Parent Name 2',
    'parent_phone' => '01234567893',
    'parent_id_document' => 'parent_id2.jpg',
    'status' => 'accepted',
    'student_code' => '20260001',
]);

$response3 = $controller->generateCode($admission3->id);
$data3 = json_decode($response3->getContent(), true);

echo "Response Status: " . $response3->getStatusCode() . "\n";
echo "Response Data: " . json_encode($data3, JSON_PRETTY_PRINT) . "\n";

if ($response3->getStatusCode() === 400 && $data3['success'] === false) {
    echo "✓ Test 3 PASSED: Correctly returned 400 for non-pending admission\n";
} else {
    echo "✗ Test 3 FAILED\n";
}

// Test 4: Verify code format
echo "\nTest 4: Verify code format (YYYYNNNN)\n";
if (isset($data1['code'])) {
    $code = $data1['code'];
    $isValidFormat = preg_match('/^\d{8}$/', $code);
    $year = (int)substr($code, 0, 4);
    $currentYear = (int)date('Y');
    
    echo "Code: {$code}\n";
    echo "Format valid (8 digits): " . ($isValidFormat ? "Yes" : "No") . "\n";
    echo "Year matches current year: " . ($year === $currentYear ? "Yes" : "No") . "\n";
    
    if ($isValidFormat && $year === $currentYear) {
        echo "✓ Test 4 PASSED: Code format is correct\n";
    } else {
        echo "✗ Test 4 FAILED\n";
    }
}

// Clean up test data
echo "\nCleaning up test data...\n";
Admission::where('email', 'LIKE', 'test%@example.com')->delete();

echo "\n=== All tests completed ===\n";
