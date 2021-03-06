<?php

namespace Fhp\Model\StatementOfAccount;

class StatementOfAccount
{
    /**
     * @var Statement[]
     */
    protected $statements = [];

    /**
     * Get statements
     *
     * @return Statement[]
     */
    public function getStatements(): array
    {
        return $this->statements;
    }

    /**
     * Set statements
     *
     * @param array $statements
     *
     * @return $this
     */
    public function setStatements(array $statements = null)
    {
        $this->statements = null == $statements ? [] : $statements;

        return $this;
    }

    public function isTANRequest()
    {
        return false;
    }

    public function addStatement(Statement $statement)
    {
        $this->statements[] = $statement;
    }

    /**
     * Gets statement for given date.
     *
     * @param string|\DateTime $date
     */
    public function getStatementForDate($date): ?Statement
    {
        if (is_string($date)) {
            $date = new \DateTime($date);
        }

        foreach ($this->statements as $stmt) {
            if ($stmt->getDate() == $date) {
                return $stmt;
            }
        }

        return null;
    }

    /**
     * Checks if a statement with given date exists.
     *
     * @param string|\DateTime $date
     */
    public function hasStatementForDate($date): bool
    {
        if (is_string($date)) {
            $date = new \DateTime($date);
        }

        return null !== $this->getStatementForDate($date);
    }
}
