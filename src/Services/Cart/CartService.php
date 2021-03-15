<?php

namespace App\Services\Cart;

use App\Repository\ListingRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService {

    protected $session;
    protected $listing_repo;

    public function __construct(SessionInterface $session, ListingRepository $listing_repo)
    {
        $this->session = $session;
        $this->listing_repo = $listing_repo;
    }

    // Fonction d'ajout au panier
    public function add($id)
    {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $this->session->set('panier', $panier);
    }

    // Fonction de suppression des elements du panier
    public function remove($id)
    {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $this->session->set('panier',$panier);
    }

    // Fonction de recuperation des éléments du panier
    public function getFullCart(): array
    {
        $panier = $this->session->get('panier', []);

        $panierWithData = [];

        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'listing' => $this->listing_repo->find($id),
                'quantity'=> $quantity 
            ];
        }
        return $panierWithData;

    }

    // Fonction pour vider totalement le panier
    public function clearCart()
    {
        $panier = $this->session->get('panier', []);
        $panierVide = [];

        if (!empty($panier)) {
            
            $this->session->set('panier',$panierVide);
        }
    }

    // Fonction pour calculer le montant total du panier
    public function getTotal(): float 
    {
        $total = 0;

        foreach ($this->getFullCart() as $item) {
            $total += $item['listing']->getUnitPrice()*$item['quantity'];
        }

        return $total;
    }


}


?>