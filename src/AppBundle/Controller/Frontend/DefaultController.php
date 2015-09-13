<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\College;
use AppBundle\Entity\University;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $conventions = $this->get('ritsiga.repository.convention')->findConventionsAvailables();

        return $this->render('frontend/conventions/list_conventions.html.twig', [
            'conventions' => $conventions,
        ]);
    }

    /**
     * @Route("/profile/facultades/{id}", name="colleges_list")
     */
    public function getColleges(University $university)
    {
        $universities = $this->get('ritsiga.repository.college')->findCollegeByUniversity($university);

        return new JsonResponse($universities);
    }

    /**
     * @Route("/profile/delegaciones/{id}", name="students_delegations_list")
     */
    public function getStudentsDelegations(College $college)
    {
        $colleges = $this->get('ritsiga.repository.student_delegation')->findStudentDelegationByCollege($college);

        return new JsonResponse($colleges);
    }
}
