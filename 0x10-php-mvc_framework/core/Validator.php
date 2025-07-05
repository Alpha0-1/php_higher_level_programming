<?php
/**
 * Validator Class
 * Handles input validation with various rules
 */
class Validator
{
    private $errors = [];
    
    /**
     * Validate data against rules
     * @param array $data - Data to validate
     * @param array $rules - Validation rules
     * @return bool
     */
    public function validate($data, $rules)
    {
        $this->errors = [];
        
        foreach ($rules as $field => $fieldRules) {
            $fieldRules = is_string($fieldRules) ? explode('|', $fieldRules) : $fieldRules;
            
            foreach ($fieldRules as $rule) {
                $this->validateField($field, $data, $rule);
            }
        }
        
        return empty($this->errors);
    }
    
    /**
     * Validate individual field
     * @param string $field - Field name
     * @param array $data - Data array
     * @param string $rule - Validation rule
     */
    private function validateField($field, $data, $rule)
    {
        $value = isset($data[$field]) ? $data[$field] : null;
        
        // Parse rule and parameters
        $ruleParts = explode(':', $rule);
        $ruleName = $ruleParts[0];
        $parameters = isset($ruleParts[1]) ? explode(',', $ruleParts[1]) : [];
        
        switch ($ruleName) {
            case 'required':
                if (empty($value)) {
                    $this->addError($field, "The {$field} field is required.");
                }
                break;
                
            case 'email':
                if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, "The {$field} field must be a valid email address.");
                }
                break;
                
            case 'min':
                $min = isset($parameters[0]) ? (int)$parameters[0] : 0;
                if (!empty($value) && strlen($value) < $min) {
                    $this->addError($field, "The {$field} field must be at least {$min} characters.");
                }
                break;
                
            case 'max':
                $max = isset($parameters[0]) ? (int)$parameters[0] : PHP_INT_MAX;
                if (!empty($value) && strlen($value) > $max) {
                    $this->addError($field, "The {$field} field may not be greater than {$max} characters.");
                }
                break;
                
            case 'numeric':
                if (!empty($value) && !is_numeric($value)) {
                    $this->addError($field, "The {$field} field must be a number.");
                }
                break;
                
            case 'confirmed':
                $confirmField = $field . '_confirmation';
                if (isset($data[$confirmField]) && $value !== $data[$confirmField]) {
                    $this->addError($field, "The {$field} confirmation does not match.");
                }
                break;
        }
    }
    
    /**
     * Add validation error
     * @param string $field - Field name
     * @param string $message - Error message
     */
    private function addError($field, $message)
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        
        $this->errors[$field][] = $message;
    }
    
    /**
     * Get validation errors
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
    
    /**
     * Check if field has errors
     * @param string $field - Field name
     * @return bool
     */
    public function hasError($field)
    {
        return isset($this->errors[$field]);
    }
    
    /**
     * Get errors for specific field
     * @param string $field - Field name
     * @return array
     */
    public function getFieldErrors($field)
    {
        return isset($this->errors[$field]) ? $this->errors[$field] : [];
    }
}
