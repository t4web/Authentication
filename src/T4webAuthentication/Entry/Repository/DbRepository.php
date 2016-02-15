<?php
namespace T4web\Authentication\Entry\Repository;

use T4webBase\Domain\Repository\DbRepository as BaseDbRepository;
use T4webBase\Domain\EntityInterface;

class DbRepository extends BaseDbRepository {

    public function add(EntityInterface $entity) {
        $data = $this->dbMapper->toTableRow($entity);

        $id = $entity->getId();

        if ($this->getIdentityMap()->offsetExists((int)$id)) {
            if (!$this->isEntityChanged($entity)) {
                return;
            }
            $result = $this->tableGateway->updateByPrimaryKey($data, $id);

            $e = $this->getEvent();
            $originalEntity = $this->identityMapOriginal->offsetGet($entity->getId());
            $e->setOriginalEntity($originalEntity);
            $e->setChangedEntity($entity);

            $this->triggerChanges($e);
            $this->triggerAttributesChange($e);

            return $result;
        } else {

            if (!empty($id)) {
                $data['id'] = $id;
            }

            $this->tableGateway->insert($data);

            if (empty($id)) {
                $id = $this->tableGateway->getLastInsertId();
                $entity->populate(compact('id'));
            }

            $this->toIdentityMap($entity);
        }
    }

}