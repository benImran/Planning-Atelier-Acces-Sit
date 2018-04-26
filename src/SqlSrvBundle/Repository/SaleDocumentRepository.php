<?php

namespace SqlSrvBundle\Repository;

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
        $limitdate = new \DateTime('-1 month');

        //Query Builder
        $q = $this->createQueryBuilder("s")
            ->select('s.id,s.deliverydate,s.documentdate,s.documentnumber,s.customername,s.numberprefix') // Données selectionnés dont on a besoin
            ->where("s.numberprefix = :prefix") // I: premier param a checké  @Param prefix
            ->andWhere('s.documentdate > :limitdate') // II: deuxieme param a checké @Param limitedate
            ->setParameter('prefix', 'CAT') // Set Param I
            ->setParameter('limitdate', $limitdate->format('d-m-y')) // Set Param II
            ->getQuery();

        return $q->getResult();

    }
}
