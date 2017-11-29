<?php

namespace TV\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TV\UserBundle\Form\UserEditType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class UserController extends Controller
{
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction($page)
    {
        if($page < 1){
            throw $this->createNotFoundException("La page ".$page." n'existe pas");
        }        
        $nbPerPage = 30;
        $count = 0;
        $listUsers = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVUserBundle:User')
            ->getUsers($page, $nbPerPage)
        ;        
        $nbPages = ceil(count($listUsers)/$nbPerPage);
        if($page>$nbPages && $page!= 1){
            throw $this->createNotFoundException("La page ".$page." n'existe pas");
        }
        return $this->render('TVUserBundle:Admin:users.html.twig', array(
            'listUsers' => $listUsers,
            'nbPages' => $nbPages,
            'page' => $page,
            'count' => $count
        ));
    }
    
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function bannishAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();       
        $user = $em->getRepository('TVUserBundle:User')->find($id);
        
        $form = $this->get('form.factory')->create();
        
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $user->setEnabled(false);
            $em->flush();
            
            return $this->redirectToRoute('tv_user_admin_users');
        }
        return $this->render('TVUserBundle:User:bannish.html.twig', array(
            'user' => $user,
            'form' => $form->createView()
        ));
    }
    
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('TVUserBundle:User')->find($id);
        
        if(null===$user){
            throw new NotFoundHttpException("L'utilisateur d'id ".$id. "n'existe pas.");
        }
        
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        
        if($currentUser == $user || $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            return $this->render('TVUserBundle:User:view.html.twig', array(
                'user' => $user,
            ));
        }
        else{
            return $this->redirectToRoute('tv_cipiqs_homepage');
        }
    }
    
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('TVUserBundle:User')->find($id);
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        
        if(null===$user){
            throw new NotFoundHttpException("L'utilisateur d'id ".$id. "n'existe pas.");
        }

        if($currentUser == $user || $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            $form = $this->get('form.factory')->create(UserEditType::class, $user);

            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'Utilisateur modifié.');
                return $this->redirectToRoute('tv_user_view', array('id' => $user->getId()));
            }

            return $this->render('TVUserBundle:User:edit.html.twig', array(
                'user' => $user,
                'form'   => $form->createView(),
            ));
        }
        else{
            return $this->redirectToRoute('tv_cipiqs_homepage');
        }
    }
}
