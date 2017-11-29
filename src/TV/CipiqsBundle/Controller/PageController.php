<?php

namespace TV\CipiqsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $congres = $em->getRepository('TVCongresBundle:Congres')->getNewCongres();
        
        return $this->render('TVCipiqsBundle:Page:index.html.twig', array(
            'congres' => $congres
        ));
    }
    
    public function pebnAction()
    {
        return $this->render('TVCipiqsBundle:Page:pebn.html.twig');
    }
    
    public function statusAction()
    {
        return $this->render('TVCipiqsBundle:Page:status.html.twig');
    }
    
    public function structureAction()
    {
        return $this->render('TVCipiqsBundle:Page:structure.html.twig');
    }
    
    public function activitiesAction()
    {
        return $this->render('TVCipiqsBundle:Page:activities.html.twig');
    }

    public function contactAction(Request $request)
    {
        $form = $this->createForm('TV\CipiqsBundle\Form\ContactType',null,array(
            'action' => $this->generateUrl('tv_cipiqs_contact'),
            'method' => 'POST'
        ));

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if($form->isValid()){
                if($this->sendEmail($form->getData())){
                    return $this->redirectToRoute('tv_cipiqs_homepage');
                }
                else{
                    var_dump("Errooooor :(");
                }
            }
        }

        return $this->render('TVCipiqsBundle:Page:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

    private function sendEmail($data){
        $myappContactMail = 'thomasvergnion@gmail.com';
        $myappContactPassword = 'vwkppvdhgtencubx';

        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')
            ->setUsername($myappContactMail)
            ->setPassword($myappContactPassword);

        $mailer = \Swift_Mailer::newInstance($transport);
        
        $message = \Swift_Message::newInstance($data["subject"])
        ->setFrom(array($myappContactMail => $data["name"]))
        ->setTo(array(
            $myappContactMail => $myappContactMail
        ))
        ->setBody($data["message"]);
        
        return $mailer->send($message);
    }
}
