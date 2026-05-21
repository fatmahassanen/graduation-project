# Bugfix Requirements Document

## Introduction

The News and Departments CRUD functionality is incomplete. Both `NewsController.php` and `DepartmentsController.php` contain empty stub methods, preventing administrators from managing News and Departments content through the admin dashboard. The `EventsController.php` serves as the reference implementation with complete CRUD operations, proper validation, and image handling using `storage/public`. This bugfix will replicate the EventsController pattern to News and Departments controllers to achieve 100% consistency across all three modules.

**Impact**: Administrators cannot create, read, update, or delete News or Departments records, blocking critical content management functionality.

## Bug Analysis

### Current Behavior (Defect)

1.1 WHEN an administrator attempts to view the News listing page THEN the system returns an empty response because `NewsController::index()` has no implementation

1.2 WHEN an administrator attempts to create a new News item THEN the system returns an empty response because `NewsController::create()` and `NewsController::store()` have no implementation

1.3 WHEN an administrator attempts to edit an existing News item THEN the system returns an empty response because `NewsController::edit()` and `NewsController::update()` have no implementation

1.4 WHEN an administrator attempts to delete a News item THEN the system returns an empty response because `NewsController::destroy()` has no implementation

1.5 WHEN an administrator attempts to view the Departments listing page THEN the system returns an empty response because `DepartmentsController::index()` has no implementation

1.6 WHEN an administrator attempts to create a new Department THEN the system returns an empty response because `DepartmentsController::create()` and `DepartmentsController::store()` have no implementation

1.7 WHEN an administrator attempts to edit an existing Department THEN the system returns an empty response because `DepartmentsController::edit()` and `DepartmentsController::update()` have no implementation

1.8 WHEN an administrator attempts to delete a Department THEN the system returns an empty response because `DepartmentsController::destroy()` has no implementation

1.9 WHEN News or Departments routes are accessed THEN the routes are not properly registered in the admin middleware group, causing routing issues

### Expected Behavior (Correct)

2.1 WHEN an administrator accesses the News listing page THEN the system SHALL display all News items ordered by latest first, matching the EventsController pattern

2.2 WHEN an administrator creates a new News item with valid data (title, slug, excerpt, content, image, published_at, is_featured, is_active) THEN the system SHALL validate the input, store the image in `storage/public/news`, create the News record, and redirect to the News index with a success message

2.3 WHEN an administrator edits an existing News item THEN the system SHALL display the edit form with current data, validate updates, handle optional image replacement (deleting old image if new one uploaded), update the record, and redirect to the News index with a success message

2.4 WHEN an administrator deletes a News item THEN the system SHALL delete the associated image from storage, delete the News record, and redirect to the News index with a success message

2.5 WHEN an administrator accesses the Departments listing page THEN the system SHALL display all Departments ordered by the `order` field, matching the EventsController pattern

2.6 WHEN an administrator creates a new Department with valid data (name, slug, description, image, icon, order, is_active) THEN the system SHALL validate the input, store the image in `storage/public/departments`, create the Department record, and redirect to the Departments index with a success message

2.7 WHEN an administrator edits an existing Department THEN the system SHALL display the edit form with current data, validate updates, handle optional image replacement (deleting old image if new one uploaded), update the record, and redirect to the Departments index with a success message

2.8 WHEN an administrator deletes a Department THEN the system SHALL delete the associated image from storage, delete the Department record, and redirect to the Departments index with a success message

2.9 WHEN News and Departments routes are configured THEN the system SHALL register resource routes within the admin middleware group with proper naming conventions (admin.news.*, admin.departments.*)

2.10 WHEN an administrator submits a News form with invalid data THEN the system SHALL return validation errors matching the News model schema (title required, slug unique, image format validation)

2.11 WHEN an administrator submits a Departments form with invalid data THEN the system SHALL return validation errors matching the Departments model schema (name required, slug unique, image format validation)

### Unchanged Behavior (Regression Prevention)

3.1 WHEN an administrator manages Events THEN the system SHALL CONTINUE TO function exactly as it does now with complete CRUD operations

3.2 WHEN EventsController methods are called THEN the system SHALL CONTINUE TO validate, store, update, and delete Events with image handling in `storage/public/events`

3.3 WHEN any existing routes outside the News and Departments modules are accessed THEN the system SHALL CONTINUE TO function without any changes

3.4 WHEN blade views for Events are rendered THEN the system SHALL CONTINUE TO display correctly without any modifications

3.5 WHEN the admin dashboard is accessed THEN the system SHALL CONTINUE TO display all navigation links and functionality for other modules

3.6 WHEN images are uploaded for Events THEN the system SHALL CONTINUE TO store them in `storage/public/events` and delete old images on update/delete operations
