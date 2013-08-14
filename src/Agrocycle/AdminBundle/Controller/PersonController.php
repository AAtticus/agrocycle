<?php

namespace Agrocycle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;
use Agrocycle\AgrocycleBundle\Entity\Organisation as Organisation;
use Agrocycle\AgrocycleBundle\Entity\Person as Person;


class PersonController extends Controller
{
    /**
     * @Route("/admin/persons")

     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('AgrocycleAgrocycleBundle:Person');
        $persons= $repository->findAll();
        return $this->render('AgrocycleAdminBundle:Persons:index.html.twig', array('persons' => $persons));
    }
    
    /**
     * @Route("/admin/persons/detail/{id}")

     */
    public function detailAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('AgrocycleAgrocycleBundle:Person');
        $person = $repository->find($id);
        return $this->render('AgrocycleAdminBundle:Persons:detail.html.twig', array('person' => $person));
    }
    
    /**
     * 
     *@Route("/admin/persons/create")
     */
    public function createAction(Request $request)
    {
        $person = new Person();

        $form = $this->createFormBuilder($person)
            ->add('firstName', 'text', array('label' => 'Voornaam', 'required' => false))
            ->add('lastName', 'text', array('label' => 'Familienaam'))
            ->add('email', 'email', array('label' => 'Email', 'required' => false))
            ->add('telephone', 'text', array('label' => 'Telefoon', 'required' => false))
            ->add('organisation', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Organisation',
                'property' => 'name',
                'label'    => 'Organisatie'
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
                    
                    $em->persist($person);
                    $em->flush(); 
                    
                } catch (\PDOException $e) {
                    
                    return $this->createAction();
                    
                }
               
                 $this->get('session')->setFlash('success', 'Person aangemaakt.');
                 return $this->redirect($this->generateUrl('agrocycle_admin_person_index')); 
            }
        }

 
        return $this->render('AgrocycleAdminBundle:Persons:create.html.twig', array('form' => $form->createView()));
    }
    
    
    /**
     * @Route("/admin/persons/edit/{id}")

     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        if ($id)
        {
            $entity = $em->getRepository('AgrocycleAgrocycleBundle:Person')->find($id);
            if( !$entity )
            {
                throw $this->createNotFoundException('Er is geen persoon met deze gegevens.');
            }
        }
        
        $form = $this->createFormBuilder($entity)
            ->add('firstName', 'text', array('label' => 'Voornaam', 'required' => false))
            ->add('lastName', 'text', array('label' => 'Familienaam'))
            ->add('email', 'email', array('label' => 'Email', 'required' => false))
            ->add('telephone', 'text', array('label' => 'Telefoon', 'required' => false))
            ->add('organisation', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Organisation',
                'property' => 'name',
                'label'    => 'Organisatie'
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
               
                 $this->get('session')->setFlash('success', 'Persoon aangepast');
                 return $this->redirect($this->generateUrl('agrocycle_admin_person_index')); 
            }
        }
        
       return $this->render('AgrocycleAdminBundle:Persons:edit.html.twig', array('person' => $entity, 'form' => $form->createView()));
       
    }
    
    /**
     *@Route("/admin/persons/delete/{id}") 
     */
    public function deleteAction($id) {
          
        $entity = $this->getDoctrine()->getManager()->getRepository('AgrocycleAgrocycleBundle:Person')->find($id);
        if(!$entity)
        {
            throw $this->createNotFoundException('Deze persoon kon niet gevonden worden');
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
          $this->get('session')->setFlash('warning', 'Er is geen persoon met deze gegevens');
          return $this->redirect($this->generateUrl('agrocycle_admin_person_index'));
        }
        
        $this->get('session')->setFlash('success', 'Persoon verwijderd.');
        return $this->redirect($this->generateUrl('agrocycle_admin_person_index')); 
       
    }
    
    
}
