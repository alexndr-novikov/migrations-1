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
use Spiral\Migrations\Operation\AbstractOperation;

final class Rename extends AbstractOperation
{
    /** @var string */
    private $name = '';

    /** @var string */
    private $newName = '';

    /**
     * @param string $table
     * @param string $name
     * @param string $newName
     */
    public function __construct(string $table, string $name, string $newName)
    {
        parent::__construct($table);
        $this->name = $name;
        $this->newName = $newName;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(CapsuleInterface $capsule)
    {
        $schema = $capsule->getSchema($this->getTable());

        if (!$schema->hasColumn($this->name)) {
            throw new ColumnException(
                "Unable to rename column '{$schema->getName()}'.'{$this->name}', column does not exists"
            );
        }

        if ($schema->hasColumn($this->newName)) {
            throw new ColumnException(
                "Unable to rename column '{$schema->getName()}'.'{$this->name}', column '{$this->newName}' already exists"
            );
        }

        //Declaring column
        $schema->renameColumn($this->name, $this->newName);
    }
}