<?php

namespace TV\CongresBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TV\CongresBundle\Entity\Congres;
use TV\CongresBundle\Entity\CongressRegistration;
use TV\CongresBundle\Entity\Image;
use TV\CongresBundle\Form\CongresType;
use TV\CongresBundle\Form\CongressRegistrationType;
use TV\CongresBundle\Form\ImageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CongresController extends Controller
{
    public function indexAction($page)
    {
        if($page<1){
            throw $this->createNotFoundException("La page ".$page." n'existe pas");
        }
        
        $count = 0;
        $nbPerPage = 5;
        
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
        
        if($page>$nbPages && $page!= 1){
            throw $this->createNotFoundException("La page ".$page." n'existe pas");
        }
        
        return $this->render('TVCongresBundle:Congres:index.html.twig', array(
            'listCongres' => $listCongres,
            'newCongres' => $newCongres,
            'nbPages' => $nbPages,
            'page' => $page,
            'count' => $count
        ));
    }
    
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $congres = $em->getRepository('TVCongresBundle:Congres')->find($id);
        $count = 0;
        $listCongressRegistration = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVCongresBundle:CongressRegistration')
            ->listCongressRegistration($congres)
        ;
        
        if(null===$congres){
            throw new NotFoundHttpException("Le congrès d'id ".$id. "n'existe pas.");
        }
        
        return $this->render('TVCongresBundle:Congres:view.html.twig', array(
            'congres' => $congres,
            'listCongressRegistration' => $listCongressRegistration,
            'count' => $count
        ));
    }
    
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function addAction(Request $request)
    {      
        $congres = new Congres();
        $image = new Image();
        $title = 'Ajouter un nouveau congrès';
        $listImages = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVCongresBundle:Image')
            ->listImages()
        ;
        $newCongres = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVCongresBundle:Congres')
            ->getNewCongres()
        ;
        
        $form = $this->get('form.factory')->create(CongresType::class, $congres);
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            if(isset($_POST['image'])){
                $id = $_POST['image'];
                $image = $em->getRepository('TVCongresBundle:Image')->find($id);
                $congres->setImage($image);
            }
            
            $em->persist($congres);
            if(isset($newCongres)){
                $state = $congres->getState();
                $stateId = $state->getId();
                if($stateId === 2){
                    $stateOld = $this->getDoctrine()
                        ->getManager()
                        ->getRepository('TVCongresBundle:State')
                        ->getStateOld()
                    ;
                    $newCongres->setState($stateOld);
                }
            }
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Congrès bien enregistré');
            return $this->redirectToRoute('tv_congres_index');
        }
        
        return $this->render('TVCongresBundle:Congres:add.html.twig', array(
            'form' => $form->createView(),
            'listImages' => $listImages,
            'title' => $title
        ));
    }
    
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction($id, Request $request)
    {
        $title = 'Modifier congrès';
        $em = $this->getDoctrine()->getManager();
        $congres = $em->getRepository('TVCongresBundle:Congres')->find($id);
        
        $listImages = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVCongresBundle:Image')
            ->listImages()
        ;
        $newCongres = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVCongresBundle:Congres')
            ->getNewCongres()
        ;
        
        if(null===$congres){
            throw new NotFoundHttpException("Le congres d'id ".$id." n'existe pas");
        }
        
        $form = $this->get('form.factory')->create(CongresType::class, $congres);
        
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
//            $id = $_POST['image'];
//            $image = $em->getRepository('TVCongresBundle:Image')->find($id);
//            $congres->setImage($image);
            if(isset($newCongres) && $newCongres != $congres){
                $state = $congres->getState();
                $stateId = $state->getId();
                if($stateId === 2){
                    $stateOld = $this->getDoctrine()
                        ->getManager()
                        ->getRepository('TVCongresBundle:State')
                        ->getStateOld()
                    ;
                    $newCongres->setState($stateOld);
                }
            }
            $em->flush();
            $request->getSession()->getFlashbag()->add('notice', 'Congrès bien modifié');
            return $this->redirectToRoute('tv_congres_view', array('id' => $congres->getId()));
        }
        
        return $this->render('TVCongresBundle:Congres:edit.html.twig', array(
            'congres' => $congres,
            'form' => $form->createView(),
            'listImages' => $listImages,
            'title' => $title
        ));
    }
    
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $congres = $em->getRepository('TVCongresBundle:Congres')->find($id);
        
        if(null === $congres){
            throw new NotFoundHttpException("Le congres d'id ".$id." n'existe pas.");
        }
        
        $form = $this->get('form.factory')->create();
        
        if($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
                $em->remove($congres);
                $em->flush();
                $request->getSession()->getFlashBag()->add('info', "L'annonce a bien été supprimé.");
                return $this->redirectToRoute('tv_user_admin_congres');
            }
            return $this->render('TVCongresBundle:Congres:delete.html.twig', array(
                'congres' => $congres,
                'form' => $form->createView(),
            ));
        }
        else{
            return $this->redirectToRoute('tv_congres_view', array('id' => $congres->getId()));
        }       
    }
    
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function registerAction($id, Request $request)
    {
        $congressRegistration = new CongressRegistration();
        
        $em = $this->getDoctrine()->getManager();
        $congres = $em->getRepository('TVCongresBundle:Congres')->find($id);
        $user = $this->getUser();
        $totalAmount = 0;
        $form = $this->get('form.factory')->create(CongressRegistrationType::class, $congressRegistration);
        
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $congressRegistration->setUser($user);
            $congres->addRegisteredMember($user);
            $congressRegistration->setCongres($congres);
            $chosenDay = $congressRegistration->getChosenDay();
            $event = $congressRegistration->getEvent();
            switch($chosenDay){
                case "Inscription au deux jours":
                    $totalAmount = $congres->getPriceBoth();
                    break;
                case "Inscription au jour 1":
                    $totalAmount = $congres->getPriceDay1();
                    break;
                case "Inscription au jour 2":
                    $totalAmount = $congres->getPriceDay2();
                    break;
                case "Inscription au deux jours en groupe":
                    $totalAmount = $congres->getGroupPrice();
                    break;
                default:
                    $totalAmount = $congres->getPriceBoth();
            }
            if($event === true){
                $totalAmount = $totalAmount + $congres->getEventPrice();
            }
            $congressRegistration->setTotalAmount($totalAmount);
            $em->persist($congressRegistration);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', "Vous êtes bien inscrit au congrès.");
            return $this->redirectToRoute('tv_congres_view', array('id' => $congres->getId()));
        }
        return $this->render('TVCongresBundle:Congres:register.html.twig', array(
            'congres' => $congres,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function alreadyRegisteredAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $congres = $em->getRepository('TVCongresBundle:Congres')->find($id);
        $user = $this->getUser();
        $registration = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVCongresBundle:CongressRegistration')
            ->yourRegistration($congres, $user)
        ;
        return $this->render('TVCongresBundle:Congres:registered.html.twig', array(
            'congres' => $congres,
            'registration' => $registration,
        ));
        
        
    }
}
