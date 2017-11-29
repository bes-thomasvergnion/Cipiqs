<?php

namespace TV\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TV\CongresBundle\Entity\Image;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AdminController extends Controller
{
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function dashboardAction()
    {
        $congres = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVCongresBundle:Congres')
            ->findAll()
        ;
        $users = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVUserBundle:User')
            ->getUsersCount()
        ;
        $newCongres = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVCongresBundle:Congres')
            ->getNewCongres()
        ;
        
        return $this->render('TVUserBundle:Admin:dashboard.html.twig', array(
            'newCongres' => $newCongres,
            'congres' => $congres,
            'users' => $users,
        ));
    }
    
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function congresAction($page)
    {
        if($page<1){
            throw $this->createNotFoundException("La page ".$page." n'existe pas");
        }
        
        $count = 0;
        $nbPerPage = 20;
        
        $listCongres = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVCongresBundle:Congres')
            ->listCongres($page, $nbPerPage)
        ;
        $newCongres = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVCongresBundle:Congres')
            ->getNewCongres()
        ;
        
        $nbPages = ceil(count($listCongres)/$nbPerPage);
        
        if($page>$nbPages && $page<0){
            throw $this->createNotFoundException("La page ".$page." n'existe pas");
        }
        
        return $this->render('TVUserBundle:Admin:congres.html.twig', array(
            'listCongres' => $listCongres,
            'newCongres' => $newCongres,
            'nbPages' => $nbPages,
            'page' => $page,
            'count' => $count
        ));
    }
    
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function brouillonAction($page)
    {
        if($page<1){
            throw $this->createNotFoundException("La page ".$page." n'existe pas");
        }
        
        $count = 0;
        $nbPerPage = 20;
        
        $listCongres = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVCongresBundle:Congres')
            ->listBrouillonCongres($page, $nbPerPage)
        ;
        
        $nbPages = ceil(count($listCongres)/$nbPerPage);
        
        if($page>$nbPages && $page<0){
            throw $this->createNotFoundException("La page ".$page." n'existe pas");
        }
        
        return $this->render('TVUserBundle:Admin:brouillons.html.twig', array(
            'listCongres' => $listCongres,
            'nbPages' => $nbPages,
            'page' => $page,
            'count' => $count
        ));
    }
    
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function imagesAction(Request $request)
    {
        $image = new Image();
        $listImages = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVCongresBundle:Image')
            ->listImages()
        ;

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Image bien enregistrée');
            return $this->redirectToRoute('tv_user_admin_images');
        }
        
        return $this->render('TVUserBundle:Admin:gallery.html.twig', array(
            'listImages' => $listImages
        ));
    }
    
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function membersRegistredToCongressAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $congres = $em->getRepository('TVCongresBundle:Congres')->find($id);
        $count = 0;

        $registrations = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVCongresBundle:CongressRegistration')
            ->listCongressRegistration($congres)
        ;
        return $this->render('TVUserBundle:Admin:members_registred_to_congress.html.twig', array(
            'congres' => $congres,
            'registrations' => $registrations,
            'count' => $count
        ));
    }
    
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function exportListAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $congres = $em->getRepository('TVCongresBundle:Congres')->find($id);
        $count = 0;
        $registrations = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVCongresBundle:CongressRegistration')
            ->listCongressRegistration($congres)
        ;
        
        $response = $this->render('TVUserBundle:Admin:export.csv.twig', array(
            'congres' => $congres,
            'registrations' => $registrations,
            'count' => $count
        ));
        
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv');
        $response->setCharset('ISO-8859-1');
        $response->headers->set('Content-Disposition', 'attachment; filename="export.csv"');
        $response->headers->set('Content-Transfer-Encoding', 'binary');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');
        
        return $response;

    }
}
