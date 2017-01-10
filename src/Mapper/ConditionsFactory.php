<?php
namespace Boxspaced\EntityManagerModule\Mapper;

use Boxspaced\EntityManagerModule\Exception;
use Boxspaced\EntityManager\Mapper\Conditions;
use Boxspaced\EntityManager\Mapper\ConditionsFactoryInterface;

class ConditionsFactory implements ConditionsFactoryInterface
{

    /**
     * @var Conditions
     */
    private $conditions;

    /**
     * @param int $id
     * @param array $options
     */
    public function __invoke($id, array $options = null)
    {
        $this->conditions = new Conditions();

        if (null !== $options) {
            $this->addConstraints($id, $options);
            $this->addOrdering($options);
        }

        return $this->conditions;
    }

    /**
     * @param int $id
     * @param array $options
     * @return ConditionsFactory
     * @throws Exception\InvalidArgumentException
     */
    protected function addConstraints($id, array $options)
    {
        $constraints = isset($options['constraints']) ? $options['constraints'] : [];

        foreach ($constraints as $constraint) {

            if (!isset($constraint['field']) || !isset($constraint['operation'])) {
                throw new Exception\InvalidArgumentException("The 'field' and 'operation' values are required for a constraint");
            }

            $this->conditions->field($constraint['field']);

            $operation = $constraint['operation'];

            if (!isset($constraint['value'])) {

                $this->conditions->{$operation}();
                continue;
            }

            $value = $constraint['value'] === ':id' ? $id : $constraint['value'];

            $this->conditions->{$operation}($value);
        }

        return $this;
    }

    /**
     * @param array $options
     * @return ConditionsFactory
     * @throws Exception\InvalidArgumentException
     */
    protected function addOrdering(array $options)
    {
        $ordering = isset($options['ordering']) ? $options['ordering'] : [];

        foreach ($ordering as $order) {

            if (!isset($order['field'])) {
                throw new Exception\InvalidArgumentException("The 'field' value is required for ordering");
            }

            $direction = isset($order['direction']) ? $order['direction'] : Conditions::ORDER_ASC;

            $this->conditions->order($order['field'], $direction);
        }

        return $this;
    }

}
