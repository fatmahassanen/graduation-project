<?php

use App\Models\Admission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

beforeEach(function () {
    Mail::fake(); // Fake mail to avoid email sending during tests
    $this->admin = User::factory()->create();
    $this->admission = Admission::create([
        'national_id' => '12345678901234', // Add required national_id field
        'first_name' => 'John',
        'second_name' => 'Michael',
        'third_name' => 'David',
        'fourth_name' => 'Smith',
        'gender' => 'male',
        'religion' => 'Islam',
        'birth_date' => '2000-01-01',
        'birth_governorate' => 'Cairo',
        'current_governorate' => 'Cairo',
        'city_center' => 'Nasr City',
        'village_district' => 'District 1',
        'street_address' => '123 Main St',
        'phone' => '01234567890',
        'email' => 'john.smith@example.com',
        'parent_name' => 'Parent Name',
        'parent_phone' => '01987654321',
        'father_occupation' => 'Engineer',
        'status' => 'pending',
    ]);
});

test('approve validates student code format must be exactly 8 digits', function () {
    $response = $this->actingAs($this->admin)
        ->withoutMiddleware() // Bypass middleware for testing
        ->post(route('admin.admissions.approve', $this->admission), [
            'student_code' => '123', // Invalid: too short
        ]);

    $response->assertSessionHasErrors('student_code');
    expect(session('errors')->get('student_code')[0])
        ->toBe('The student code must be exactly 8 digits.');
});

test('approve validates student code format rejects non-numeric characters', function () {
    $response = $this->actingAs($this->admin)
        ->withoutMiddleware() // Bypass middleware for testing
        ->post(route('admin.admissions.approve', $this->admission), [
            'student_code' => '2026000A', // Invalid: contains letter
        ]);

    $response->assertSessionHasErrors('student_code');
    expect(session('errors')->get('student_code')[0])
        ->toBe('The student code must be exactly 8 digits.');
});

test('approve validates student code format rejects codes longer than 8 digits', function () {
    $response = $this->actingAs($this->admin)
        ->withoutMiddleware() // Bypass middleware for testing
        ->post(route('admin.admissions.approve', $this->admission), [
            'student_code' => '202600001', // Invalid: 9 digits
        ]);

    $response->assertSessionHasErrors('student_code');
    expect(session('errors')->get('student_code')[0])
        ->toBe('The student code must be exactly 8 digits.');
});

test('approve accepts valid 8-digit student code', function () {
    $response = $this->actingAs($this->admin)
        ->withoutMiddleware() // Bypass middleware for testing
        ->post(route('admin.admissions.approve', $this->admission), [
            'student_code' => '20260001', // Valid: exactly 8 digits
        ]);

    $response->assertRedirect(route('admin.admissions.pending'));
    $response->assertSessionHasNoErrors();
    
    $this->admission->refresh();
    expect($this->admission->status)->toBe('accepted');
    expect($this->admission->student_code)->toBe('20260001');
});

test('approve rejects duplicate student code', function () {
    // Create an existing admission with a student code
    Admission::create([
        'national_id' => '98765432109876', // Different national_id
        'first_name' => 'Jane',
        'second_name' => 'Mary',
        'third_name' => 'Ann',
        'fourth_name' => 'Doe',
        'gender' => 'female',
        'religion' => 'Christianity',
        'birth_date' => '2001-01-01',
        'birth_governorate' => 'Alexandria',
        'current_governorate' => 'Alexandria',
        'city_center' => 'Downtown',
        'village_district' => 'District 2',
        'street_address' => '456 Second St',
        'phone' => '01111111111',
        'email' => 'jane.doe@example.com',
        'parent_name' => 'Parent Name 2',
        'parent_phone' => '01222222222',
        'father_occupation' => 'Doctor',
        'status' => 'accepted',
        'student_code' => '20260001',
    ]);

    $response = $this->actingAs($this->admin)
        ->withoutMiddleware() // Bypass middleware for testing
        ->post(route('admin.admissions.approve', $this->admission), [
            'student_code' => '20260001', // Duplicate code
        ]);

    $response->assertSessionHasErrors('student_code');
    expect(session('errors')->get('student_code')[0])
        ->toBe('Sorry, this code is already taken by another student. Please check the code and try again.');
});

test('approve requires student code', function () {
    $response = $this->actingAs($this->admin)
        ->withoutMiddleware() // Bypass middleware for testing
        ->post(route('admin.admissions.approve', $this->admission), [
            // Missing student_code
        ]);

    $response->assertSessionHasErrors('student_code');
    expect(session('errors')->get('student_code')[0])
        ->toBe('The student code is required.');
});

test('approve updates all required fields', function () {
    $response = $this->actingAs($this->admin)
        ->withoutMiddleware() // Bypass middleware for testing
        ->post(route('admin.admissions.approve', $this->admission), [
            'student_code' => '20260001',
        ]);

    $this->admission->refresh();
    
    expect($this->admission->status)->toBe('accepted');
    expect($this->admission->student_code)->toBe('20260001');
    expect($this->admission->reviewed_at)->not->toBeNull();
    expect($this->admission->reviewed_by)->toBe($this->admin->id);
});
