<?php

namespace Agrocycle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/admin/users")

     */
    public function indexAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        return $this->render('AgrocycleAdminBundle:Users:index.html.twig', array('users' => $users));
    }
    
    /**
     * @Route("/admin/users/create/")

     */
    public function createAction(Request $request)
    {
        $user = new \Agrocycle\AgrocycleBundle\Entity\User();

        $form = $this->createFormBuilder($user)
            ->add('firstName', 'text', array('label' => 'Voornaam'))
            ->add('lastName', 'text', array('label' => 'Familienaam'))
            ->add('email', 'email')
            ->add('username', 'text', array('label' => 'Gebruikersnaam'))
            ->add('roles', 'choice', array(
                'label' => 'Gebruikersrol',
                'expanded' => false,
                'multiple' => true,
                'choices' => array(
                    'ROLE_ADMIN'        => 'Administrator',
                    'ROLE_SUPER_ADMIN'  => 'Super Administrator'
                )
            ))
            ->getForm();
        
        if ($request->isMethod('POST'))
        {
            $form->bind($request);
            
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $user->setPlainPassword('thiswillchange');
                $user->setEnabled(true);
              
                try 
                {
                    $em->persist($user);
                    $em->flush(); 
                    
                } catch (\PDOException $e) {
                    
                    return $this->createUsersAction();
                    
                }
               
                 $this->get('session')->setFlash('success', 'Gebruiker aangemaakt.');
                 return $this->redirect($this->generateUrl('agrocycle_admin_user_index')); 
            }
        }

 
        return $this->render('AgrocycleAdminBundle:Users:create.html.twig', array('form' => $form->createView()));
    }
    
    /**
     * @Route("/admin/users/edit/{id}")

     */
    public function editAction($id, Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id' => $id));
        
        if(!$user)
        {
          $this->get('session')->setFlash('warning', 'Er is geen gebruiker met die gebruikers-id.');
          return $this->redirect($this->generateUrl('admin_users'));
        }
       
        $form = $this->createFormBuilder($user)
        ->add('firstName', 'text', array('label' => 'Voornaam'))
        ->add('lastName', 'text', array('label' => 'Familienaam'))
        ->add('email', 'email')
        ->add('username', 'text', array('label' => 'Gebruikersnaam'))
        ->add('roles', 'choice', array(
            'label' => 'Gebruikersrol',
            'expanded' => false,
            'multiple' => true,
            'choices' => array(
                'ROLE_ADMIN'        => 'Administrator',
                'ROLE_SUPER_ADMIN'  => 'Super Administrator'
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
                    $em->persist($user);
                    $em->flush(); 
                    
                } catch (\PDOException $e) {
                    
                    return $this->editAction($id);
                    
                }
               
                 $this->get('session')->setFlash('success', 'Gebruiker aangepast');
                 return $this->redirect($this->generateUrl('agrocycle_admin_user_index')); 
            }
        }
        
       return $this->render('AgrocycleAdminBundle:Users:edit.html.twig', array('user' => $user, 'form' => $form->createView()));
       
    }
    
    /**
     *@Route("/admin/users/delete/{id}") 
     */
    public function deleteAction($id) {
          
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id' => $id));
        
        if($user)
        {
          $em = $this->getDoctrine()->getManager();
          $em->remove($user);
          
          try
          {
              $em->flush();
              
          } catch(\PDOException $e) 
          
          {
                  
          }
          
        }
        
        else {
          $this->get('session')->setFlash('warning', 'Er is geen gebruiker met die gebruikers-id.');
          return $this->redirect($this->generateUrl('agrocycle_admin_user_index'));
        }
        
        $this->get('session')->setFlash('success', 'Gebruiker verwijderd.');
        return $this->redirect($this->generateUrl('agrocycle_admin_user_index')); 
       
    }
    
    
}
