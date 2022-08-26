<?php
/**
 * BY: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/15/2022
 * TIME: 11:20 PM
 * COURSE: Webbprogrammering DT058G
 * SUPERVISOR: Mikael Hasselmalm
 */

namespace app\core;

abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';

    public function loadData($data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key) && $value != null) {
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules(): array;

    public function labels(): array
    {
        return [];
    }

    public function getLabel($attr)
    {
        return $this->labels()[$attr] ?? $attr;
    }

    public array $errors = [];

    public function validate(): bool
    {
        foreach ($this->rules() as $attr => $rules) {
            $value = $this->{$attr};
            foreach ($rules as $rule) {
                !is_string($rule) ? $ruleName = $rule[0] : $ruleName = $rule;

                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addRuleError($attr, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addRuleError($attr, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addRuleError($attr, self::RULE_MIN, $rule);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $rule['match'] = $this->getLabel($rule['match']);
                    $this->addRuleError($attr, self::RULE_MATCH, $rule);
                }
                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attributes'] ?? $attr;
                    $tableName = $className::tableName();
                    $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
                    $statement->bindValue(':attr', $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if ($record) {
                        $this->addRuleError($attr, self::RULE_UNIQUE, ['field' => $this->getLabel($attr)]);
                    }
                }
            }
        }
        return empty($this->errors);
    }

    private function addRuleError(string $attr, string $rule, $params = []): void
    {
        $message = $this->errorMessages()[$rule];
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attr][] = $message;
    }

    public function addError(string $attr, $message): void
    {
        $this->errors[$attr][] = $message;
    }

    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'A valid email address is required',
            self::RULE_MIN => 'Minimum numbers of characters for this field is {min}',
            self::RULE_MATCH => 'This field did not match {match}',
            self::RULE_UNIQUE => 'Entry with this {field} already exists'
        ];
    }

    public function hasError($attr): bool|array
    {
        return $this->errors[$attr] ?? false;
    }

    public function getFirstErrorMessage($attr)
    {
        return $this->errors[$attr][0] ?? false;
    }
}