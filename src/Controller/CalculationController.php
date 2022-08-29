<?php

namespace App\Controller;

use App\Entity\VatMaster;
use App\Entity\Demo;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;


class CalculationController extends AbstractController
{
    /**
     * @Route("/", name="app_calculation")
     */
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/create")
     */    
    public function create(Request $request,ManagerRegistry $doctrine)
    {
               
        $input=json_decode($request->getContent());

        $entityManager = $doctrine->getManager();
        
        $connection = $this->getDoctrine()->getManager()->getConnection();
        
        $vatMaster = new VatMaster();

        if($input->type == 'Include'){

            $rate=floatval($input->rangeVat)/100;
            $inputAmount=  floatval($input->inputAmount);
            $vat=$inputAmount*$rate;
            $grossAmount=$inputAmount+$vat;

            $query = "
              INSERT INTO vat_master (
                  input_amnt,
                  vat_amnt,
                  vat_type,
                  vat,
                  net_amount,
                  vat_per
              ) VALUES (
                  :input_amnt,
                  :vat_amnt,
                  :vat_type,
                  :vat,
                  :net_amount,
                  :vat_per                  

              )
            ";

            $statement = $connection->prepare($query);


            $statement->bindValue("input_amnt", $inputAmount, \PDO::PARAM_STR);
            $statement->bindValue("vat_amnt", $vat, \PDO::PARAM_STR);
            $statement->bindValue("vat_type", $input->type, \PDO::PARAM_STR);
            $statement->bindValue("vat", $grossAmount, \PDO::PARAM_STR);
            $statement->bindValue("net_amount", number_format((float)$grossAmount, 2, '.', ''), \PDO::PARAM_STR);
            $statement->bindValue("vat_per", $input->rangeVat, \PDO::PARAM_STR);

            $statement->execute();            
            /*
            
            persist error occured;

            $vatMaster->setInputAmnt=floatval($inputAmount);
            $vatMaster->setVatAmnt=$rate;
            $vatMaster->setVatType=$input->type;
            $vatMaster->setVat=$grossAmount;
            $vatMaster->setNetAmount=number_format((float)$grossAmount, 2, '.', '');       
            $vatMaster->setVatPer=$input->rangeVat.'%';
            
            $entityManager->persist($vatMaster);
            

            $entityManager->flush();*/
          

        } else {

            $rangeVat = $input->rangeVat;            
            $rate = floatval($rangeVat)/100;
            $inputAmount=$input->inputAmount;
            $findVat=floatval($inputAmount)/(1+floatval($rate));
            $excludeVat=abs(($inputAmount-$findVat)*(-1));

            $query = "
              INSERT INTO vat_master (
                  input_amnt,
                  vat_amnt,
                  vat_type,
                  vat,
                  net_amount,
                  vat_per
              ) VALUES (
                  :input_amnt,
                  :vat_amnt,
                  :vat_type,
                  :vat,
                  :net_amount,
                  :vat_per                  

              )
            ";

            $statement = $connection->prepare($query);


            $statement->bindValue("input_amnt", $inputAmount, \PDO::PARAM_STR);
            $statement->bindValue("vat_amnt", number_format((float)$excludeVat, 2, '.', ''), \PDO::PARAM_STR);
            $statement->bindValue("vat_type", $input->type, \PDO::PARAM_STR);
            $statement->bindValue("vat", $inputAmount, \PDO::PARAM_STR);
            $statement->bindValue("net_amount", number_format((float)$inputAmount, 2, '.', ''), \PDO::PARAM_STR);
            $statement->bindValue("vat_per", $input->rangeVat, \PDO::PARAM_STR);

            $statement->execute();             

        }

        // insert to db

        

        //dd($input);
        //return $this->render('index.html.twig');

        return new Response('Saved new product with id');
    }

    /**
     * @Route("/export")
     */    
    public function export(Request $request,ManagerRegistry $doctrine)
    {

        $em = $doctrine->getManager();
        $em->getConnection()->connect();
        $connected = $em->getConnection()->isConnected();

        $events = $em->getRepository(VatMaster::class)
        ->getAllTableData();
        $rows = array();

        $data=array('Sl.NO','Amount','VAT Amount','VAT Type','VAT(%)','Net Amount');
        $rows[] = implode(',', $data);

        foreach ($events as $key => $value) {

            $data = array($key+1,$value->getInputAmnt(),$value->getVatAmnt(),$value->getVatType(),$value->getVatPer(),$value->getNetAmount());

            $rows[] = implode(',', $data);
        }

        $content = implode("\n", $rows); 
        $response = new Response($content);
        $response->headers->set('Content-Type', 'text/csv');
        
        return  $response;
    
    }
}
