<?php

namespace Agrocycle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;
use Agrocycle\AgrocycleBundle\Entity\Research as Research;


class ResearchController extends Controller
{
    /**
     * @Route("/admin/researches")

     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('AgrocycleAgrocycleBundle:Research');
        $researches = $repository->findAll();
        return $this->render('AgrocycleAdminBundle:Researches:index.html.twig', array('researches' => $researches));
    }
    
    /**
     * @Route("/admin/researches/detail/{slug}/{id}")

     */
    public function detailAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('AgrocycleAgrocycleBundle:Research');
        $research = $repository->find($id);
        
        return $this->render('AgrocycleAdminBundle:Researches:detail.html.twig', array('research' => $research));
    }
    
    /**
     * 
     *@Route("/admin/researches/create")
     */
    public function createAction(Request $request)
    {
        $research = new Research();

        $form = $this->createFormBuilder($research)
            ->add('title', 'text', array('label' => 'Onderzoek'))
            ->add('organisation', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Organisation',
                'property' => 'name',
                'required' => false,
                'label'    => 'Organisation'
            ))
            ->add('website', 'text', array('label' => 'Bron / Website'))
            ->add('person', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Person',
                'label'    => 'Contactpersoon',
                 'required' => false
            ))
           ->add('projects', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Project',
                'property' => 'title',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'label'    => 'Is er een project uitgekomen?'
            ))
            ->add('secondaryFlow', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Process',
                'property' => 'title',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'label'    => 'Nevenstromen'
            ))
            ->add('CycleExample', 'textarea', array('label' => 'Voorbeeld van Agrocycle', 'required' => false))
             ->add('results', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Result',
                'property' => 'title',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'label'    => 'Hefbomen en Barrières'
            ))
           
            ->add('duration', 'text', array('label' => 'Duur van het onderzoek'))
            ->add('applicant', 'text', array('label' => 'Aangevraagd door'))
            ->add('financing', 'text', array('label' => 'Financiering'))
            ->add('partners', 'textarea', array('label' => 'Partners', 'required' => false))
            ->add('notes', 'textarea', array('label' => 'Notities', 'required' => false))
            ->getForm();
        
        if ($request->isMethod('POST'))
        {
            $form->bind($request);
            
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                
                try 
                {
                    
                    $em->persist($research);
                    $em->flush(); 
                    
                } catch (\PDOException $e) {
                    
                    return $this->createAction();
                    
                }
               
                 $this->get('session')->setFlash('success', 'Onderzoek aangemaakt.');
                 return $this->redirect($this->generateUrl('agrocycle_admin_research_index')); 
            }
        }

 
        return $this->render('AgrocycleAdminBundle:Researches:create.html.twig', array('form' => $form->createView()));
    }
    
    
    /**
     * @Route("/admin/researches/edit/{id}")

     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        if ($id)
        {
            $entity = $em->getRepository('AgrocycleAgrocycleBundle:Research')->find($id);
            if( !$entity )
            {
                throw $this->createNotFoundException('Er is onderzoek met deze gegevens.');
            }
        }
        
       
        $form = $this->createFormBuilder($entity)
            ->add('title', 'text', array('label' => 'Onderzoek'))
            ->add('organisation', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Organisation',
                'property' => 'name',
                'required' => false,
                'label'    => 'Organisation'
            ))
            ->add('website', 'text', array('label' => 'Bron / Website'))
            ->add('person', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Person',
                'label'    => 'Contactpersoon',
                 'required' => false,
            ))
             ->add('projects', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Project',
                'property' => 'title',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'label'    => 'Is er een project uitgekomen?'
            ))
            ->add('secondaryFlow', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Process',
                'property' => 'title',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'label'    => 'Nevenstromen'
            ))
           
             ->add('results', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Result',
                'property' => 'title',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'label'    => 'Hefbomen en Barrières'
            ))
           
            ->add('duration', 'text', array('label' => 'Duur van het onderzoek'))
            ->add('applicant', 'text', array('label' => 'Aangevraagd door'))
            ->add('financing', 'text', array('label' => 'Financiering'))
            ->add('partners', 'textarea', array('label' => 'Partners', 'required' => false))
            ->add('notes', 'textarea', array('label' => 'Notities', 'required' => false))
            ->getForm();
        
       if ($request->isMethod('POST'))
        {
            $form->bind($request);
            
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                try 
                {
                   
                    
                    $em->persist($entity);
                    $em->flush(); 
                    
                } catch (\PDOException $e) {
                    
                    return $this->editAction($id);
                    
                }
               
                 $this->get('session')->setFlash('success', 'Onderzoek aangepast');
                 return $this->redirect($this->generateUrl('agrocycle_admin_research_index')); 
            }
        }
        
       return $this->render('AgrocycleAdminBundle:Researches:edit.html.twig', array('research' => $entity, 'form' => $form->createView()));
       
    }
    
    /**
     *@Route("/admin/researches/delete/{id}") 
     */
    public function deleteAction($id) {
          
        $entity = $this->getDoctrine()->getManager()->getRepository('AgrocycleAgrocycleBundle:Research')->find($id);
        if(!$entity)
        {
            throw $this->createNotFoundException('Dit onderzoek kon niet gevonden worden');
        }
        
        if($entity)
        {
          $em = $this->getDoctrine()->getManager();
          $em->remove($entity);
          
          try
          {
              $em->flush();
              
          } catch(\PDOException $e) 
          
          {
                  
          }
          
        }
        
        else {
          $this->get('session')->setFlash('warning', 'Er is geen onderzoek met deze gegevens');
          return $this->redirect($this->generateUrl('agrocycle_admin_research_index'));
        }
        
        $this->get('session')->setFlash('success', 'Onderzoek verwijderd.');
        return $this->redirect($this->generateUrl('agrocycle_admin_research_index')); 
       
    }
    
    
}
