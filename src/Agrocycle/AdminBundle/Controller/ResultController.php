<?php

namespace Agrocycle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;
use Agrocycle\AgrocycleBundle\Entity\Result;


class ResultController extends Controller
{
    /**
     * @Route("/admin/results")

     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('AgrocycleAgrocycleBundle:Result');
        $results = $repository->findAll();
        return $this->render('AgrocycleAdminBundle:Results:index.html.twig', array('results' => $results));
    }
    
    /**
     * @Route("/admin/results/detail/{slug}/{id}")

     */
    public function detailAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('AgrocycleAgrocycleBundle:Result');
        $result = $repository->find($id);
        
        return $this->render('AgrocycleAdminBundle:Results:detail.html.twig', array('result' => $result));
    }
    
    /**
     * 
     *@Route("/admin/results/create")
     */
    public function createAction(Request $request)
    {
        $result = new Result();

        $form = $this->createFormBuilder($result)
            ->add('title', 'text', array('label' => 'Naam van hefboom of barrière'))
            ->add('positive', 'choice', array(
            'label' => 'Hefboom of Barrière?',
            'expanded' => false,
            'multiple' => false,
            'choices' => array(
                '0'        => 'Barrière',
                '1'  => 'Hefboom'
                )
            ))
            ->getForm();
        
        if ($request->isMethod('POST'))
        {
            $form->bind($request);
            
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                
                try 
                {
                    
                    $em->persist($result);
                    $em->flush(); 
                    
                } catch (\PDOException $e) {
                    
                    return $this->createAction();
                    
                }
               
                 $this->get('session')->setFlash('success', 'Result aangemaakt.');
                 return $this->redirect($this->generateUrl('agrocycle_admin_result_create')); 
            }
        }

 
        return $this->render('AgrocycleAdminBundle:Results:create.html.twig', array('form' => $form->createView()));
    }
    
    
    /**
     * @Route("/admin/results/edit/{id}")

     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        if ($id)
        {
            $entity = $em->getRepository('AgrocycleAgrocycleBundle:Result')->find($id);
            if( !$entity )
            {
                throw $this->createNotFoundException('Er is geen hefboom of barrière met deze gevens.');
            }
        }
        
       
       $form = $this->createFormBuilder($entity)
            ->add('title', 'text', array('label' => 'Naam van hefboom of barrière'))
            ->add('positive', 'choice', array(
            'label' => 'Hefboom of Barrière?',
            'expanded' => false,
            'multiple' => false,
            'choices' => array(
                '0'        => 'Barrière',
                '1'  => 'Hefboom'
                )
            ))
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
               
                 $this->get('session')->setFlash('success', 'Hefboom of Barrière aangepast');
                 return $this->redirect($this->generateUrl('agrocycle_admin_result_index')); 
            }
        }
        
       return $this->render('AgrocycleAdminBundle:Results:edit.html.twig', array('result' => $entity, 'form' => $form->createView()));
       
    }
    
    /**
     *@Route("/admin/results/delete/{id}") 
     */
    public function deleteAction($id) {
          
        $entity = $this->getDoctrine()->getManager()->getRepository('AgrocycleAgrocycleBundle:Result')->find($id);
        if(!$entity)
        {
            throw $this->createNotFoundException('Deze hefboom of barrière kon niet gevonden worden');
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
          $this->get('session')->setFlash('warning', 'Er is geen hefboom of barrière met deze gegevens');
          return $this->redirect($this->generateUrl('agrocycle_admin_result_index'));
        }
        
        $this->get('session')->setFlash('success', 'Result verwijderd.');
        return $this->redirect($this->generateUrl('agrocycle_admin_result_index')); 
       
    }
    
    
}
