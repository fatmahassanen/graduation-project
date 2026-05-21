# Bugfix Requirements Document

## Introduction

This bugfix addresses an issue where HTML code is being displayed as plain text on the External Protocols admin page when no protocols exist. The empty state component receives an HTML string through the `:action` prop, but the component uses `{{ $action }}` which escapes HTML entities, causing the button markup to appear as visible text instead of rendering as an interactive button.

## Bug Analysis

### Current Behavior (Defect)

1.1 WHEN the External Protocols admin page has no protocols AND the empty-state component receives HTML through the `:action` prop THEN the system displays the raw HTML string as escaped plain text on the page

1.2 WHEN the empty-state component renders the `$action` variable using `{{ $action }}` THEN the system escapes HTML entities, preventing proper rendering of HTML elements

### Expected Behavior (Correct)

2.1 WHEN the External Protocols admin page has no protocols AND the empty-state component receives HTML through the `:action` prop THEN the system SHALL render the HTML as an interactive button element

2.2 WHEN the empty-state component renders the `$action` variable THEN the system SHALL output unescaped HTML to allow proper rendering of HTML elements

### Unchanged Behavior (Regression Prevention)

3.1 WHEN the empty-state component is used without an action parameter THEN the system SHALL CONTINUE TO display the empty state without any action button

3.2 WHEN the empty-state component displays the icon, title, and description THEN the system SHALL CONTINUE TO render these elements correctly with proper styling

3.3 WHEN the External Protocols admin page has existing protocols THEN the system SHALL CONTINUE TO display the protocols table without showing the empty state

3.4 WHEN other admin pages use the empty-state component THEN the system SHALL CONTINUE TO function correctly with the updated component
