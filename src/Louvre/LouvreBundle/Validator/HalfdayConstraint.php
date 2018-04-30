<?php
/**
 * Created by PhpStorm.
 * User: kevinavignon
 * Date: 24/04/2018
 * Time: 16:06
 */
namespace Louvre\LouvreBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */

class HalfdayConstraint extends Constraint
{
    public $message = "Vous ne pouvez pas réserver de billets journée pour le jour même après 14h";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
