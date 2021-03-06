<?php

namespace RsBundle\Repository;
use Doctrine\ORM\EntityNotFoundException;
use RsBundle\Entity\RsRoom;

/**
 * RsRoomRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RsRoomFileRepository extends \Doctrine\ORM\EntityRepository
{


    /**
     * Get Room Images
     * @param RsRoom $rsRoom
     * @param string $type
     * @return array
     */
    public function getFilesByRsRoom(RsRoom $rsRoom, $type = 'img') {
        $qb = $this->createQueryBuilder('file')
            ->where('file.rsRoom = :rsRoom')->setParameter(':rsRoom', $rsRoom)
            ->andWhere('file.type = :type')->setParameter(':type', $type)
            ->orderBy('file.sort', 'ASC')
            ->addOrderBy('file.id', 'DESC')
            ->getQuery();
        return $qb->getResult();
    }
    
    
    
    /**
     * @param $id
     * @param $uploadDir
     */
    public function remove($id, $uploadDir) {
        $rsRoomFile = $this->find('RsBundle:RsRoomFile', $id);
        if (!$rsRoomFile) {
            throw new EntityNotFoundException();
        }
        //var_dump($uploadDir .'/'. $cmsStaticPageFileEntity->getFileName());
        $filePath = $uploadDir . $rsRoomFile->getFileName();
        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                $this->getEntityManager()->remove($rsRoomFile);
                $this->getEntityManager()->flush();
                return true;
            }
            throw new \Exception();
        }
        throw new \Exception();
    }

}



