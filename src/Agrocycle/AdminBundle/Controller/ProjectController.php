<?php

namespace Agrocycle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;
use Agrocycle\AgrocycleBundle\Entity\Project as Project;


class ProjectController extends Controller
{
    /**
     * @Route("/admin/projects")

     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('AgrocycleAgrocycleBundle:Project');
        $projects = $repository->findAll();
        return $this->render('AgrocycleAdminBundle:Projects:index.html.twig', array('projects' => $projects));
    }
    
    /**
     * @Route("/admin/projects/detail/{slug}/{id}")

     */
    public function detailAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('AgrocycleAgrocycleBundle:Project');
        $project = $repository->find($id);
        
        return $this->render('AgrocycleAdminBundle:Projects:detail.html.twig', array('project' => $project));
    }
    
    /**
     * 
     *@Route("/admin/projects/create")
     */
    public function createAction(Request $request)
    {
        $project = new Project();

        $form = $this->createFormBuilder($project)
            ->add('title', 'text', array('label' => 'Projectnaam'))
            ->add('organisation', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Organisation',
                'property' => 'name',
                'required' => false,
                'label'    => 'Organisation'
            ))
            ->add('person', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Person',
                'label'    => 'Contactpersoon',
                'required' => false,
            ))
             ->add('research', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Research',
                'property' => 'title',
                'required' => false,
                'label'    => 'Gevolgd uit onderzoek? Zoja welk?'
            ))
            ->add('source', 'textarea', array('label' => 'Bron'))
            
           
            ->add('subcategory', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Subcategory',
                'property' => 'title',
                'label'    => 'Levensmiddel / Subcategorie'
            ))
             ->add('sector', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Sector',
                'property' => 'title',
                'label'    => 'Sector'
            ))
            ->add('is_bio', 'choice', array(
            'label' => 'Bio?',
            'expanded' => false,
            'multiple' => false,
            'choices' => array(
                'Ja'        => 'Ja',
                'Nee'  => 'Nee',
                'Deels'  => 'Deels'
                )
            ))
            ->add('primaryActivity', 'textarea', array('label' => 'Primaire Activiteit'))
            ->add('primaryFlow', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Process',
                'property' => 'title',
                'multiple' => true,
                'expanded' => false,
                'label'    => 'Hoofdstromen'
            ))
            ->add('secondaryFlow', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Process',
                'property' => 'title',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'label'    => 'Nevenstromen'
            ))
            ->add('externalFlow', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Process',
                'property' => 'title',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'label'    => 'Nevenstromen van derden'
            ))
             ->add('secondaryCycleExample', 'textarea', array('label' => 'Voorbeeld van sluiten nevenstromen', 'required' => false))
              ->add('CycleExample', 'textarea', array('label' => 'Voorbeeld van Agrocycle', 'required' => false))
             ->add('results', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Result',
                'property' => 'title',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'label'    => 'Hefbomen en Barrières'
            ))
            
            ->add('inspiration', 'textarea', array('label' => 'Inspiratie', 'required' => false))
            ->add('extraInformation', 'textarea', array('label' => 'Opmerkingen', 'required' => false))
            ->getForm();
        
        if ($request->isMethod('POST'))
        {
            $form->bind($request);
            
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                
                try 
                {
                    
                    $em->persist($project);
                    $em->flush(); 
                    
                } catch (\PDOException $e) {
                    
                    return $this->createAction();
                    
                }
               
                 $this->get('session')->setFlash('success', 'Project aangemaakt.');
                 return $this->redirect($this->generateUrl('agrocycle_admin_project_index')); 
            }
        }

 
        return $this->render('AgrocycleAdminBundle:Projects:create.html.twig', array('form' => $form->createView()));
    }
    
    
    /**
     * @Route("/admin/projects/edit/{id}")

     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        if ($id)
        {
            $entity = $em->getRepository('AgrocycleAgrocycleBundle:Project')->find($id);
            if( !$entity )
            {
                throw $this->createNotFoundException('Er is project met deze gevens.');
            }
        }
        
       
              $form = $this->createFormBuilder($entity)
            ->add('title', 'text', array('label' => 'Projectnaam'))
            ->add('organisation', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Organisation',
                'property' => 'name',
                'required' => false,
                'label'    => 'Organisation'
            ))
            ->add('person', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Person',
                'label'    => 'Contactpersoon',
                'required' => false,
            ))
             ->add('research', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Research',
                'property' => 'title',
                'required' => false,
                'label'    => 'Gevolgd uit onderzoek? Zoja welk?'
            ))
            ->add('source', 'textarea', array('label' => 'Bron'))
            
           
            ->add('subcategory', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Subcategory',
                'property' => 'title',
                'label'    => 'Levensmiddel / Subcategorie'
            ))
             ->add('sector', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Sector',
                'property' => 'title',
                'label'    => 'Sector'
            ))
            ->add('is_bio', 'choice', array(
            'label' => 'Bio?',
            'expanded' => false,
            'multiple' => false,
            'choices' => array(
                'Ja'        => 'Ja',
                'Nee'  => 'Nee',
                'Deels'  => 'Deels'
                )
            ))
            ->add('primaryActivity', 'textarea', array('label' => 'Primaire Activiteit'))
            ->add('primaryFlow', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Process',
                'property' => 'title',
                'multiple' => true,
                'expanded' => false,
                'label'    => 'Hoofdstromen'
            ))
            ->add('secondaryFlow', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Process',
                'property' => 'title',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'label'    => 'Nevenstromen'
            ))
            ->add('externalFlow', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Process',
                'property' => 'title',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'label'    => 'Nevenstromen van derden'
            ))
             ->add('secondaryCycleExample', 'textarea', array('label' => 'Voorbeeld van sluiten nevenstromen', 'required' => false))
              ->add('CycleExample', 'textarea', array('label' => 'Voorbeeld van Agrocycle', 'required' => false))
             ->add('results', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Result',
                'property' => 'title',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'label'    => 'Hefbomen en Barrières'
            ))
            
            ->add('inspiration', 'textarea', array('label' => 'Inspiratie', 'required' => false))
            ->add('extraInformation', 'textarea', array('label' => 'Opmerkingen', 'required' => false))
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
               
                 $this->get('session')->setFlash('success', 'Project aangepast');
                 return $this->redirect($this->generateUrl('agrocycle_admin_project_index')); 
            }
        }
        
       return $this->render('AgrocycleAdminBundle:Projects:edit.html.twig', array('project' => $entity, 'form' => $form->createView()));
       
    }
    
    /**
     *@Route("/admin/projects/delete/{id}") 
     */
    public function deleteAction($id) {
          
        $entity = $this->getDoctrine()->getManager()->getRepository('AgrocycleAgrocycleBundle:Project')->find($id);
        if(!$entity)
        {
            throw $this->createNotFoundException('Dit project kon niet gevonden worden');
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
          $this->get('session')->setFlash('warning', 'Er is geen project met deze gegevens');
          return $this->redirect($this->generateUrl('agrocycle_admin_project_index'));
        }
        
        $this->get('session')->setFlash('success', 'Project verwijderd.');
        return $this->redirect($this->generateUrl('agrocycle_admin_project_index')); 
       
    }
    
    
}
