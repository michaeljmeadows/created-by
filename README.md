# michaeljmeadows/created-by

A simple trait to add User relationships to Eloquent models to track creation, updating, and deletion.

## Installation 

You can install the package via composer:

```
composer require michaeljmeadows/created-by
```

## Usage

Assuming you already have a `users` table, add the following fields to the model migration:

```php
$table->foreignId('created_by')->nullable()->constrained('users');
$table->foreignId('updated_by')->nullable()->constrained('users');
$table->foreignId('deleted_by')->nullable()->constrained('users');
```
If you're using UUID or ULID ID fields, replace `foreignId` in the above with `foreignUuid` or `foreignUlid` fields accordingly

Once the fields are added to the model, you can simply include the trait in your model's definition:

```php
<?php

namespace App\Models;

use michaeljmeadows\Traits\CreatedBy;
use Illuminate\Database\Eloquent\Model;

class NewModel extends Model
{
    use CreatedBy;
```

BelongsTo relationships to the User will now be accessible on your model:

```php
$creator = $newModel->createdBy;
$updater = $newModel->updatedBy;
$deleter = $newModel->deletedBy;
```
