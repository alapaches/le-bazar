<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Objet;
use App\Form\ObjetType;
use App\Repository\ObjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/objet")
 */
class ObjetController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/", name="objet_index", methods={"GET"})
     */
    public function index(ObjetRepository $objetRepository): Response
    {
        return $this->render('objet/index.html.twig', [
            'objets' => $objetRepository->findAll(),
        ]);
    }

    /**
     * @Route("/search/object", name="objet_search", methods={"GET"}, options={"expose"=true})
     */
    public function searchObject(Request $request): Response
    {
        $term = $request->query->get("search");
        $search = $this->em->getRepository(Objet::class)->findNomStartingWith($term);
        $results = [];
        foreach($search as $objet) {
            $results["id"] = $objet->getId();
            $results["nom"] = $objet->getNom();
        }
        // dump($results);die();

        // $nom = $search[0]->getNom();

        // $objet = new JsonResponse(["nom"=> $nom]);
        // dump($results);
        return $this->json($results);
    }

    /**
     * @Route("/new", name="objet_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $objet = new Objet();
        $form = $this->createForm(ObjetType::class, $objet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($objet);
            $entityManager->flush();

            return $this->redirectToRoute('objet_index');
        }

        return $this->render('objet/new.html.twig', [
            'objet' => $objet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="objet_show", methods={"GET"})
     */
    public function show(Objet $objet): Response
    {
        return $this->render('objet/show.html.twig', [
            'objet' => $objet,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="objet_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Objet $objet): Response
    {
        $form = $this->createForm(ObjetType::class, $objet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('objet_index');
        }

        return $this->render('objet/edit.html.twig', [
            'objet' => $objet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="objet_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Objet $objet): Response
    {
        if ($this->isCsrfTokenValid('delete'.$objet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($objet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('objet_index');
    }

    /**
     * @Route("/get/lieu-by-piece", name="objet_get_lieu_by_piece", methods={"GET"}, options={"expose"=true})
     */
    public function getLieuByPiece(Request $request)
    {
        $lieuxRepo = $this->em->getRepository(Lieu::class);        
        $lieux = $lieuxRepo->createQueryBuilder("q")
            ->where("q.piece = :pieceId")
            ->setParameter("pieceId", $request->query->get("pieceId"))
            ->getQuery()
            ->getResult()
        ;        
        $lieuxTab = array();
        foreach($lieux as $lieu){
            $lieuxTab[] = array(
                "id" => $lieu->getId(),
                "nom" => $lieu->getNom()
            );
        }
        
        return new JsonResponse($lieuxTab);
    }
}