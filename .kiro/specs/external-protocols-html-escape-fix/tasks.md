# Implementation Plan

- [ ] 1. Write bug condition exploration test
  - **Property 1: Bug Condition** - HTML Action Escaping Bug
  - **CRITICAL**: This test MUST FAIL on unfixed code - failure confirms the bug exists
  - **DO NOT attempt to fix the test or the code when it fails**
  - **NOTE**: This test encodes the expected behavior - it will validate the fix when it passes after implementation
  - **GOAL**: Surface counterexamples that demonstrate the bug exists
  - **Scoped PBT Approach**: For deterministic bugs, scope the property to the concrete failing case(s) to ensure reproducibility
  - Test that when the empty-state component receives HTML markup through the `:action` prop (e.g., `<a href='/admin/external-protocols/create' class='inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors'><i class='fas fa-plus mr-2'></i>Add Protocol</a>`), the component displays the HTML as escaped plain text instead of rendering it as an interactive button
  - The test should verify that the output contains escaped HTML entities like `&lt;` and `&gt;` (Bug Condition: `input.action IS NOT NULL AND input.action CONTAINS HTML_MARKUP AND component_uses_escaped_output(input.action) AND rendered_output_shows_escaped_html_text`)
  - The test assertions should match the Expected Behavior: the HTML should render as interactive elements (buttons, links) that are clickable and properly styled, rather than displaying escaped HTML text
  - Run test on UNFIXED code
  - **EXPECTED OUTCOME**: Test FAILS (this is correct - it proves the bug exists)
  - Document counterexamples found to understand root cause (e.g., "empty-state component with HTML action prop displays `&lt;a href=...&gt;` instead of rendering clickable link")
  - Mark task complete when test is written, run, and failure is documented
  - _Requirements: 1.1, 1.2, 2.1, 2.2_

- [ ] 2. Write preservation property tests (BEFORE implementing fix)
  - **Property 2: Preservation** - Non-HTML Component Behavior
  - **IMPORTANT**: Follow observation-first methodology
  - Observe behavior on UNFIXED code for non-buggy inputs (cases where action prop is null or component displays icon, title, and description)
  - Write property-based tests capturing observed behavior patterns:
    - Test that empty-state component without action prop displays only icon, title, and description
    - Test that empty-state component with various icon classes renders icons correctly with proper styling
    - Test that empty-state component displays title text correctly
    - Test that empty-state component displays description text (when provided) correctly
    - Test that empty-state component handles null action prop without errors
  - Property-based testing generates many test cases for stronger guarantees
  - Run tests on UNFIXED code
  - **EXPECTED OUTCOME**: Tests PASS (this confirms baseline behavior to preserve)
  - Mark task complete when tests are written, run, and passing on unfixed code
  - _Requirements: 3.1, 3.2, 3.3, 3.4_

- [ ] 3. Fix for HTML escaping in empty-state component

  - [ ] 3.1 Implement the fix
    - Change the output directive in `resources/views/components/admin/empty-state.blade.php` from `{{ $action }}` to `{!! $action !!}` to allow unescaped HTML rendering
    - Preserve the `@if($action)` conditional logic to ensure the action div only renders when action is provided
    - Verify that the fix allows HTML markup to be rendered as interactive elements instead of escaped text
    - Ensure no security concerns since action content comes from trusted application Blade templates (not user input)
    - _Bug_Condition: `input.action IS NOT NULL AND input.action CONTAINS HTML_MARKUP AND component_uses_escaped_output(input.action) AND rendered_output_shows_escaped_html_text`_
    - _Expected_Behavior: For any input where the empty-state component receives HTML markup through the `:action` prop, the fixed component SHALL render the HTML as interactive elements (buttons, links) that are clickable and properly styled, rather than displaying escaped HTML text_
    - _Preservation: Empty-state component display of icon with proper styling, title rendering, description rendering (when provided), behavior when no action is provided (action is null), and all existing usages across admin pages must continue to work correctly_
    - _Requirements: 1.1, 1.2, 2.1, 2.2, 3.1, 3.2, 3.3, 3.4_

  - [ ] 3.2 Verify bug condition exploration test now passes
    - **Property 1: Expected Behavior** - HTML Action Rendering
    - **IMPORTANT**: Re-run the SAME test from task 1 - do NOT write a new test
    - The test from task 1 encodes the expected behavior
    - When this test passes, it confirms the expected behavior is satisfied
    - Run bug condition exploration test from step 1
    - **EXPECTED OUTCOME**: Test PASSES (confirms bug is fixed)
    - Verify that the empty-state component now renders HTML markup as interactive elements instead of escaped text
    - _Requirements: 2.1, 2.2_

  - [ ] 3.3 Verify preservation tests still pass
    - **Property 2: Preservation** - Non-HTML Component Behavior
    - **IMPORTANT**: Re-run the SAME tests from task 2 - do NOT write new tests
    - Run preservation property tests from step 2
    - **EXPECTED OUTCOME**: Tests PASS (confirms no regressions)
    - Confirm all tests still pass after fix (icon rendering, title display, description display, null action handling remain unchanged)

- [ ] 4. Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.
