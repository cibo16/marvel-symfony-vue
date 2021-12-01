<?php

namespace App\Controller;

use App\Entity\Character;
use App\Service\APIMarvelManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class AppController extends AbstractController
{
    /**
     * @Route("/api/characters", name="app_index")
     */
    public function index() :JsonResponse
    {
        // Get Characters list from API for display
        $characters = $this->getCharactersFromMarvel(20, 100);

        return $this->json($characters,200,[],[]);
    }

    /**
     * @Route("/api/character/{id}", name="app_character", methods={"GET"})
     */
    public function showCharacter($id) :JsonResponse
    {
        $character = $this->getCharactersFromMarvel(1, 0, $id);

        return $this->json($character,200,[],[]);
    }

    public function getCharactersFromMarvel($limit = 100, $offset = 0, $id = '')
    {
        $APIMarvelManager = new APIMarvelManager();
        $charactersRawData = $APIMarvelManager->getCharacters($limit, $offset, $id);

        $characters = [];

        // Create an array of characters object
        foreach ($charactersRawData as $characterData)
        {
            // Create array of comic appearances
            $comicsAppearances = [];
            foreach ($characterData['comics']['items'] as $characterAppearances)
            {
                array_push($comicsAppearances, $characterAppearances['name']);
            }

            $characters[] = new Character([
                'id' => $characterData['id'],
                'name' => $characterData['name'],
                'picture' => $characterData['thumbnail']['path'], // https://developer.marvel.com/documentation/images
                'description' => $characterData['description'],
                'comicsAppearances' => $comicsAppearances
            ]);
        }

        return $characters;
    }
}