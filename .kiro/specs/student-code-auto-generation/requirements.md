# Requirements Document: Student Code Auto-Generation

## 1. Functional Requirements

### 1.1 Code Generation Logic

The system shall automatically generate an 8-digit student code following the format YYYYNNNN where:
- YYYY represents the current academic year (4 digits)
- NNNN represents a chronological sequence number within that year (4 digits, zero-padded)

**Acceptance Criteria:**
- Generated codes must be exactly 8 numeric digits
- First 4 digits must match the current calendar year
- Last 4 digits must be zero-padded (e.g., 0001, 0042, 0123)
- Sequence number must be calculated as: (count of accepted students for current year) + 1

### 1.2 API Endpoint for Code Generation

The system shall provide a RESTful API endpoint that generates student codes on demand.

**Acceptance Criteria:**
- Endpoint path: GET /api/admissions/{id}/generate-code
- Endpoint requires authentication and admin authorization
- Endpoint returns JSON response with generated code, year, and sequence number
- Endpoint returns 404 if admission not found
- Endpoint returns 400 if admission is not in pending status
- Response time must be under 200ms for typical database sizes

### 1.3 Modal Pre-fill Behavior

When an admin clicks the "Approve Application" button, the approval modal shall automatically fetch and display a generated student code.

**Acceptance Criteria:**
- Modal opens immediately when approve button is clicked
- AJAX request is triggered to fetch generated code
- Input field shows "Loading..." state during fetch
- Input field is disabled during fetch operation
- Generated code is pre-filled into student_code input field upon successful fetch
- Input field is enabled after code is loaded
- If fetch fails, input field is cleared and enabled for manual entry
- Error message is displayed if fetch fails


### 1.4 Manual Code Override

The system shall allow admins to manually edit the auto-generated student code before final approval.

**Acceptance Criteria:**
- Student code input field must NOT be disabled after code is loaded
- Admin can select and modify the pre-filled code
- Admin can clear the field and enter a completely different code
- Modified code is validated for format and uniqueness before approval
- System accepts manually entered code if it meets validation rules

### 1.5 Code Uniqueness Validation

The system shall enforce uniqueness of student codes across all admissions.

**Acceptance Criteria:**
- Database has UNIQUE constraint on student_code column
- Controller validates code uniqueness before saving
- If duplicate code detected, validation error is returned
- Error message: "Sorry, this code is already taken by another student. Please check the code and try again."
- Admin is redirected back to form with error message displayed
- Input field retains the invalid value for correction
- Admin can correct the code and resubmit

### 1.6 Approval Workflow Integration

The system shall integrate code generation into the existing admission approval workflow without breaking existing functionality.

**Acceptance Criteria:**
- Existing approve() method in AdmissionsController continues to work
- Student code is validated and saved during approval
- Admission status is updated to 'accepted'
- reviewed_at timestamp is set to current time
- reviewed_by field is set to authenticated admin's user ID
- AdmissionAccepted email is sent with the student code
- Admin is redirected to pending admissions list with success message

### 1.7 Email Notification Enhancement

The system shall include the assigned student code in the acceptance email sent to the student.

**Acceptance Criteria:**
- AdmissionAccepted mailable includes student_code in email content
- Email displays the code prominently
- Email format remains consistent with existing design
- Email is sent after successful approval
- If email fails, approval still succeeds (email failure is logged but not blocking)


## 2. Non-Functional Requirements

### 2.1 Performance

The system shall generate and deliver student codes with acceptable response times.

**Acceptance Criteria:**
- Code generation algorithm executes in under 50ms
- API endpoint responds in under 200ms (including network)
- Database query for counting students completes in under 50ms for tables up to 100,000 records
- Modal displays generated code within 500ms of button click
- No noticeable delay in user interaction

### 2.2 Reliability

The system shall handle errors gracefully and maintain data integrity.

**Acceptance Criteria:**
- Database uniqueness constraint prevents duplicate codes at storage level
- Concurrent approvals by multiple admins do not create duplicate codes
- If API request fails, user can still manually enter code
- If email sending fails, approval still succeeds
- All errors are logged for debugging
- System recovers gracefully from transient failures

### 2.3 Security

The system shall protect code generation and approval operations from unauthorized access.

**Acceptance Criteria:**
- API endpoint requires authentication (auth middleware)
- API endpoint requires admin role (IsAdmin middleware)
- Unauthorized requests return 403 Forbidden
- Input validation prevents SQL injection
- CSRF protection is enabled for approval form
- Rate limiting prevents API abuse (60 requests per minute per IP)
- Audit trail records who approved each admission and when

### 2.4 Usability

The system shall provide an intuitive and efficient user experience for admins.

**Acceptance Criteria:**
- Code is automatically generated without admin intervention
- Admin can see the generated code before confirming approval
- Admin can easily edit the code if needed
- Loading states provide feedback during async operations
- Error messages are clear and actionable
- Workflow requires minimal clicks (open modal → review → confirm)


### 2.5 Maintainability

The system shall be designed for easy maintenance and future enhancements.

**Acceptance Criteria:**
- Code generation logic is encapsulated in a dedicated service class
- Service class has clear, single-responsibility methods
- Code follows Laravel conventions and best practices
- All public methods have formal specifications (preconditions, postconditions)
- Code is well-commented and self-documenting
- Unit tests provide 90%+ code coverage
- Integration tests cover end-to-end workflows

### 2.6 Scalability

The system shall handle growth in student admissions without performance degradation.

**Acceptance Criteria:**
- Database index on (status, student_code) supports efficient queries
- Code generation algorithm has O(1) time complexity (with indexed query)
- System supports up to 9,999 students per academic year
- Optional caching strategy available for high-concurrency scenarios
- No hardcoded limits that would require code changes for growth

## 3. Data Requirements

### 3.1 Database Schema

The admissions table shall store student codes with appropriate constraints.

**Acceptance Criteria:**
- student_code column exists (varchar(255), nullable)
- student_code column has UNIQUE constraint
- Database index exists on (status, student_code) for query optimization
- Existing columns (status, reviewed_at, reviewed_by) are utilized
- No breaking changes to existing schema

### 3.2 Data Validation

All student code data shall be validated before storage.

**Acceptance Criteria:**
- Code must match regex pattern: /^\d{8}$/
- Code must be unique across all admissions
- Code is required when status is 'accepted'
- Code can be null for pending or rejected admissions
- Validation errors provide clear feedback to admin


## 4. Interface Requirements

### 4.1 API Interface

The system shall provide a RESTful API for code generation.

**Acceptance Criteria:**
- Endpoint: GET /api/admissions/{admission}/generate-code
- Authentication: Required (admin role)
- Request parameters: admission ID in URL path
- Success response (200): `{"success": true, "code": "20260006", "year": 2026, "sequence": 6}`
- Not found response (404): `{"success": false, "message": "Admission not found"}`
- Invalid status response (400): `{"success": false, "message": "Admission is not pending"}`
- Content-Type: application/json

### 4.2 Frontend Interface

The approval modal shall be enhanced with auto-generation functionality.

**Acceptance Criteria:**
- Modal HTML structure remains compatible with existing design
- JavaScript function showApproveModal() is enhanced with AJAX call
- Student code input field supports loading state
- Student code input field is NOT disabled after code loads
- Error handling displays user-friendly messages
- No breaking changes to existing modal behavior

### 4.3 Service Interface

The StudentCodeGenerator service shall provide a clean, testable interface.

**Acceptance Criteria:**
- Public method: generate(int $admissionId): string
- Public method: getCurrentAcademicYear(): int
- Public method: getNextSequenceNumber(int $year): int
- Public method: formatCode(int $year, int $sequence): string
- All methods have clear input/output contracts
- All methods are unit testable without database dependencies (where possible)

## 5. Integration Requirements

### 5.1 Laravel Framework Integration

The feature shall integrate seamlessly with Laravel 13.5.0.

**Acceptance Criteria:**
- Uses Laravel routing conventions
- Uses Laravel controller structure
- Uses Eloquent ORM for database operations
- Uses Laravel validation system
- Uses Laravel mail system
- Follows Laravel service provider pattern (if needed)


### 5.2 Existing Codebase Integration

The feature shall work with existing admission system components.

**Acceptance Criteria:**
- AdmissionsController::approve() method is enhanced, not replaced
- Admission model remains compatible with existing code
- show.blade.php view is enhanced with minimal changes
- Existing validation rules are preserved
- Existing email notification system is reused
- No breaking changes to other parts of the application

### 5.3 Database Integration

The feature shall work with the existing MySQL database.

**Acceptance Criteria:**
- Uses existing admissions table
- Uses existing database connection configuration
- Migration adds index without data loss
- Compatible with existing database backup/restore procedures
- No changes to other database tables

## 6. Testing Requirements

### 6.1 Unit Testing

All service and controller methods shall have comprehensive unit tests.

**Acceptance Criteria:**
- Test coverage: 90%+ for StudentCodeGenerator service
- Test coverage: 90%+ for AdmissionsApiController
- Test coverage: 90%+ for enhanced AdmissionsController methods
- Tests use Pest framework (Laravel default)
- Tests are isolated and do not depend on external state
- Tests run in under 5 seconds total

### 6.2 Integration Testing

End-to-end workflows shall be tested with integration tests.

**Acceptance Criteria:**
- Test complete approval workflow (API call → approval → email)
- Test concurrent approval scenarios
- Test manual code override workflow
- Test error handling scenarios
- Tests use Laravel's testing utilities (factories, database transactions)
- Tests clean up after themselves

### 6.3 Property-Based Testing

Critical properties shall be verified with property-based tests.

**Acceptance Criteria:**
- Test format invariant (all codes match /^\d{8}$/)
- Test uniqueness property (no duplicate codes)
- Test sequential consistency (sequence numbers increment correctly)
- Tests generate random scenarios (50-100 iterations)
- Tests use Pest with custom property testing helpers


## 7. Deployment Requirements

### 7.1 Migration

Database changes shall be deployed via Laravel migration.

**Acceptance Criteria:**
- Migration creates index on (status, student_code)
- Migration is reversible (down method provided)
- Migration runs without errors on production database
- Migration does not lock table for extended period
- Migration is tested on staging environment first

### 7.2 Backward Compatibility

The feature shall not break existing functionality.

**Acceptance Criteria:**
- Existing pending admissions can still be approved
- Existing accepted admissions are not affected
- Existing rejection workflow continues to work
- Existing email notifications continue to work
- No changes required to other parts of the application

### 7.3 Rollback Plan

The feature shall be deployable with a clear rollback strategy.

**Acceptance Criteria:**
- Migration can be rolled back safely
- Code changes can be reverted without data loss
- Rollback procedure is documented
- Rollback can be executed in under 5 minutes
- No permanent data corruption if rollback is needed

## 8. Documentation Requirements

### 8.1 Code Documentation

All new code shall be properly documented.

**Acceptance Criteria:**
- All classes have PHPDoc comments
- All public methods have PHPDoc comments with @param and @return tags
- Complex algorithms have inline comments explaining logic
- Formal specifications (preconditions, postconditions) are documented
- Code follows PSR-12 coding standards

### 8.2 API Documentation

The API endpoint shall be documented for future reference.

**Acceptance Criteria:**
- Endpoint URL, method, and parameters are documented
- Request/response examples are provided
- Authentication requirements are documented
- Error responses are documented
- Documentation is accessible to development team


### 8.3 User Documentation

Admin users shall have access to documentation on the new feature.

**Acceptance Criteria:**
- Feature behavior is documented in admin guide
- Code format (YYYYNNNN) is explained
- Manual override capability is documented
- Error scenarios and resolutions are documented
- Documentation is clear and non-technical

## 9. Constraints

### 9.1 Technical Constraints

The feature shall operate within the following technical constraints:

**Acceptance Criteria:**
- Must use PHP 8.5
- Must use Laravel 13.5.0
- Must use MySQL database
- Must use existing authentication system
- Must use existing admin middleware
- Must not require additional external dependencies

### 9.2 Business Constraints

The feature shall operate within the following business constraints:

**Acceptance Criteria:**
- Maximum 9,999 students per academic year (4-digit sequence limit)
- Code format is fixed as YYYYNNNN (cannot be changed without migration)
- Year is based on calendar year, not academic year (e.g., 2026, not 2025-2026)
- Codes are permanent once assigned (no code reassignment)

### 9.3 Time Constraints

The feature shall be developed within reasonable timeframes:

**Acceptance Criteria:**
- Service class implementation: 2-3 hours
- API controller implementation: 1-2 hours
- Frontend enhancement: 1-2 hours
- Testing: 2-3 hours
- Documentation: 1 hour
- Total estimated effort: 7-11 hours

## 10. Assumptions

The following assumptions are made for this feature:

1. **Academic Year Definition**: The academic year is represented by the calendar year (e.g., 2026), not a range (e.g., 2025-2026)

2. **Student Volume**: The institution will not exceed 9,999 accepted students in a single calendar year

3. **Code Permanence**: Once a student code is assigned, it will never be changed or reassigned to another student

4. **Admin Training**: Admin users understand the code format and know how to manually override if needed

5. **Database Performance**: The admissions table will not grow beyond 100,000 records without additional optimization

6. **Network Reliability**: The AJAX request for code generation will succeed in most cases; manual entry is fallback

7. **Email Delivery**: Email sending may fail occasionally, but this should not block the approval process

8. **Concurrent Approvals**: Multiple admins may approve different students simultaneously, but race conditions are rare

9. **Browser Compatibility**: Admin users use modern browsers that support Fetch API and ES6 JavaScript

10. **Time Zone**: Server time zone is configured correctly for accurate year calculation
