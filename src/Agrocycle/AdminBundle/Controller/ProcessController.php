<?php

namespace Agrocycle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;
use Agrocycle\AgrocycleBundle\Entity\Process as Process;


class ProcessController extends Controller
{
    /**
     * @Route("/admin/processes")

     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('AgrocycleAgrocycleBundle:Process');
        $processes = $repository->findAll();
        return $this->render('AgrocycleAdminBundle:Processes:index.html.twig', array('processes' => $processes));
    }
    

    /**
     * 
     *@Route("/admin/processes/create")
     */
    public function createAction(Request $request)
    {
        $process = new Process();

        $form = $this->createFormBuilder($process)
            ->add('title', 'text', array('label' => 'Naam van het process'))   
            ->getForm();
        
        if ($request->isMethod('POST'))
        {
            $form->bind($request);
            
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                
                try 
                {
                    
                    $em->persist($process);
                    $em->flush(); 
                    
                } catch (\PDOException $e) {
                    
                    return $this->createAction();
                    
                }
               
                 $this->get('session')->setFlash('success', 'Process aangemaakt.');
                 return $this->redirect($this->generateUrl('agrocycle_admin_process_create')); 
            }
        }

 
        return $this->render('AgrocycleAdminBundle:Processes:create.html.twig', array('form' => $form->createView()));
    }
    
    
    /**
     * @Route("/admin/processes/edit/{id}")

     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        if ($id)
        {
            $entity = $em->getRepository('AgrocycleAgrocycleBundle:Process')->find($id);
            if( !$entity )
            {
                throw $this->createNotFoundException('Er is geen process met deze gevens.');
            }
        }
        
       
       $form = $this->createFormBuilder($entity)
            ->add('title', 'text', array('label' => 'Naam van het process'))   
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
               
                 $this->get('session')->setFlash('success', 'Process aangepast');
                 return $this->redirect($this->generateUrl('agrocycle_admin_process_index')); 
            }
        }
        
       return $this->render('AgrocycleAdminBundle:Processes:edit.html.twig', array('process' => $entity, 'form' => $form->createView()));
       
    }
    
    /**
     *@Route("/admin/processes/delete/{id}") 
     */
    public function deleteAction($id) {
          
        $entity = $this->getDoctrine()->getManager()->getRepository('AgrocycleAgrocycleBundle:Process')->find($id);
        if(!$entity)
        {
            throw $this->createNotFoundException('Dit process kon niet gevonden worden');
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
          $this->get('session')->setFlash('warning', 'Er is geen process met deze gegevens');
          return $this->redirect($this->generateUrl('agrocycle_admin_process_index'));
        }
        
        $this->get('session')->setFlash('success', 'Process verwijderd.');
        return $this->redirect($this->generateUrl('agrocycle_admin_process_index')); 
       
    }
    
    
}
