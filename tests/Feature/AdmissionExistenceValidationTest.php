<?php

use App\Http\Controllers\Api\AdmissionsApiController;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/**
 * Test suite for verifying admission existence validation in AdmissionsApiController.
 * 
 * This test verifies that the generateCode method properly validates that the admission
 * exists before processing, returning a 404 error with an appropriate message when
 * the admission is not found.
 */

test('returns 404 when admission does not exist', function () {
    // Arrange: Use a non-existent admission ID
    $nonExistentAdmissionId = 99999;
    $controller = new AdmissionsApiController();

    // Act: Call generateCode with non-existent ID
    $response = $controller->generateCode($nonExistentAdmissionId);

    // Assert: Verify 404 status code
    expect($response->getStatusCode())->toBe(404);
    
    // Assert: Verify response structure
    $data = json_decode($response->getContent(), true);
    expect($data)->toHaveKey('success');
    expect($data)->toHaveKey('message');
    
    // Assert: Verify error details
    expect($data['success'])->toBeFalse();
    expect($data['message'])->toBe('Admission not found');
});

test('returns proper error message for non-existent admission', function () {
    // Arrange
    $controller = new AdmissionsApiController();

    // Act
    $response = $controller->generateCode(12345);

    // Assert: Verify the error message is user-friendly
    $data = json_decode($response->getContent(), true);
    expect($data['message'])
        ->toBe('Admission not found')
        ->and($data['message'])->toBeString()
        ->and($data['message'])->not->toBeEmpty();
});

test('validation happens before code generation', function () {
    // This test verifies that the admission existence check happens
    // before any code generation logic is executed
    
    // Arrange
    $controller = new AdmissionsApiController();
    
    // Act: Call with non-existent admission
    $response = $controller->generateCode(99999);
    
    // Assert: Should return 404 immediately without attempting code generation
    expect($response->getStatusCode())->toBe(404);
    
    // The fact that we get a 404 and not a 500 error proves that
    // the validation happens before the StudentCodeGenerator is called
});
