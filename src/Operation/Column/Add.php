<?php
/**
 * Spiral Framework.
 *
 * @license MIT
 * @author  Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace Spiral\Migrations\Operation\Column;

use Spiral\Migrations\CapsuleInterface;
use Spiral\Migrations\Exception\Operation\ColumnException;

final class Add extends Column
{
    /**
     * {@inheritdoc}
     */
    public function execute(CapsuleInterface $capsule)
    {
        $schema = $capsule->getSchema($this->getTable());

        if ($schema->hasColumn($this->name)) {
            throw new ColumnException(
                "Unable to create column '{$schema->getName()}'.'{$this->name}', column already exists"
            );
        }

        //Declaring column
        $this->declareColumn($schema);
    }
}