<?php

namespace IPMonitor\MonitorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
*
 * @Route("/admin/ip-monitor")
 */

class DefaultController extends Controller
{
    /**
     * @Route("/", name="ipMonitor")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ips = $em->getRepository('IPMonitorMonitorBundle:IP')->findAll();

        return [
            'ips' => count($ips)
        ];
    }

    /**
     * @Route("/result", name="ipMonitor_result")

     */
    public function testIpsAction(){

        $em = $this->getDoctrine()->getManager();

        $ips = $em->getRepository('IPMonitorMonitorBundle:IP')->findAll();

        $referencia = $em->getRepository('IPMonitorMonitorBundle:IP')->findOneBy(['referencia' => 1]);


        // Iniciamos o "contador"
        list($usec, $sec) = explode(' ', microtime());
        $script_start = (float) $sec + (float) $usec;

        //Testa referencia
        exec("ping {$referencia->getIp()} -c 3", $saida, $retorno);
        $mediaReferencia = 0;
        if(count($saida)) {
            $arrResultReferencia = explode('/', $saida[7]);
            $mediaReferencia = $arrResultReferencia[4];
        }


        $arrResults = [];
        foreach($ips as $ip) {
            exec("ping {$ip->getIp()} -c 3", $saida, $retorno);

            if (count($saida)) {
                $arrResult = explode('/', $saida[7]);
                $arrPack = explode(',', $saida[6]);
                $pacotesRecebidos = (int) substr($arrPack[1],1,1);
                $media = $arrResult[4];
                //echo $media."ms | ";
                //echo $pacotesRecebidos." pacotes recebidos / 3 pacotes transmitidos<br>";

                $arrResults[] = [
                    'ip' => $ip->getIp(),
                    'nome' => $ip->getNome(),
                    'perda' => 3 - $pacotesRecebidos,
                    'media' => $media,
                    'erro' => false
                ];
                $saida = [];
            } else {
                $arrResults[] = [
                    'ip' => $ip->getIp(),
                    'nome' => $ip->getNome(),
                    'perda' => 3,
                    'media' => 0,
                    'erro' => true
                ];
            }
        }

        // Terminamos o "contador" e exibimos
        list($usec, $sec) = explode(' ', microtime());
        $script_end = (float) $sec + (float) $usec;
        $elapsed_time = round($script_end - $script_start, 5);

        $response = "";
        $situacao = '<span class="label label-danger">Verificar</span>';
        foreach($arrResults as $res) {
            $diferenca = $res['media'] - $mediaReferencia;
            $situacao = ($diferenca > 40) ? '<span class="label label-danger">Verificar</span>' : '<span class="label label-success">Normal</span>';
            $response .= '<tr>';
            $response .= "<td>".$res['nome']."</td>";
            $response .= "<td>".$res['ip']."</td>";
            $response .= "<td>".$res['media']."</td>";
            $response .= "<td>".$res['perda']."</td>";
            $response .= "<td>". $situacao ."</td>";
            $response .='</tr>';
        }

        $data = [
            'response' => $response,
            'time' => $elapsed_time
        ];
        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}
