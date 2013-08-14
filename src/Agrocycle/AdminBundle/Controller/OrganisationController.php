<?php

namespace Agrocycle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;
use Agrocycle\AgrocycleBundle\Entity\Organisation as Organisation;
use Ivory\GoogleMapBundle\Model\Overlays\Animation;

class OrganisationController extends Controller
{
    /**
     * @Route("/admin/organisations")

     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('AgrocycleAgrocycleBundle:Organisation');
        $organisations = $repository->findAll();
        return $this->render('AgrocycleAdminBundle:Organisations:index.html.twig', array('organisations' => $organisations));
    }
    
    /**
     * @Route("/admin/organisations/detail/{slug}/{id}")

     */
    public function detailAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('AgrocycleAgrocycleBundle:Organisation');
        $organisation = $repository->find($id);
        
        $map = $this->get('ivory_google_map.map');
        
        // Requests the ivory google map marker service
        $marker = $this->get('ivory_google_map.marker');
        $map->setCenter($organisation->getLocation()->getLattitude(), $organisation->getLocation()->getLongitude(), true);
        $map->setMapOption('zoom', 12);
        // Configure your marker options
        $marker->setPrefixJavascriptVariable('marker_');
        $marker->setPosition($organisation->getLocation()->getLattitude(), $organisation->getLocation()->getLongitude(), true);
        $marker->setAnimation(Animation::DROP);

        $marker->setOption('clickable', false);
        $marker->setOption('flat', true);
        $marker->setOptions(array(
            'clickable' => false,
            'flat' => true
        ));
        
        $map->addMarker($marker);
        
        return $this->render('AgrocycleAdminBundle:Organisations:detail.html.twig', array('organisation' => $organisation, 'map' => $map));
    }
    
    /**
     * 
     *@Route("/admin/organisations/create")
     */
    public function createAction(Request $request)
    {
        $organisation = new Organisation();

        $form = $this->createFormBuilder($organisation)
            ->add('name', 'text', array('label' => 'Naam van de instelling'))
            ->add('email', 'text', array('label' => 'Email', 'required' => false))
            ->add('website', 'text', array('label' => 'Website', 'required' => false))
            ->add('telephone', 'text', array('label' => 'Telefoon', 'required' => false))
            ->add('location', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Location',
                'label'    => 'Locatie'
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
                    
                    $em->persist($organisation);
                    $em->flush(); 
                    
                } catch (\PDOException $e) {
                    
                    return $this->createAction();
                    
                }
               
                 $this->get('session')->setFlash('success', 'Organisatie aangemaakt.');
                 return $this->redirect($this->generateUrl('agrocycle_admin_organisation_index')); 
            }
        }

 
        return $this->render('AgrocycleAdminBundle:Organisations:create.html.twig', array('form' => $form->createView()));
    }
    
    
    /**
     * @Route("/admin/organisations/edit/{id}")

     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        if ($id)
        {
            $entity = $em->getRepository('AgrocycleAgrocycleBundle:Organisation')->find($id);
            if( !$entity )
            {
                throw $this->createNotFoundException('Er is geen organisatie met deze gevens.');
            }
        }
        
        $form = $this->createFormBuilder($entity)
            ->add('name', 'text', array('label' => 'Naam van de instelling'))
            ->add('email', 'text', array('label' => 'Email', 'required' => false))
            ->add('website', 'text', array('label' => 'Website', 'required' => false))
            ->add('telephone', 'text', array('label' => 'Telefoon', 'required' => false))
            ->add('location', 'entity', array(
                'class' => 'AgrocycleAgrocycleBundle:Location',
                'label'    => 'Locatie'
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
               
                 $this->get('session')->setFlash('success', 'Organisatie aangepast');
                 return $this->redirect($this->generateUrl('agrocycle_admin_organisation_index')); 
            }
        }
        
       return $this->render('AgrocycleAdminBundle:Organisations:edit.html.twig', array('organisation' => $entity, 'form' => $form->createView()));
       
    }
    
    /**
     *@Route("/admin/organisations/delete/{id}") 
     */
    public function deleteAction($id) {
          
        $entity = $this->getDoctrine()->getManager()->getRepository('AgrocycleAgrocycleBundle:Organisation')->find($id);
        if(!$entity)
        {
            throw $this->createNotFoundException('Deze organisatie kon niet gevonden worden');
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
          $this->get('session')->setFlash('warning', 'Er is geen organisatie met deze gegevens');
          return $this->redirect($this->generateUrl('agrocycle_admin_organisation_index'));
        }
        
        $this->get('session')->setFlash('success', 'Organisatie verwijderd.');
        return $this->redirect($this->generateUrl('agrocycle_admin_organisation_index')); 
       
    }
    
    
}
