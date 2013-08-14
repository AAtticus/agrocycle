<?php

namespace Agrocycle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

class DefaultController extends Controller
{
    /**
     * @Route("/admin")

     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('AgrocycleAgrocycleBundle:Project');
        $projects = $repository->findAll();
        
        $repository = $this->getDoctrine()->getRepository('AgrocycleAgrocycleBundle:Research');
        $researches = $repository->findAll();
        
        return  $this->render('AgrocycleAdminBundle:Default:index.html.twig', array('projects' => $projects, 'researches' => $researches));
    }
}
