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

Don't forget to set the necessary fields when models are modified. We recommend a model observer, but Events are also a sensible alternative:

```php
<?php

namespace App\Observers;

use App\Models\NewModel;
use Illuminate\Support\Facades\Auth;

class NewModelObserver
{
    public function creating(NewModel $newModel): void
    {
        $newModel->created_by = Auth::id();
    }
	
    public function updating(NewModel $newModel): void
    {
        $newModel->updated_by = Auth::id();
    }
	
    public function deleting(NewModel $newModel): void
    {
        $newModel->deleted_by = Auth::id();
        $newModel->saveQuietly();
    }
```