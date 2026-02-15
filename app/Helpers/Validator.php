<?php
declare(strict_types=1);

namespace App\Helpers;

class Validator
{
    /**
     * Validates an array of data against specific rules.
     * * @param array<string, mixed> $data The raw input.
     * @param array<string, string> $rules The rules (e.g., 'title' => 'required|min:3').
     */
    public static function validate(array $data, array $rules): void
    {
        foreach ($rules as $field => $ruleset) {
            $value = $data[$field] ?? null;
            $allRules = explode('|', $ruleset);

            foreach ($allRules as $rule) {
                if ($rule === 'required' && (empty($value) && $value !== '0')) {
                    Response::error("The field '{$field}' is required.", 422);
                }

                if (str_starts_with($rule, 'min:')) {
                    $min = (int) explode(':', $rule)[1];
                    if (strlen((string)$value) < $min) {
                        Response::error("The field '{$field}' must be at least {$min} characters.", 422);
                    }
                }

                if (str_starts_with($rule, 'in:')) {
                    $allowed = explode(',', explode(':', $rule)[1]);
                    if (!in_array($value, $allowed, true)) {
                        Response::error("The field '{$field}' must be one of: " . implode(', ', $allowed), 422);
                    }
                }
            }
        }
    }
}