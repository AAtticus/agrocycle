<?php

namespace Agrocycle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;
use Agrocycle\AgrocycleBundle\Entity\Subcategory as Subcategory;


class SubcategoryController extends Controller
{
   
    /**
     * @Route("/admin/subcategories/detail/{slug}/{id}")

     */
    public function detailAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('AgrocycleAgrocycleBundle:Subcategory');
        $subcategory = $repository->find($id);
        
        return $this->render('AgrocycleAdminBundle:Subcategories:detail.html.twig', array('subcategory' => $subcategory));
    }
    
    
    /**
     * @Route("/admin/subcategories/edit/{id}")

     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        if ($id)
        {
            $entity = $em->getRepository('AgrocycleAgrocycleBundle:Subcategory')->find($id);
            if( !$entity )
            {
                throw $this->createNotFoundException('Er is geen subcategorie met deze gegevens.');
            }
        }
        
       $form = $this->createFormBuilder($entity)
            ->add('title', 'text', array('label' => 'Subcategorie'))
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
               
                 $this->get('session')->setFlash('success', 'Subcategorie aangepast');
                 return $this->redirect($this->generateUrl('agrocycle_admin_category_detail', array('id' => $entity->getCategory()->getId(), 'slug' => $entity->getCategory()->getSlug()))); 
            }
        }
        
       return $this->render('AgrocycleAdminBundle:Subcategories:edit.html.twig', array('subcategory' => $entity, 'form' => $form->createView()));
       
    }
    
    /**
     *@Route("/admin/subcategories/delete/{id}") 
     */
    public function deleteAction($id) {
          
        $entity = $this->getDoctrine()->getManager()->getRepository('AgrocycleAgrocycleBundle:Subcategory')->find($id);
        if(!$entity)
        {
            throw $this->createNotFoundException('Deze subcategorie kon niet gevonden worden');
        }
        
        if($entity)
        {
          
          $parentId = $entity->getCategory()->getId();
          $parentSlug = $entity->getCategory()->getSlug();
            
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
          $this->get('session')->setFlash('warning', 'Er is geen subcategorie met deze gegevens');
          return $this->redirect($this->generateUrl('agrocycle_admin_category_detail', array('id' => $parentId, 'slug' => $parentSlug)));
        }
        
        $this->get('session')->setFlash('success', 'Subcategorie verwijderd.');
        return $this->redirect($this->generateUrl('agrocycle_admin_category_detail', array('id' => $parentId, 'slug' => $parentSlug)));
       
    }
    
    
}
