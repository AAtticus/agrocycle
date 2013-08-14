<?php

namespace Agrocycle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;
use Agrocycle\AgrocycleBundle\Entity\Sector as Sector;


class SectorController extends Controller
{
    /**
     * @Route("/admin/sectors")

     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('AgrocycleAgrocycleBundle:Sector');
        $sectors = $repository->findAll();
        return $this->render('AgrocycleAdminBundle:Sectors:index.html.twig', array('sectors' => $sectors));
    }
    
    /**
     * @Route("/admin/sectors/detail/{slug}/{id}")

     */
    public function detailAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('AgrocycleAgrocycleBundle:Sector');
        $sector = $repository->find($id);
        
        return $this->render('AgrocycleAdminBundle:Sectors:detail.html.twig', array('sector' => $sector));
    }
    
    /**
     * 
     *@Route("/admin/sectors/create")
     */
    public function createAction(Request $request)
    {
        $sector = new Sector();

        $form = $this->createFormBuilder($sector)
            ->add('title', 'text', array('label' => 'Naam van de sector'))   
            ->getForm();
        
        if ($request->isMethod('POST'))
        {
            $form->bind($request);
            
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                
                try 
                {
                    
                    $em->persist($sector);
                    $em->flush(); 
                    
                } catch (\PDOException $e) {
                    
                    return $this->createAction();
                    
                }
               
                 $this->get('session')->setFlash('success', 'Sector aangemaakt.');
                 return $this->redirect($this->generateUrl('agrocycle_admin_sector_index')); 
            }
        }

 
        return $this->render('AgrocycleAdminBundle:Sectors:create.html.twig', array('form' => $form->createView()));
    }
    
    
    /**
     * @Route("/admin/sectors/edit/{id}")

     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        if ($id)
        {
            $entity = $em->getRepository('AgrocycleAgrocycleBundle:Sector')->find($id);
            if( !$entity )
            {
                throw $this->createNotFoundException('Er is geen sector met deze gevens.');
            }
        }
        
       
       $form = $this->createFormBuilder($entity)
            ->add('title', 'text', array('label' => 'Naam van de sector'))   
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
               
                 $this->get('session')->setFlash('success', 'Sector aangepast');
                 return $this->redirect($this->generateUrl('agrocycle_admin_sector_index')); 
            }
        }
        
       return $this->render('AgrocycleAdminBundle:Sectors:edit.html.twig', array('sector' => $entity, 'form' => $form->createView()));
       
    }
    
    /**
     *@Route("/admin/sectors/delete/{id}") 
     */
    public function deleteAction($id) {
          
        $entity = $this->getDoctrine()->getManager()->getRepository('AgrocycleAgrocycleBundle:Sector')->find($id);
        if(!$entity)
        {
            throw $this->createNotFoundException('Deze sector kon niet gevonden worden');
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
          $this->get('session')->setFlash('warning', 'Er is geen sector met deze gegevens');
          return $this->redirect($this->generateUrl('agrocycle_admin_sector_index'));
        }
        
        $this->get('session')->setFlash('success', 'Sector verwijderd.');
        return $this->redirect($this->generateUrl('agrocycle_admin_sector_index')); 
       
    }
    
    
}
