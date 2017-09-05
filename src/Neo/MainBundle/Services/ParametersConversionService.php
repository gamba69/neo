<?php
/**
 * User: idulevich
 */

namespace Neo\MainBundle\Services;

/**
 * Class ParametersConversionService
 * @package Neo\MainBundle\Services
 */
class ParametersConversionService
{
    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function getBooleanValueOf($value)
    {
        if (is_bool($value)) {
            return $value;
        }
        if (!is_scalar($value)) {
            return false;
        }
        if ($value === 'true') {
            return true;
        }
        return false;
    }
}