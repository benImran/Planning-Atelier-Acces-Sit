<?php

namespace PlanningBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * SaleDocumentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SaleDocumentRepository extends EntityRepository
{
    public function findSafeDoc()
    {
        // Nouvelle Date -> Corespondant à la date la la plus éloigné du document que l'on souhaite récupéré
        $limitdate= new \DateTime('-2 months');

        // Query Builder
        $q = $this->createQueryBuilder("s")
            ->select('s.id,s.documentWishDate,s.documentDate,s.documentNumber,s.customerName, s.numberPrefix') // Données selectionnés
            ->where("s.numberPrefix = :prefix") // I: premier param a checké  @Param prefix
            ->andWhere('s.documentDate > :limitdate') // II: deuxieme param a checké @Param limitedate
            ->setParameter('prefix', 'CAT') // Set Param I
            ->setParameter('limitdate', $limitdate->format('d-m-y')) // Set Param II
            ->orderBy('s.documentNumber', 'DESC') // Trier par date Décroissante
            ->getQuery();

        return $q->getResult();

    }
}
