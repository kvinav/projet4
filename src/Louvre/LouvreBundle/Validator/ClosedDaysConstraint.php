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

class ClosedDaysConstraint extends Constraint
{
    public $message = "Vous ne pouvez pas réserver de billets pour le mardi, le dimanche et les jours fériés";
}