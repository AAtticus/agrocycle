<?php

namespace Agrocycle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;
use Agrocycle\AgrocycleBundle\Entity\Category as Category;
use Agrocycle\AgrocycleBundle\Entity\Subcategory as Subcategory;


class CategoryController extends Controller
{
    /**
     * @Route("/admin/categories")

     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('AgrocycleAgrocycleBundle:Category');
        $categories= $repository->findAll();
        return $this->render('AgrocycleAdminBundle:Categories:index.html.twig', array('categories' => $categories));
    }
    
    /**
     * @Route("/admin/categories/detail/{slug}/{id}")

     */
    public function detailAction($id, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AgrocycleAgrocycleBundle:Category');
        $category = $repository->find($id);
        
        $entity = new Subcategory();

        $form = $this->createFormBuilder($entity)
            ->add('title', 'text', array('label' => 'Titel van deze subcategory'))
            ->getForm();
        
        if ($request->isMethod('POST'))
        {
            $form->bind($request);
            
            if ($form->isValid())
            {
                $entity->setCategory($category);
                $em = $this->getDoctrine()->getManager();
                
                try 
                {
                    
                    $em->persist($entity);
                    $em->flush(); 
                    
                } catch (\PDOException $e) {
                    
                    return $this->createAction();
                    
                }
               
                 $this->get('session')->setFlash('success', 'Subcategorie aangemaakt.');
                 return $this->redirect($this->generateUrl('agrocycle_admin_category_detail', array('id' => $category->getId(), 'slug' => $category->getSlug()))); 
            }
        }


        return $this->render('AgrocycleAdminBundle:Categories:detail.html.twig', array('category' => $category, 'form' => $form->createView()));
    }
    
    /**
     * 
     *@Route("/admin/categories/create")
     */
    public function createAction(Request $request)
    {
        $entity = new Category();

        $form = $this->createFormBuilder($entity)
            ->add('title', 'text', array('label' => 'Titel van deze category'))
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
                    
                    return $this->createAction();
                    
                }
               
                 $this->get('session')->setFlash('success', 'Categorie aangemaakt.');
                 return $this->redirect($this->generateUrl('agrocycle_admin_category_index')); 
            }
        }

 
        return $this->render('AgrocycleAdminBundle:Categories:create.html.twig', array('form' => $form->createView()));
    }
    
    
    /**
     * @Route("/admin/categories/edit/{id}")

     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        if ($id)
        {
            $entity = $em->getRepository('AgrocycleAgrocycleBundle:Category')->find($id);
            if( !$entity )
            {
                throw $this->createNotFoundException('Er is geen categorie met deze gegevens.');
            }
        }
        
       $form = $this->createFormBuilder($entity)
            ->add('title', 'text', array('label' => 'Categorie'))
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
               
                 $this->get('session')->setFlash('success', 'Categorie aangepast');
                 return $this->redirect($this->generateUrl('agrocycle_admin_category_index')); 
            }
        }
        
       return $this->render('AgrocycleAdminBundle:Categories:edit.html.twig', array('category' => $entity, 'form' => $form->createView()));
       
    }
    
    /**
     *@Route("/admin/categories/delete/{id}") 
     */
    public function deleteAction($id) {
          
        $entity = $this->getDoctrine()->getManager()->getRepository('AgrocycleAgrocycleBundle:Category')->find($id);
        if(!$entity)
        {
            throw $this->createNotFoundException('Deze categorie kon niet gevonden worden');
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
          $this->get('session')->setFlash('warning', 'Er is geen categorie met deze gegevens');
          return $this->redirect($this->generateUrl('agrocycle_admin_category_index'));
        }
        
        $this->get('session')->setFlash('success', 'Categorie verwijderd.');
        return $this->redirect($this->generateUrl('agrocycle_admin_category_index')); 
       
    }
    
    
}
