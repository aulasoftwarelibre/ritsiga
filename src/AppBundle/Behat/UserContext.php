<?php
/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 24/03/15
 * Time: 21:14
 */

namespace AppBundle\Behat;

use AppBundle\Entity\User;
use AppBundle\Entity\StudentDelegation;
use Behat\Gherkin\Node\TableNode;
use Sylius\Bundle\ResourceBundle\Behat\DefaultContext;

class UserContext  extends DefaultContext
{
    /**
     * @Given /^que existen los siguientes usuarios:$/
     */
    public function createUser(TableNode $tableNode)
    {
        foreach ($tableNode->getHash() as $userHash) {
            $user = new User();
            $user->setUsername($userHash['username']);
            $user->setEmail($userHash['email']);
            $user->setPlainPassword($userHash['plainPassword']);
            $student_delegation=$this->getEntityManager()->getRepository('AppBundle:StudentDelegation')->findOneBy(['name' => $userHash['student_delegation']]);
            var_dump($student_delegation);
            $user->setStudentDelegation($student_delegation);
            $this->getEntityManager()->persist($user);
        }
        $this->getEntityManager()->flush();
    }

    /**
     * @Then debería ver :number usuario(s) en la lista
     */
    public function iShouldSeeUser($number)
    {
        $this->assertSession()->elementsCount('css', '.user', $number);
    }

}