# Laravel 5.2 demo on how to migrate legacy user accounts from another system to Laravel's inbuilt auth system

## 1) Use case

You're migrating an old system to Laravel, with existing user accounts. The passwords are using a different hashing mechanism than bcrypt.

## 2) Solution this demo provides

We have extended the inbuilt basic Laravel auth as follows:
- login checks if the user account was migrated already, and if yes, uses the basic functionality
- if user account was not migrated, it uses a "legacy" login mechanism:
    - taking the table name from the LegacyLogin class
    - verifying the password hash using the "check" method of LegacyHasher class
    
## 3) How to customise this to your use case

### 1. Database table of old user accounts

Replace the protected $table property of the \App\LegacyLogin class

```php
namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class LegacyLogin extends Authenticatable
{
    protected $table = 'my_old_users_table';
    
}
```

### 2. Old password hash mechanism

Replace the validation inside the "check" method of LegacyHasher class, to return true if the password provided inside $value in plain format matches up with the $hashedValue. Example:

```php

namespace App;


use Illuminate\Hashing\BcryptHasher;

class LegacyHasher extends BcryptHasher
{
    public function check($value, $hashedValue, array $options = [])
    {
        if (strlen($hashedValue) === 0) {
            return false;
        }

        return md5($value) === $hashedValue;
    }
    
}
```