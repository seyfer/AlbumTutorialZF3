<?php
/**
 * Created by PhpStorm.
 * User: seyfer
 * Date: 11/16/16
 */

namespace Album\Model;


use Zend\Db\ResultSet\ResultSet;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\TableGateway\TableGatewayInterface;

class AlbumTable
{
    /**
     * @var TableGatewayInterface
     */
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @return ResultSetInterface
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    /**
     * @param int $id
     * @return array|\ArrayObject|null
     */
    public function getAlbum(int $id)
    {
        $id = (int)$id;

        /** @var ResultSet $resultSet */
        $resultSet = $this->tableGateway->select(['id' => $id]);
        $row       = $resultSet->current();

        if (!$row) {
            throw new \RuntimeException(sprintf(
                                            'Could not find row with identifier %d',
                                            $id
                                        ));
        }

        return $row;
    }

    /**
     * @param Album $album
     */
    public function saveAlbum(Album $album)
    {
        $data = [
            'artist' => $album->artist,
            'title'  => $album->title,
        ];

        $id = (int)$album->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);

            return;
        }

        if (!$this->getAlbum($id)) {
            throw new \RuntimeException(sprintf(
                                            'Cannot update album with identifier %d; does not exist',
                                            $id
                                        ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    /**
     * @param int $id
     */
    public function deleteAlbum(int $id)
    {
        $this->tableGateway->delete(['id' => (int)$id]);
    }
}