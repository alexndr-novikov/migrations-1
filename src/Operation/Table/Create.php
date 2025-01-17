<?php
/**
 * Spiral Framework.
 *
 * @license MIT
 * @author  Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace Spiral\Migrations\Operation\Table;

use Spiral\Database\Driver\HandlerInterface;
use Spiral\Migrations\CapsuleInterface;
use Spiral\Migrations\Exception\Operation\TableException;
use Spiral\Migrations\Operation\AbstractOperation;

final class Create extends AbstractOperation
{
    /**
     * {@inheritdoc}
     */
    public function execute(CapsuleInterface $capsule)
    {
        $schema = $capsule->getSchema($this->getTable());
        $database = $this->database ?? '[default]';

        if ($schema->exists()) {
            throw new TableException(
                "Unable to create table '{$database}'.'{$this->getTable()}', table already exists"
            );
        }

        if (empty($schema->getColumns())) {
            throw new TableException(
                "Unable to create table '{$database}'.'{$this->getTable()}', no columns were added"
            );
        }

        $schema->save(HandlerInterface::DO_ALL);
    }
}