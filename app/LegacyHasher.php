<?php


namespace App;


use Illuminate\Hashing\BcryptHasher;

class LegacyHasher extends BcryptHasher
{

    /**
     * Check the given plain value against a hash.
     *
     * @param  string  $value
     * @param  string  $hashedValue
     * @param  array   $options
     * @return bool
     */
    public function check($value, $hashedValue, array $options = [])
    {
        if (strlen($hashedValue) === 0) {
            return false;
        }

        return $value === 'asdf1234' && $hashedValue === 'my_legacy_hash';
    }
}