<?php

namespace app\core\form;

use app\core\Model;

class Field
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'number';
    public const TYPE_EMAIL = 'email';

    public Model $model;
    public string $attr;
    public string $type;

    /**
     * @param Model $model
     * @param string $attr
     */
    public function __construct(\app\core\Model $model, string $attr)
    {
        $this->type = self::TYPE_TEXT;
        $this->model = $model;
        $this->attr = $attr;
    }

    public function __toString()
    {
        return sprintf('
            <div class="mb-3">
                <label for="%s" class="form-label">%s</label>
                <input class="form-control%s" type="%s" id="%s" name="%s" value="%s">
                <div class="invalid-feedback">
                    %s
                </div>
            </div>
        ',
            $this->attr, // for
            $this->model->getLabel($this->attr), // label value
            $this->model->hasError($this->attr) ? ' is-invalid' : '', // class
            $this->type, // type
            $this->attr, // id
            $this->attr, // name
            $this->attr === 'password' || $this->attr === 'passwordConfirmation' ? '' : $this->model->{$this->attr}, // value
            $this->model->getFirstErrorMessage($this->attr) // feedback
        );
    }
    public function setFieldType($fieldType)
    {
        switch ($fieldType) {
            case self::TYPE_PASSWORD:
                $this->type = self::TYPE_PASSWORD;
                break;
            case self::TYPE_EMAIL:
                $this->type = self::TYPE_EMAIL;
                break;
            case self::TYPE_NUMBER:
                $this->type = self::TYPE_NUMBER;
                break;
            default:
                $this->type = self::TYPE_TEXT;
        }
        return $this;
    }
}