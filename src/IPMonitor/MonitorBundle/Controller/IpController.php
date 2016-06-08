<?php

namespace IPMonitor\MonitorBundle\Controller;

use IPMonitor\MonitorBundle\Entity\IP;
use IPMonitor\MonitorBundle\Form\IpType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 *
 * @Route("/admin/ip-monitor")
 */

class IpController extends Controller
{
    /**
     * @Route("/list", name="ipMonitor_list")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ips = $em->getRepository('IPMonitorMonitorBundle:IP')->findAll();

        return [
            'ips' => $ips
        ];
    }

    /**
     * @Route("/new", name="ipMonitor_new")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function newAction(Request $request)
    {
        $ip = new IP();
        $form = $this->createForm(new IpType(), $ip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ip);
            $em->flush();

            return $this->redirectToRoute('ipMonitor_list');
        }

        return array(
            'form' => $form->createView(),
        );
    }


    /**
     *
     * @Route("/{id}/edit", name="ipMonitor_edit")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function editAction(Request $request, IP $ip)
    {
        $editForm = $this->createForm(new IpType(), $ip);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ip);
            $em->flush();

            return $this->redirectToRoute('ipMonitor_list');
        }

        return array(
            'ip' => $ip,
            'edit_form' => $editForm->createView()
        );
    }

    /**
     * Deletes a Localidade entity.
     *
     * @Route("/{id}/delete", name="ipMonitor_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, IP $ip)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($ip);
        $em->flush();

        return $this->redirectToRoute('ipMonitor_list');
    }
}

