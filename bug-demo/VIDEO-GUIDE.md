# Bug Fix Demonstration - Maintenance Task Relationship

## Bug summary

The `maintenance_tasks` table stores the parent request ID in a column named `request_id`. In the controlled bug, the model incorrectly refers to `maintenance_request_id`. Loading `$task->request` then returns `null`; in the real Start/Complete workflow this can lead to `Call to a member function update() on null`.

## Before recording

Open PowerShell in the project folder:

```powershell
cd C:\xampp\htdocs\hotel-maintenance-system
```

Confirm the fixed project starts in a passing state:

```powershell
php artisan test --filter=MaintenanceTaskRelationshipTest
```

## Suggested 2-3 minute video flow

### 1. Introduce the feature (15 seconds)

Say:

> I am testing the relationship between a maintenance task and its parent maintenance request. This relationship is required when staff start or complete a task because the system also updates the related request.

### 2. Activate the controlled bug (15 seconds)

```powershell
powershell -ExecutionPolicy Bypass -File .\bug-demo\activate-bug.ps1
```

Open `app/Models/MaintenanceTask.php` and show this incorrect line:

```php
return $this->belongsTo(MaintenanceRequest::class, 'maintenance_request_id');
```

### 3. Reproduce the error (25 seconds)

```powershell
php artisan test --filter=MaintenanceTaskRelationshipTest
```

Point out the `Failed asserting that null is not null` message. The model searches for `maintenance_request_id`, while the real database column is `request_id`, so the parent request cannot be loaded.

### 4. Diagnose the root cause (30 seconds)

Show `database/migrations/2026_06_30_174819_create_maintenance_tasks_table.php`:

```php
$table->foreignId('request_id')
    ->constrained('maintenance_requests')
    ->onDelete('cascade');
```

Explain that the model convention and database schema do not match, so the foreign key must be declared explicitly.

### 5. Apply the fix (20 seconds)

```powershell
powershell -ExecutionPolicy Bypass -File .\bug-demo\fix-bug.ps1
```

Show the corrected line:

```php
return $this->belongsTo(MaintenanceRequest::class, 'request_id');
```

### 6. Verify the fix (25 seconds)

```powershell
php artisan test --filter=MaintenanceTaskRelationshipTest
php artisan test
```

Say:

> The targeted relationship test now passes. The full regression suite also confirms that the correction did not break other system functions.

## Important

Always finish the recording by running `fix-bug.ps1`. The submitted application must remain in the fixed state.
