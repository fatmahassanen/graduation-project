<?php

use App\Models\Admission;
use App\Models\User;
use App\Http\Controllers\Api\AdmissionsApiController;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('generates code successfully for pending admission', function () {
    // Create a user and pending admission
    $user = User::factory()->create();
    $admission = Admission::factory()->create([
        'user_id' => $user->id,
        'status' => 'pending',
    ]);

    // Call the controller method directly
    $controller = new AdmissionsApiController();
    $response = $controller->generateCode($admission->id);

    // Assert response is successful
    expect($response->getStatusCode())->toBe(200);
    
    $data = json_decode($response->getContent(), true);
    expect($data['success'])->toBeTrue();
    expect($data)->toHaveKeys(['success', 'code', 'year', 'sequence']);

    // Verify code format
    $code = $data['code'];
    expect($code)->toMatch('/^\d{8}$/');
    expect($data['year'])->toBe((int)date('Y'));
    expect($data['sequence'])->toBeGreaterThan(0);
});

test('returns 404 for non-existent admission', function () {
    // Call with non-existent ID
    $controller = new AdmissionsApiController();
    $response = $controller->generateCode(99999);

    // Assert 404 response
    expect($response->getStatusCode())->toBe(404);
    
    $data = json_decode($response->getContent(), true);
    expect($data['success'])->toBeFalse();
    expect($data['message'])->toBe('Admission not found');
});

test('returns 400 for non-pending admission', function () {
    // Create a user and accepted admission
    $user = User::factory()->create();
    $admission = Admission::factory()->create([
        'user_id' => $user->id,
        'status' => 'accepted',
        'student_code' => '20260001',
    ]);

    // Call the controller method
    $controller = new AdmissionsApiController();
    $response = $controller->generateCode($admission->id);

    // Assert 400 response
    expect($response->getStatusCode())->toBe(400);
    
    $data = json_decode($response->getContent(), true);
    expect($data['success'])->toBeFalse();
    expect($data['message'])->toBe('Admission is not pending');
});

test('generates sequential codes for multiple admissions', function () {
    // Create a user and multiple pending admissions
    $user = User::factory()->create();
    $admission1 = Admission::factory()->create([
        'user_id' => $user->id,
        'status' => 'pending',
    ]);
    $admission2 = Admission::factory()->create([
        'user_id' => $user->id,
        'status' => 'pending',
    ]);

    // Generate codes
    $controller = new AdmissionsApiController();
    $response1 = $controller->generateCode($admission1->id);
    $response2 = $controller->generateCode($admission2->id);

    // Both should succeed
    expect($response1->getStatusCode())->toBe(200);
    expect($response2->getStatusCode())->toBe(200);

    // Codes should be different
    $data1 = json_decode($response1->getContent(), true);
    $data2 = json_decode($response2->getContent(), true);
    
    $code1 = $data1['code'];
    $code2 = $data2['code'];
    expect($code1)->not->toBe($code2);

    // Sequences should be sequential
    $seq1 = $data1['sequence'];
    $seq2 = $data2['sequence'];
    expect($seq2)->toBe($seq1 + 1);
});

test('code format is correct', function () {
    $user = User::factory()->create();
    $admission = Admission::factory()->create([
        'user_id' => $user->id,
        'status' => 'pending',
    ]);

    $controller = new AdmissionsApiController();
    $response = $controller->generateCode($admission->id);

    $data = json_decode($response->getContent(), true);
    $code = $data['code'];
    $year = $data['year'];
    $sequence = $data['sequence'];

    // Verify format
    expect($code)->toHaveLength(8);
    expect($code)->toMatch('/^\d{8}$/');
    
    // Verify year portion
    $yearPortion = substr($code, 0, 4);
    expect((int)$yearPortion)->toBe($year);
    expect($year)->toBe((int)date('Y'));
    
    // Verify sequence portion
    $sequencePortion = substr($code, 4, 4);
    expect((int)$sequencePortion)->toBe($sequence);
});
