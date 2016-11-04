<?php

namespace ClientBundle\Entity\Passport;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "russian" = "RussianPassport",
 * })
 * @ORM\Table(name="client_passport")
 */
abstract class Passport implements PassportInterface
{
    const TYPE_RUSSIAN = 'russian';
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public static function getTypes()
    {
        return [
            self::TYPE_RUSSIAN => 'Россия',
        ];
    }


}
