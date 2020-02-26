<?php

namespace TechBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityRepository\QueryBuilder;

use Symfony\Component\HttpFoundation\Response;
use TechBundle\Entity\Evenement;
use TechBundle\Entity\Reservation;
use TechBundle\Entity\User;
use TechBundle\Form\EvenementType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Mgilet\NotificationBundle\Annotation\Notifiable;
use Mgilet\NotificationBundle\NotifiableInterface;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Tech/Default/index.html.twig');
    }
    public function READ2Action(Request $request)
    {

        $em = $this->getDoctrine()->getManager();


        $clubs=$this->getDoctrine()->getRepository(Evenement::class)->findAll();
        $queryBuilder = $em->getRepository('TechBundle:Evenement')->createQueryBuilder('bp');

        $queryBuilder->orderBy("bp.idEvent", 'DESC');
        $clubs=$queryBuilder->getQuery();



        $clubs  = $this->get('knp_paginator')->paginate(
            $clubs,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            2/*nbre d'éléments par page*/
        );



        return $this->render ("@Tech/Default/index.html.twig",array('clubs'=>$clubs));
    }


    public function homepageAction()
    {$a=1;
        $membre=$this->container->get('security.token_storage')->getToken()->getUser();
       if( $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))

        return $this->render('@Tech/Default/admin.html.twig');
else
    return $this->render('@Tech/Default/home.html.twig',array('member'=>$a));

    }

    public function crudeAction()
    {


        return $this->render ("@Tech/Default/crud_e.html.twig");
    }

    public function showeAction(Request $request)
    {
        $membre=$this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $em = $this->getDoctrine()->getManager();

        $evenements = $em->getRepository('TechBundle:Evenement')->findAll();




        return $this->render('@Tech/Default/crud_e.html.twig', array(
            'evenements' => $evenements,'membre'=>$membre
        ));


    }


    public function supprimerevAction($id) {


        $em = $this->getDoctrine()->getManager();
        $club = $em->getRepository(Evenement::class)->find($id);
        $em->remove($club);
        $em->flush();
        return $this->redirectToRoute("showeeeee");
    }
    public function modifierevAction($id , Request $request) {
        $club = new Evenement();
        $em = $this->getDoctrine()->getManager();
        $club = $em->getRepository(Evenement::class)->find($id);
        $image=$club->getImageEvent();
        $club->setImageEvent("az");
        $form = $this->createForm(EvenementType::class,$club);

        $form = $form->handleRequest($request);

        if ($form->isSubmitted())
        {

            if ($club->getImageEvent()=="az" && $request->files->get('techbundle_evenement')['imageEvent']==null ) {

            $club->setImageEvent($image);
                $em->persist($club);
                $em->flush();
                return $this->redirectToRoute("showeeeee");

            }

            $file= $request->files->get('techbundle_evenement')['imageEvent'];
            $uploads_directory=$this->getParameter('uploads_directory');



            $imageEvent=$file->getClientoriginalName();

            $file->move($uploads_directory,$imageEvent);
//var_dump($file);
            $club->setImageEvent($imageEvent);



            $em->persist($club);
            $em->flush();
            return $this->redirectToRoute("showeeeee");
        }
        return $this->render('@Tech/Default/updateev.html.twig',array('form' => $form->createView(),'id'=>$club));


    }

    public function addeAction(Request $request){
        $membre=$this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $club = new Evenement();
        $reservation= new Reservation();

        $form = $this->createForm(EvenementType::class,$club);
        $form = $form->handleRequest($request);
        if ($form->isSubmitted()  && $form->isValid()) {

            $file= $request->files->get('techbundle_evenement')['imageEvent'];
            $uploads_directory=$this->getParameter('uploads_directory');


           // var_dump($file);
            $imageEvent=$file->getClientoriginalName();

            $em = $this->getDoctrine()->getManager();

            $file->move($uploads_directory,$imageEvent);
            $club->setImageEvent($imageEvent);
            $club->setIdUser($membre);
            $club->setNbrR(0);
            $em->persist($club);
            $em->flush();
            return $this->redirectToRoute("showeeeee");
        }
        return $this->render('@Tech/Default/adde.html.twig',array('form' => $form->createView()));
    }


    public function mapAction($id , Request $request){
//$a="9.968851, -10.151367";
        $club = new Evenement();
        $em = $this->getDoctrine()->getManager();
        $club = $em->getRepository(Evenement::class)->find($id);
        $form = $this->createForm(EvenementType::class,$club);
        $form = $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $em->persist($club);
            $em->flush();
            return $this->redirectToRoute("showeeeee");
        }

        return $this->render('@Tech/Default/map.html.twig',array('id'=>$club));
    }

    public function resAction($id , Request $request){
        $membre=$this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $club = new Evenement();
        $res= new Reservation();
        $em = $this->getDoctrine()->getManager();
        $club = $em->getRepository(Evenement::class)->find($id);

        $res1 = $em->getRepository(Reservation::class)->findByidUser( $membre );

$c=1;
        foreach($res1 as $a) {
            if($a->getIdEvent()==$id){
$c=2;

        }}
        if($c!=2){
            $c=1;
            $res->setIdEvent($id);
            $res->setIdUser($membre);
            $res->setEtatRes("en cours");
            $res->setDatedEvent($club->getDatedEvent());
            $res->setDatefEvent($club->getDatefEvent());
            $res->setTitreEvent($club->getTitreEvent());
            $res->setImageevent($club->getImageEvent());
            $club->setNbrR($club->getNbrR()+1);
            $em->persist($res);
            $em->flush();

        }
        else{ $message = "vous avez deja reservé cet Evenement";
            echo "<script type='text/javascript' class='alertr'  >alert('$message');</script>";
         //  return $this->redirectToRoute("tech_homepage1");

        }

        $res = $em->getRepository(Reservation::class)->findByidUser( $membre );

        $em->persist($club);
        $em->flush();

        return $this->render('@Tech/Default/reserv.html.twig',array('res'=>$res));
    }



    public function mesresAction(){
        $res= new Reservation();
        $em = $this->getDoctrine()->getManager();
        $membre=$this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $res = $em->getRepository(Reservation::class)->findByidUser( $membre );


        return $this->render('@Tech/Default/reserv.html.twig',array('res'=>$res));
    }
    public function RechercheevAction($name){
        $evt= new Evenement();
        $em = $this->getDoctrine()->getManager();

        $evt = $em->getRepository(Evenement::class)->findBytitreEvent( $name );


        return $this->render('@Tech/Default/reserv.html.twig',array('res'=>$evt));
    }

    public function searchParcellesAction(Request $request) {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizer, $encoders);

        $em = $this->getDoctrine()->getManager();

        if($request->isXmlHttpRequest()) {
            // To retrieve $_GET parameters do this $request->query->get('parameter');

            $typebeneficiaire = $request->request->get('typebeneficiaire');
            $beneficiaire = $request->request->get('beneficiaire');

            $parcelles = $em->getRepository(Evenement::class)->getParcelles($typebeneficiaire, $beneficiaire);

            $jsonContent = $serializer->serialize($parcelles, 'json');
            return $this->render('@Tech/Default/resultatr.html.twig',array('res'=>$jsonContent));

        }

        $titre=$request->get('reche');
        $evt = $em->getRepository(Evenement::class)->findBytitreEvent( $titre );
        return $this->render('@Tech/Default/index.html.twig',array('clubs'=>$evt));
    }


    public function chercherAction()
    {


        $connect = mysqli_connect("localhost", "root", "", "jardinenfant");
        $output = '';
        $a = '';

        if(isset($_POST["query"]))
        {
            $search = mysqli_real_escape_string($connect, $_POST["query"]);
            if(strlen($search)>0){
            $query = "
	SELECT * FROM evenement 
	WHERE Titre_Event LIKE '%".$search."%'
	OR categorie_Event LIKE '%".$search."%'
	
	";
        }
        else
        {
            $query = "
	SELECT * FROM evenement ORDER BY nbr_r DESC ";
        }
        $result = mysqli_query($connect, $query);

        if(mysqli_num_rows($result) > 0)
        {
            $output .= '<div class="table-responsive">
					<table class="table table bordered">
						<tr>
							<th>Titre</th>
							<th> Categories </th>
							<th> Reservations </th>
							
						</tr>';
            while($row = mysqli_fetch_array($result))
            {
                $output .= '
			 
	<tr> <td>	<a href="http://localhost/tech-event/web/app_dev.php/tech/map/'.$row["Id_Event"].'"	<td>'.$row["Titre_Event"].' </td> </a>
             <td>
             '.$row["categorie_Event"].' 
</td>
         <td>
         '.$row["nbr_r"].' 
</td>
              
               </tr>
			
			 
			
				
		
						
		';

            }
            echo $output;
        }
        else
        {
            echo 'Data Not Found';
        }

        return $this->render('@Tech/Default/chercher.html.twig'
        );
        }
    }

    public function supprimertAction($id,$ide) {

        $em = $this->getDoctrine()->getManager();
        $club = $em->getRepository(Reservation::class)->find($id);
        $res = $em->getRepository(Evenement::class)->find($ide);

        $message = "vous avez deja reservé cet Evenement";
        echo "<script type='text/javascript' class='alertr'  > alert('$message');

</script>";
        $res->setNbrR($res->getNbrR()-1);
        $em->persist($res);
        $em->flush();

        $em->remove($club);
        $em->flush();
        return $this->redirectToRoute("mesres");
    }

    public function tiketAction($id) {
        $membre=$this->container->get('security.token_storage')->getToken()->getUser()->getUsername();
        $em = $this->getDoctrine()->getManager();
        $tiket = $em->getRepository(Reservation::class)->find($id);


        return $this->render('@Tech/Default/tiket.html.twig',array('tiket'=>$tiket,'nom'=>$membre));
    }


    public function searchDBAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');





        $connect = mysqli_connect("localhost", "root", "", "jardinenfant");
        $output = '';
        if(isset($_POST["query"]))
        {
            $search = mysqli_real_escape_string($connect, $_POST["query"]);
            $query = "
	SELECT * FROM evenement 
	WHERE Titre_Event LIKE '%".$requestString."%'
	
	
	";
        }
        else
        {
            $query = "
	SELECT * FROM evenement";
        }
        $entities = mysqli_query($connect, $query);


     //   $entities =  $em->getRepository(Event::class)->findEntitiesByString($requestString);

        if(!$entities) {
            $result['entities']['error'] = "No results matche with your search ";
        } else {
            $result['entities'] = $this->getRealEntities($entities);
        }
        return new Response(json_encode($result));

    }

    public function getRealEntities($entities){
        foreach ($entities as $entity){
            foreach ($entity as $r ){
            $realEntities[51] = ["test","Capture.PNG"];
        }}
        return $realEntities;
    }


    public function reservationCardAction($id) {
        $username=$this->container->get('security.token_storage')->getToken()->getUser()->getUsername();
        $em = $this->getDoctrine()->getManager();
        $resCard = $em->getRepository(Reservation::class)->find($id)->getEventId();///get event for that


        return $this->render('@MahmoudEvent/HomeEvent/reservation.html.twig',array('event'=>$resCard,'user'=>$username));
    }




///////////////////////////////////////
/// ///////////////////////////////////
///

    public function allAction(Request $request)
    {
       $events = $this->getDoctrine()->getManager()
            ->getRepository('TechBundle:Evenement')
            ->findAll();





/*
        $em = $this->getDoctrine()->getManager();




        $queryBuilder = $em->getRepository('TechBundle:Evenement')->createQueryBuilder('bp');

        $queryBuilder->orderBy("bp.idEvent", 'DESC');
        $events=$queryBuilder->getQuery();
*/
      /*  $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });




        $normalizers = array($normalizer);

        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($events);
        return new JsonResponse($formatted);
$connect = mysqli_connect("localhost", "root", "", "jardinenfant");
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT * FROM evenement ORDER BY nbr_r DESC'
        );

        $events = $query->getResult();
*/

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($events);
        return new JsonResponse($formatted);

    }







    public function newAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $event = new Evenement();
        $event->setTitreEvent($request->get('Titre_Event'));
        $event->setIdUser($request->get('IdUser'));
        $event->setNbrR(0);
        $event->setEmplacement($request->get('EMPLACEMENT'));
        $event->setCategorieEvent($request->get('categorie_Event'));
        $event->setDatedEvent(new \DateTime($request->get('DATED_EVENT')));
        $event->setDatefEvent(new \DateTime($request->get('DATEF_EVENT')));
        $event->setNbrPlaceE($request->get('nbr_place_E'));

        $event->setDescrEvent($request->get('Descr_Event'));
        $event->setImageEvent( $request->get('Image_Event'));


        $em->persist($event);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($event);
        return new JsonResponse($formatted);
    }




    public function suppEAction(Request $request,$id){
        $event = new Evenement();
        $ev=$this->getDoctrine()->getManager();
        $event= $ev->getRepository("TechBundle:Evenement")->find($id);
        $ev->remove($event);
        $ev->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($event);
        return new JsonResponse($formatted);
    }

    ////User///
    ///
    public function findAction($email){
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository(\AppBundle\Entity\User::class)
            ->findOneBy(array('username'=>$email));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function newuAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $user -> setUsername($request->get('username'));
        $user -> setEmail($request->get('email'));
        $user -> setPassword($request->get('password'));
        $user -> setRoles(array($request->get('role')));
        $user-> setUsernameCanonical($request->get('username'));
        $user-> setEmailCanonical($request->get('email'));
        $user->setEnabled(1);
       // $user -> setNumtel($request->get('numTel'));
     //   $user -> setCode($request->get('code'));
        $em->persist($user);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }

    public function listEAction(Request $request){
        $em = $this->getDoctrine()->getManager();
       $e = $em->getRepository(Evenement::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($e);
        return new JsonResponse($formatted);
    }





    public function newRAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $event = new Reservation();
        $reser = new Evenement();

        $event->setTitreEvent($request->get('Titre_Event'));
        $event->setEtatRes("en cours");
        $event->setIdUser($request->get('IdUser'));
        $event->setIdEvent($request->get('IdEvent'));
        $event->setDatedEvent(new \DateTime($request->get('DATED_EVENT')));
        $event->setDatefEvent(new \DateTime($request->get('DATEF_EVENT')));
        $event->setImageevent( $request->get('Image_Event'));


        $em->persist($event);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($event);
        return new JsonResponse($formatted);
    }


    public function res111111Action(Request $request){

        $club = new Evenement();
        $res= new Reservation();
        $em = $this->getDoctrine()->getManager();
        $club = $em->getRepository(Evenement::class)->find($request->get('IdEvent'));

        $res1 = $em->getRepository(Reservation::class)->findByidUser( $request->get('IdUser') );

        $c=1;
        foreach($res1 as $a) {
            if($a->getIdEvent()==$request->get('IdEvent')){
                $c=2;

            }}
        if($c!=2){
            $c=1;
            $res->setTitreEvent($request->get('Titre_Event'));
            $res->setEtatRes("en cours");
            $res->setIdUser($request->get('IdUser'));
            $res->setIdEvent($request->get('IdEvent'));
            $res->setDatedEvent(new \DateTime($request->get('DATED_EVENT')));
            $res->setDatefEvent(new \DateTime($request->get('DATEF_EVENT')));
            $res->setImageevent( $request->get('Image_Event'));

            $club->setNbrR($club->getNbrR()+1);
            $em->persist($res);
            $em->flush();
            $resu=["message"=>"oui"];
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($resu);
            return new JsonResponse($formatted);

        }
        else{ $message = "vous avez deja reservé cet Evenement";
            $resu=["message"=>"non"];




            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($resu);
            return new JsonResponse($formatted);

        }

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($res);
        return new JsonResponse($formatted);
    }


    public function chercherEVEAction($id)
    {
        $club = new Evenement();
        $em = $this->getDoctrine()->getManager();
        $club = $em->getRepository(Evenement::class)->findBytitreEvent($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($club);
        return new JsonResponse($formatted);
    }

    public function chercherMAction()
    {


        $connect = mysqli_connect("localhost", "root", "", "jardinenfant");
        $output = '';
        $a = '';

        if(isset($_POST["query"]))
        {
            $search = mysqli_real_escape_string($connect, $_POST["query"]);
            if(strlen($search)>0){
                $query = "
	SELECT * FROM evenement 
	WHERE Titre_Event LIKE '%".$search."%'
	OR categorie_Event LIKE '%".$search."%'
	
	";
            }
            else
            {
                $query = "
	SELECT * FROM evenement ORDER BY nbr_r DESC ";
            }
            $result = mysqli_query($connect, $query);


            if(mysqli_num_rows($result) > 0)
            {
                $output .= '<div class="table-responsive">
					<table class="table table bordered">
						<tr>
							<th>Titre</th>
							<th> Categories </th>
							<th> Reservations </th>
							
						</tr>';
                while($row = mysqli_fetch_array($result))
                {

                    $output .= '
			 
	<tr> <td>	<a href="http://localhost/tech-event/web/app_dev.php/tech/map/'.$row["Id_Event"].'"	<td>'.$row["Titre_Event"].' </td> </a>
             <td>
             '.$row["categorie_Event"].' 
</td>
         <td>
         '.$row["nbr_r"].' 
</td>
              
               </tr>
			
			 
			
				
		
						
		';

                }

                echo $output;
            }
            else
            {
                echo 'Data Not Found';
            }
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($row["Id_Event"]);
        return new JsonResponse($formatted);

            return $this->render('@Tech/Default/chercher.html.twig'
            );


        }



    }

    /*public function chercherMobAction(Request $request)
    {

        $search=$request->get("search");

        $query=$this->getDoctrine()->getManager()->createQueryBuilser(
            'p'
        )->where('p.titreEvent like :e')
            ->setParameter('e','%'.$search.'%')->getResult();

        $r= Array();
        if(!$query){
        if($query!=null){
            foreach ($query as $ev){
                $res=["message"=>"true","titre"=>$ev->getTitreEvent(),"image"=>$ev->getImageEvent(),"id"=>$ev->getIdEvent()];
        $r->add($res);
            }
            return new Response(json_encode("000"));

        }else{
            $res=["message"=>"false","titre"=>0,"image"=>0,"id"=>0];
            $r->add($res);
            return new Response(json_encode("111"));
        }
        }
        else{
            $res=["message"=>"false","titre"=>0,"image"=>0,"id"=>0];
            $r->add($res);
            return new Response(json_encode($r));
        }

    }*/



    public function searchMobileAction(Request $request)
    {
        $search=$request->get("search");
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('search');
        $entities=$this->getDoctrine()->getManager()->createQueryBuilder(
        )->select('p')->from('TechBundle:Evenement' ,'p')->where('p.titreEvent like :e')
            ->setParameter('e','%'.$search.'%')->getQuery()->getResult();
     //   $entities =  $em->getRepository(Event::class)->findEntitiesByString($requestString);
        $result=array();
        $i=0;
        // return new Response(json_encode($entities[0]));
        if(!$entities or $entities==null) {
            $res=["message"=>"false","id"=>0,"title"=>0,"adresse"=>0,"img"=>0];
            $result[0]=$res;
            return new Response(json_encode($result));
        } elseif($entities[0]->getTitreEvent()!=null){
            foreach ($entities as $entity){
                try{
                    $res=["message"=>"true","id"=>$entity->getIdEvent(),"title"=>$entity->getTitreEvent(),"emplacement"=>$entity->getEmplacement(),"img"=>$entity->getImageEvent(),"capacite"=>$entity->getNbrPlaceE(),"nbrres"=>$entity->getNbrR(),"idu"=>$entity->getIdUser()];
                    $result[$i]=$res;
                    $i=$i+1;
                }catch (\mysqli_sql_exception $e){
                    $res=["message"=>"false","id"=>0,"title"=>0,"adresse"=>0,"img"=>0];
                    $result[0]=$res;
                    return new Response(json_encode($result));
                }
            }
            return new Response(json_encode($result));
        }



    }



    public function chercherreservationAction($id)
    {
        $club = new Reservation();
        $em = $this->getDoctrine()->getManager();
        $club = $em->getRepository(Reservation::class)->findByidUser($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($club);
        return new JsonResponse($formatted);
    }


    public function suppERAction(Request $request,$id,$ide){
        $event = new Reservation();
        $ev=$this->getDoctrine()->getManager();
        $event= $ev->getRepository("TechBundle:Reservation")->find($id);
        $res = $ev->getRepository(Evenement::class)->find($ide);
        $ev->remove($event);
        $ev->flush();
        $res->setNbrR(($res->getNbrR())-1);
        $ev->persist($res);
        $ev->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($event);
        return new JsonResponse($formatted);
    }



}
