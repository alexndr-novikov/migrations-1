<?php
/**
 * Spiral Framework.
 *
 * @license MIT
 * @author  Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace Spiral\Migrations\Operation\Index;

use Spiral\Migrations\CapsuleInterface;
use Spiral\Migrations\Exception\Operation\IndexException;
use Spiral\Migrations\Operation\Traits\OptionsTrait;

final class Add extends Index
{
    use OptionsTrait;

    /**
     * @param string $table
     * @param array  $columns
     * @param array  $options
     */
    public function __construct(string $table, array $columns, array $options = [])
    {
        parent::__construct($table, $columns);
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(CapsuleInterface $capsule)
    {
        $schema = $capsule->getSchema($this->getTable());

        if ($schema->hasIndex($this->columns)) {
            $columns = join(',', $this->columns);
            throw new IndexException(
                "Unable to create index '{$schema->getName()}'.({$columns}), index already exists"
            );
        }

        $schema->index($this->columns)->unique(
            $this->getOption('unique', false)
        );

        if ($this->hasOption('name')) {
            $schema->index($this->columns)->setName($this->getOption('name'));
        }
    }
}