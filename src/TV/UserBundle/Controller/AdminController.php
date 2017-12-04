<?php

namespace TV\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function dashboardAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $congres = $em->getRepository('TVCongresBundle:Congres')->findAll();       
        $users = $em->getRepository('TVUserBundle:User')->getUsersCount();       
        $newCongres = $em->getRepository('TVCongresBundle:Congres')->getNewCongres();     
        $listCongressRegistration = $em->getRepository('TVCongresBundle:CongressRegistration')->listCongressRegistration($newCongres);
        $count = 0;
        
        return $this->render('TVUserBundle:Admin:dashboard.html.twig', array(
            'newCongres' => $newCongres,
            'congres' => $congres,
            'users' => $users,
            'listCongressRegistration' => $listCongressRegistration,
            'count' => $count
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
        
        $em = $this->getDoctrine()->getManager();
        $listCongres = $em->getRepository('TVCongresBundle:Congres')->listCongres($page, $nbPerPage);
        $newCongres = $em->getRepository('TVCongresBundle:Congres')->getNewCongres();
        
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
    public function membersRegistredToCongressAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $congres = $em->getRepository('TVCongresBundle:Congres')->find($id);
        $registrations = $em->getRepository('TVCongresBundle:CongressRegistration')->listCongressRegistration($congres);
        $count = 0;
        
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
        
        $response = new StreamedResponse();
        $response->setCallback(function() use($registrations, $count, $congres){
            $handle = fopen('php://output','w+');
            fputs($handle, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF)));
            fputcsv($handle, array(
                'N°',
                'Nom',
                'Prénom',
                'Profession',
                'Institution',
                'Type d\'inscription',
                'Participation à l\'événement',
                'Montant à payer',
            ),';');
 
            foreach ($registrations as $registration)
            {
                $count ++;
                $user = $registration->getUser();
                $event = $registration->getEvent();
                if($event === true){$eventParticipation = 'oui';}
                else{$eventParticipation = 'non';}
                
                $chosenDay = $registration->getChosenDay();
                $date1 = $congres->getDateDay1();
                $date1 = date("d/m/Y");
                $date2 = $congres->getDateDay2();
                $date2 = date("d/m/Y");
                if($chosenDay === 'Inscription au jour 1'){$day = "Inscription pour le ".$date1;}
                else if($chosenDay === 'Inscription au jour 2'){$day = "Inscription pour le ".$date2;}
                else if($chosenDay === 'Inscription aux deux jours'){$day = "Inscription pour le ".$date1." et le ".$date2;}
                else if($chosenDay === 'Inscription aux deux jours en groupe'){$day = "Inscription pour le ".$date1." et le ".$date2." en groupe";}
                fputcsv($handle,array(
                    $count,
                    $user->getLastName(),
                    $user->getFirstName(),
                    $user->getProfession(),
                    $user->getInstitution(),
                    $day,
                    $eventParticipation,
                    $registration->getTotalAmount().' €',
                ),';');
            }
            fclose($handle);
        });
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition','attachment; filename="export.csv"');
        return $response;
    }
}
