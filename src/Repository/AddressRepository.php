<?php

namespace App\Repository;

use App\Entity\Address;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Address|null find($id, $lockMode = null, $lockVersion = null)
 * @method Address|null findOneBy(array $criteria, array $orderBy = null)
 * @method Address[]    findAll()
 * @method Address[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Address::class);
    }

    /**
     * @param $user
     * @return Address[] Returns an array of Address objects
     */
    public function findUserAddresses($user): array
    {
        return $this->createQueryBuilder('a')
            ->Where('a.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAddressByCommandId($value)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT address.id, address.title, address.firstname, address.lastname, address.number, address.type, address.street, address.city, address.cp, address.country, address.additional
            FROM address
            INNER JOIN command ON address.id = command.livraison_id
            WHERE command.id = 2
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['value' => $value]);
    
        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }

        
    /*
    public function findOneBySomeField($value): ?Address
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
}
