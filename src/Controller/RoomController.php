<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;
use App\Repository\RoomRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/room")
* @IsGranted("ROLE_ADMIN")
 */
class RoomController extends AbstractController
{
    /**
     * @Route("/", defaults={"page": "1", "_format"="html", "limit" = "10"}, methods={"GET"}, name="room_index")
     * @Route("/page/{page<[1-9]\d*>}/{limit?}", defaults={"limit" = "10", "_format"="html"}, methods={"GET"}, name="room_index_paginated")
     * @Cache(smaxage="10")
     */
    public function index(Request $request, int $page, int $limit, string $_format, RoomRepository $roomRepository): Response
    {
        return $this->render('room/index.html.twig', [
            'rooms' => $roomRepository->findLatest($page, $limit),
        ]);
    }

    /**
     * @Route("/new", name="room_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $room = new Room();
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $room->setCreatedBy($this->getUser());
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($room);
            $entityManager->flush();

            return $this->redirectToRoute('room_index');
        }

        return $this->render('room/new.html.twig', [
            'room' => $room,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="room_show", methods={"GET"})
     */
    public function show(Room $room): Response
    {
        return $this->render('room/show.html.twig', [
            'room' => $room,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="room_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Room $room): Response
    {
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $room->setUpdatedAt(new \Datetime());

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('room_index');
        }

        return $this->render('room/edit.html.twig', [
            'room' => $room,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="room_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Room $room): Response
    {
        if ($this->isCsrfTokenValid('delete'.$room->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($room);
            $entityManager->flush();
        }

        return $this->redirectToRoute('room_index');
    }
}
