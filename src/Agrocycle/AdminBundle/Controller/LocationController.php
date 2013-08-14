<?php

namespace Agrocycle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;

class LocationController extends Controller
{
    /**
     * @Route("/admin/locations")

     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('AgrocycleAgrocycleBundle:Location');
        $locations = $repository->findAll();
        return $this->render('AgrocycleAdminBundle:Locations:index.html.twig', array('locations' => $locations));
    }
    
    /**
     * @Route("/admin/locations/create/")

     */
    public function createAction(Request $request)
    {
        $location = new \Agrocycle\AgrocycleBundle\Entity\Location();

        $form = $this->createFormBuilder($location)
            ->add('address', 'text', array('label' => 'Straatnaam'))
            ->add('number', 'text', array('label' => 'Nummer'))
            ->add('postcode', 'text', array('label' => 'Postcode'))
            ->add('city', 'text', array('label' => 'Stad'))
            ->add('country', 'choice', array(
                'label' => 'Land',
                'expanded' => false,
                'choices' => array(
                    'België'        => 'België',
                    'Nederland'  => 'Nederland',
                    'Verenigd Koninkrijk' => 'Verenigd Koninkrijk',
                    'Duitsland' => 'Duitsland',
                    'Frankrijk' => 'Frankrijk',
                    'Spanje'    => 'Spanje',
                    'Italië'    => 'Italië'
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
                    
                    $geocoder = $this->get('ivory_google_map.geocoder');
                    $results = $geocoder->geocode($location->__toString())->getResults();
                    $results = array_shift($results);
                    
                    $location->setLattitude($results->getGeometry()->getLocation()->getLatitude());
                    $location->setLongitude($results->getGeometry()->getLocation()->getLongitude());

                    $em->persist($location);
                    $em->flush(); 
                    
                } catch (\PDOException $e) {
                    
                    return $this->createAction();
                    
                }
               
                 $this->get('session')->setFlash('success', 'Locatie aangemaakt.');
                 return $this->redirect($this->generateUrl('agrocycle_admin_location_index')); 
            }
        }

 
        return $this->render('AgrocycleAdminBundle:Locations:create.html.twig', array('form' => $form->createView()));
    }
    
    /**
     * @Route("/admin/locations/edit/{id}")

     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        if ($id)
        {
            $entity = $em->getRepository('AgrocycleAgrocycleBundle:Location')->find($id);
            if( !$entity )
            {
                throw $this->createNotFoundException('Er is geen locatie met die locatie id.');
            }
        }
        
        $form = $this->createFormBuilder($entity)
            ->add('address', 'text', array('label' => 'Straatnaam'))
            ->add('number', 'text', array('label' => 'Nummer'))
            ->add('postcode', 'text', array('label' => 'Postcode'))
            ->add('city', 'text', array('label' => 'Stad'))
            ->add('country', 'choice', array(
                'label' => 'Land',
                'expanded' => false,
                'choices' => array(
                    'België'        => 'België',
                    'Nederland'  => 'Nederland',
                    'Verenigd Koninkrijk' => 'Verenigd Koninkrijk',
                    'Duitsland' => 'Duitsland',
                    'Frankrijk' => 'Frankrijk',
                    'Spanje'    => 'Spanje',
                    'Italië'    => 'Italië'
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
                    $geocoder = $this->get('ivory_google_map.geocoder');
                    $results = $geocoder->geocode($entity->getAddress(). ' ' . $entity->getNumber(). ' ' .$entity->getPostcode() . ' ' . $entity->getCity() . ', ' . $entity->getCountry())->getResults();
                    $results = array_shift($results);
                    
                    $entity->setLattitude($results->getGeometry()->getLocation()->getLatitude());
                    $entity->setLongitude($results->getGeometry()->getLocation()->getLongitude());
                    
                    $em->persist($entity);
                    $em->flush(); 
                    
                } catch (\PDOException $e) {
                    
                    return $this->editAction($id);
                    
                }
               
                 $this->get('session')->setFlash('success', 'Locatie aangepast');
                 return $this->redirect($this->generateUrl('agrocycle_admin_location_index')); 
            }
        }
        
       return $this->render('AgrocycleAdminBundle:Locations:edit.html.twig', array('location' => $entity, 'form' => $form->createView()));
       
    }
    
    /**
     *@Route("/admin/locations/delete/{id}") 
     */
    public function deleteAction($id) {
          
        $entity = $this->getDoctrine()->getManager()->getRepository('AgrocycleAgrocycleBundle:Location')->find($id);
        if(!$entity)
        {
            throw $this->createNotFoundException('Deze locatie kon niet gevonden worden');
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
          $this->get('session')->setFlash('warning', 'Er is geen locatie met die locatie-id.');
          return $this->redirect($this->generateUrl('agrocycle_admin_location_index'));
        }
        
        $this->get('session')->setFlash('success', 'Locatie verwijderd.');
        return $this->redirect($this->generateUrl('agrocycle_admin_location_index')); 
       
    }
    
    
}
