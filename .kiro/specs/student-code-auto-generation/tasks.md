# Tasks: Student Code Auto-Generation

## Phase 1: Backend Service Implementation

### 1.1 Create StudentCodeGenerator Service
- [x] Create `app/Services/StudentCodeGenerator.php` file
- [x] Implement `generate(int $admissionId): string` method
- [x] Implement `getCurrentAcademicYear(): int` helper method
- [x] Implement `getNextSequenceNumber(int $year): int` helper method
- [x] Implement `formatCode(int $year, int $sequence): string` helper method
- [x] Add PHPDoc comments with formal specifications (preconditions, postconditions)
- [x] Add input validation and assertions

**Acceptance Criteria:**
- Service class follows single responsibility principle
- All methods have clear input/output contracts
- Code follows PSR-12 standards
- Formal specifications are documented

### 1.2 Create API Controller
- [x] Create `app/Http/Controllers/Api/AdmissionsApiController.php` file
- [x] Implement `generateCode(int $admissionId): JsonResponse` method
- [x] Add validation for admission existence
- [x] Add validation for admission status (must be pending)
- [x] Return JSON response with code, year, sequence, success fields
- [x] Handle errors with appropriate HTTP status codes (404, 400)
- [x] Add PHPDoc comments

**Acceptance Criteria:**
- Controller returns proper JSON responses
- Error handling is comprehensive
- HTTP status codes are correct
- Response structure matches API specification

### 1.3 Add API Route
- [x] Open `routes/api.php` file
- [x] Add route: `GET /api/admissions/{admission}/generate-code`
- [x] Apply `auth` middleware
- [x] Apply `IsAdmin` middleware (or equivalent admin check)
- [x] Apply rate limiting: `throttle:60,1`

**Acceptance Criteria:**
- Route is protected by authentication
- Route requires admin role
- Rate limiting is configured
- Route uses route model binding for admission


### 1.4 Enhance AdmissionsController
- [x] Open `app/Http/Controllers/Back/AdmissionsController.php`
- [ ] Update validation rules in `approve()` method to include format check: `regex:/^\d{8}$/`
- [ ] Ensure uniqueness validation is working correctly
- [ ] Verify error messages are user-friendly
- [ ] Ensure existing functionality is not broken

**Acceptance Criteria:**
- Validation includes format check (8 digits)
- Validation includes uniqueness check
- Error messages are clear and actionable
- Existing approval workflow continues to work

## Phase 2: Database Optimization

### 2.1 Create Database Migration
- [ ] Run: `php artisan make:migration add_index_to_admissions_table`
- [ ] In migration `up()` method, add index: `$table->index(['status', 'student_code'])`
- [ ] In migration `down()` method, drop index: `$table->dropIndex(['status', 'student_code'])`
- [ ] Test migration on local database
- [ ] Verify index improves query performance

**Acceptance Criteria:**
- Migration creates composite index on (status, student_code)
- Migration is reversible
- Migration runs without errors
- Query performance is improved

### 2.2 Run Migration
- [ ] Run: `php artisan migrate`
- [ ] Verify migration completed successfully
- [ ] Check database to confirm index exists
- [ ] Test rollback: `php artisan migrate:rollback`
- [ ] Re-run migration: `php artisan migrate`

**Acceptance Criteria:**
- Migration executes successfully
- Index is created in database
- Rollback works correctly
- No data loss occurs

## Phase 3: Frontend Enhancement

### 3.1 Update Approval Modal JavaScript
- [ ] Open `resources/views/admin/admissions/show.blade.php`
- [ ] Modify `showApproveModal()` function to be async
- [ ] Add AJAX call to `/api/admissions/{id}/generate-code` endpoint
- [ ] Add loading state: set input value to "Loading..." and disable field
- [ ] On success: populate input with generated code and enable field
- [ ] On error: clear input, enable field, show alert with error message
- [ ] Test with browser developer tools

**Acceptance Criteria:**
- AJAX request is triggered when modal opens
- Loading state is displayed during fetch
- Generated code is pre-filled on success
- Error handling displays user-friendly message
- Input field is enabled after load (not disabled)


### 3.2 Update Modal HTML (if needed)
- [ ] Review modal HTML structure in `show.blade.php`
- [ ] Ensure student_code input has proper name attribute
- [ ] Ensure input is NOT disabled by default
- [ ] Add placeholder text if helpful (e.g., "e.g., 20260001")
- [ ] Verify form submission still works correctly

**Acceptance Criteria:**
- Input field has correct name attribute
- Input field is editable by admin
- Placeholder text is helpful
- Form submission works as expected

### 3.3 Test Frontend Functionality
- [ ] Test modal opens correctly
- [ ] Test AJAX request is sent
- [ ] Test loading state appears
- [ ] Test code is pre-filled
- [ ] Test manual editing works
- [ ] Test form submission with auto-generated code
- [ ] Test form submission with manually edited code
- [ ] Test error handling (disconnect network, test 404, test 400)

**Acceptance Criteria:**
- All user interactions work smoothly
- Loading states provide feedback
- Errors are handled gracefully
- Manual editing is possible

## Phase 4: Email Enhancement

### 4.1 Update AdmissionAccepted Mailable
- [ ] Open `app/Mail/AdmissionAccepted.php`
- [ ] Verify student_code is accessible in mailable
- [ ] Open corresponding email view template
- [ ] Add student code display in email body
- [ ] Style the code prominently (bold, larger font, or highlighted)
- [ ] Test email rendering with sample data

**Acceptance Criteria:**
- Student code is displayed in email
- Code is prominent and easy to read
- Email design is consistent with existing style
- Email includes all necessary information

### 4.2 Test Email Sending
- [ ] Configure mail testing (use Mailtrap or log driver)
- [ ] Approve a test admission
- [ ] Verify email is sent
- [ ] Verify email contains student code
- [ ] Verify email formatting is correct
- [ ] Test email failure scenario (ensure approval still succeeds)

**Acceptance Criteria:**
- Email is sent successfully
- Email contains correct student code
- Email is well-formatted
- Approval succeeds even if email fails


## Phase 5: Testing

### 5.1 Write Unit Tests for StudentCodeGenerator
- [ ] Create `tests/Unit/Services/StudentCodeGeneratorTest.php`
- [ ] Test `generate()` with zero existing students (should return YYYY0001)
- [ ] Test `generate()` with 5 existing students (should return YYYY0006)
- [ ] Test `getCurrentAcademicYear()` returns current year
- [ ] Test `getNextSequenceNumber()` counts only accepted students
- [ ] Test `getNextSequenceNumber()` counts only matching year
- [ ] Test `formatCode()` with sequence 1 returns "0001"
- [ ] Test `formatCode()` with sequence 42 returns "0042"
- [ ] Test `formatCode()` with sequence 9999 returns "9999"
- [ ] Test `formatCode()` with year 2026 includes "2026" prefix
- [ ] Run tests: `php artisan test --filter=StudentCodeGeneratorTest`

**Acceptance Criteria:**
- All unit tests pass
- Code coverage is 90%+
- Tests are isolated and fast
- Tests use database factories for test data

### 5.2 Write Unit Tests for AdmissionsApiController
- [ ] Create `tests/Unit/Http/Controllers/Api/AdmissionsApiControllerTest.php`
- [ ] Test successful code generation returns 200 status
- [ ] Test response JSON structure is correct
- [ ] Test non-existent admission returns 404
- [ ] Test non-pending admission returns 400
- [ ] Test authentication is required
- [ ] Test admin role is required
- [ ] Run tests: `php artisan test --filter=AdmissionsApiControllerTest`

**Acceptance Criteria:**
- All unit tests pass
- HTTP status codes are verified
- JSON response structure is verified
- Authentication and authorization are tested

### 5.3 Write Integration Tests
- [ ] Create `tests/Feature/StudentCodeAutoGenerationTest.php`
- [ ] Test complete approval workflow (API → approval → email)
- [ ] Test concurrent approvals generate unique codes
- [ ] Test manual code override workflow
- [ ] Test duplicate code validation
- [ ] Test approval with invalid code format
- [ ] Test approval updates all required fields (status, reviewed_at, reviewed_by)
- [ ] Test email is sent with correct code
- [ ] Run tests: `php artisan test --filter=StudentCodeAutoGenerationTest`

**Acceptance Criteria:**
- All integration tests pass
- End-to-end workflows are verified
- Database state is verified after operations
- Email sending is verified


### 5.4 Write Property-Based Tests
- [ ] Add property test to `StudentCodeAutoGenerationTest.php`
- [ ] Test format invariant: all generated codes match /^\d{8}$/
- [ ] Test uniqueness property: generate 50 codes, verify all unique
- [ ] Test sequential consistency: verify sequences increment correctly
- [ ] Test year boundary: verify year portion matches current year
- [ ] Run property tests with multiple iterations
- [ ] Run tests: `php artisan test --filter=StudentCodeAutoGenerationTest`

**Acceptance Criteria:**
- Property tests pass with 50-100 iterations
- Format invariant is verified
- Uniqueness is verified
- Sequential consistency is verified

### 5.5 Run Full Test Suite
- [ ] Run all tests: `php artisan test`
- [ ] Verify all tests pass
- [ ] Check code coverage report
- [ ] Fix any failing tests
- [ ] Ensure no regressions in existing tests

**Acceptance Criteria:**
- All tests pass (100% success rate)
- Code coverage is 90%+ for new code
- No regressions in existing functionality
- Test suite runs in under 30 seconds

## Phase 6: Manual Testing

### 6.1 Test Happy Path
- [ ] Log in as admin user
- [ ] Navigate to pending admissions
- [ ] Click on an admission to review
- [ ] Click "Approve Application" button
- [ ] Verify modal opens with loading state
- [ ] Verify code is auto-generated and pre-filled
- [ ] Verify code format is YYYYNNNN
- [ ] Click "Approve & Send Email" button
- [ ] Verify success message is displayed
- [ ] Verify admission status is "accepted"
- [ ] Verify student code is displayed on admission detail page
- [ ] Check email (Mailtrap or logs) for acceptance email
- [ ] Verify email contains student code

**Acceptance Criteria:**
- Complete workflow works smoothly
- Code is generated correctly
- Email is sent with code
- UI provides clear feedback


### 6.2 Test Manual Override
- [ ] Open approval modal for a pending admission
- [ ] Wait for code to be auto-generated
- [ ] Manually edit the code (e.g., change last digit)
- [ ] Click "Approve & Send Email"
- [ ] Verify approval succeeds with edited code
- [ ] Verify edited code is saved in database
- [ ] Verify email contains edited code

**Acceptance Criteria:**
- Manual editing is possible
- Edited code is accepted if valid
- System saves edited code correctly

### 6.3 Test Duplicate Code Validation
- [ ] Approve first admission with code "20260001"
- [ ] Open approval modal for second admission
- [ ] Manually change auto-generated code to "20260001"
- [ ] Click "Approve & Send Email"
- [ ] Verify error message is displayed
- [ ] Verify error message says "code is already taken"
- [ ] Correct the code to a unique value
- [ ] Click "Approve & Send Email" again
- [ ] Verify approval succeeds

**Acceptance Criteria:**
- Duplicate code is rejected
- Error message is clear
- Admin can correct and retry

### 6.4 Test Error Scenarios
- [ ] Test with network disconnected (simulate API failure)
- [ ] Verify error message is displayed
- [ ] Verify input field is enabled for manual entry
- [ ] Test with non-existent admission ID (manually craft URL)
- [ ] Verify 404 error is handled
- [ ] Test with already-approved admission
- [ ] Verify approve button is hidden or disabled

**Acceptance Criteria:**
- All error scenarios are handled gracefully
- User receives clear feedback
- System remains functional

### 6.5 Test Sequential Code Generation
- [ ] Approve 5 admissions in sequence
- [ ] Verify codes are: YYYY0001, YYYY0002, YYYY0003, YYYY0004, YYYY0005
- [ ] Verify no gaps in sequence
- [ ] Verify all codes are unique

**Acceptance Criteria:**
- Codes are sequential
- No duplicate codes
- No gaps in sequence


### 6.6 Test Concurrent Approvals
- [ ] Open two browser windows as different admin users (or same admin)
- [ ] Open approval modal for two different admissions simultaneously
- [ ] Note the auto-generated codes in both windows
- [ ] Click approve in both windows quickly (within 1-2 seconds)
- [ ] Verify both approvals succeed
- [ ] Verify both codes are unique
- [ ] Verify no duplicate code error occurs

**Acceptance Criteria:**
- Concurrent approvals work correctly
- No race conditions create duplicate codes
- Both admissions are approved successfully

## Phase 7: Code Quality & Documentation

### 7.1 Code Review
- [ ] Review all new code for PSR-12 compliance
- [ ] Run Laravel Pint: `./vendor/bin/pint`
- [ ] Review PHPDoc comments for completeness
- [ ] Review formal specifications (preconditions, postconditions)
- [ ] Check for code duplication
- [ ] Check for proper error handling
- [ ] Check for security vulnerabilities

**Acceptance Criteria:**
- Code follows PSR-12 standards
- All public methods have PHPDoc comments
- No code duplication
- Error handling is comprehensive
- No security vulnerabilities

### 7.2 Write API Documentation
- [ ] Create API documentation file (e.g., `docs/api/student-code-generation.md`)
- [ ] Document endpoint URL and method
- [ ] Document authentication requirements
- [ ] Document request parameters
- [ ] Document response structure (success and error cases)
- [ ] Provide request/response examples
- [ ] Document rate limiting

**Acceptance Criteria:**
- API is fully documented
- Examples are clear and accurate
- Documentation is accessible to team

### 7.3 Write User Documentation
- [ ] Create or update admin user guide
- [ ] Document the auto-generation feature
- [ ] Explain code format (YYYYNNNN)
- [ ] Explain manual override capability
- [ ] Document error scenarios and resolutions
- [ ] Add screenshots if helpful

**Acceptance Criteria:**
- Feature is documented for admin users
- Documentation is clear and non-technical
- Common scenarios are covered


## Phase 8: Deployment Preparation

### 8.1 Prepare Deployment Checklist
- [ ] Create deployment checklist document
- [ ] List all files to be deployed
- [ ] List migration to be run
- [ ] List environment variables (if any)
- [ ] Document rollback procedure
- [ ] Document testing steps for production

**Acceptance Criteria:**
- Deployment checklist is complete
- Rollback procedure is documented
- All deployment steps are clear

### 8.2 Test on Staging Environment
- [ ] Deploy code to staging environment
- [ ] Run migration on staging database
- [ ] Test complete workflow on staging
- [ ] Test with production-like data volume
- [ ] Verify performance is acceptable
- [ ] Test rollback procedure

**Acceptance Criteria:**
- Feature works correctly on staging
- Performance is acceptable
- Rollback procedure works
- No issues found

### 8.3 Create Deployment Package
- [ ] Commit all code changes to version control
- [ ] Tag release version (e.g., v1.1.0)
- [ ] Create pull request with detailed description
- [ ] Request code review from team
- [ ] Address review comments
- [ ] Merge to main branch

**Acceptance Criteria:**
- All code is committed
- Release is tagged
- Code review is complete
- Changes are merged

## Phase 9: Production Deployment

### 9.1 Deploy to Production
- [ ] Schedule deployment window (low-traffic time)
- [ ] Backup production database
- [ ] Deploy code to production server
- [ ] Run migration: `php artisan migrate --force`
- [ ] Clear application cache: `php artisan cache:clear`
- [ ] Clear config cache: `php artisan config:clear`
- [ ] Clear route cache: `php artisan route:clear`
- [ ] Verify deployment was successful

**Acceptance Criteria:**
- Code is deployed successfully
- Migration runs without errors
- Application is functional
- No downtime occurs


### 9.2 Post-Deployment Testing
- [ ] Test approval workflow on production
- [ ] Verify code generation works
- [ ] Verify email sending works
- [ ] Check application logs for errors
- [ ] Monitor server performance
- [ ] Test with real admin user account

**Acceptance Criteria:**
- Feature works correctly in production
- No errors in logs
- Performance is acceptable
- Admin users can use the feature

### 9.3 Monitor and Verify
- [ ] Monitor application for 24 hours
- [ ] Check error logs daily
- [ ] Verify no duplicate codes are created
- [ ] Verify emails are being sent
- [ ] Collect feedback from admin users
- [ ] Address any issues immediately

**Acceptance Criteria:**
- No critical issues found
- Feature is stable
- Admin users are satisfied
- Monitoring shows healthy metrics

## Phase 10: Post-Deployment

### 10.1 Gather Feedback
- [ ] Survey admin users about the feature
- [ ] Ask about ease of use
- [ ] Ask about any issues encountered
- [ ] Collect suggestions for improvement
- [ ] Document feedback

**Acceptance Criteria:**
- Feedback is collected from at least 3 admin users
- Feedback is documented
- Issues are prioritized

### 10.2 Create Follow-up Tasks
- [ ] Review feedback and identify improvements
- [ ] Create tasks for any bug fixes
- [ ] Create tasks for enhancement requests
- [ ] Prioritize follow-up work
- [ ] Schedule follow-up work in sprint planning

**Acceptance Criteria:**
- All feedback is reviewed
- Follow-up tasks are created
- Tasks are prioritized
- Work is scheduled

### 10.3 Update Documentation
- [ ] Update documentation based on feedback
- [ ] Add FAQ section if needed
- [ ] Update screenshots if UI changed
- [ ] Publish updated documentation
- [ ] Notify team of documentation updates

**Acceptance Criteria:**
- Documentation is updated
- FAQ addresses common questions
- Team is notified

## Summary

**Total Tasks**: 80+ tasks across 10 phases
**Estimated Effort**: 7-11 hours of development time
**Key Deliverables**:
- StudentCodeGenerator service class
- API endpoint for code generation
- Enhanced approval modal with AJAX
- Database migration for index
- Comprehensive test suite (unit, integration, property-based)
- Updated email template
- Complete documentation (API, user, deployment)

**Success Criteria**:
- All tests pass (100% success rate)
- Code coverage is 90%+ for new code
- Feature works smoothly in production
- Admin users can approve students with auto-generated codes
- Manual override capability works correctly
- No duplicate codes are created
- Emails are sent with student codes
