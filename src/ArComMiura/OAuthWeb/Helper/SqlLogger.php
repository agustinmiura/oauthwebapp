<?php

namespace ArComMiura\OAuthWeb\Helper;

use Doctrine\DBAL\Logging\SQLLogger as DoctrineSqlLogger;

class SqlLogger implements DoctrineSqlLogger
{
    protected $logger;

    protected $startTime;

    public function __construct()
    {
        $this->logger = \Logger::getRootLogger();
    }

    /**
     * Logs a SQL statement somewhere.
     *
     * @param string $sql The SQL to be executed.
     * @param array $params The SQL parameters.
     * @param array $types The SQL parameter types.
     * @return void
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {
        $this->startTime = time();
        $logger = $this->logger;

        $asString = ($sql!=null) ? (print_r($sql, true)) : ' sql : NULL ';
        $logger->debug('Query to execute:'.$asString);

        $asString = print_r($params, true);
        $logger->debug('Params :'.$asString);

        $asString = print_r($types, true);
        $logger->debug('Types :'.$asString);
    }

    /**
     * Mark the last started query as stopped. This can be used for timing of queries.
     *
     * @return void
     */
    public function stopQuery()
    {
        $endTime = time();
        $length = $endTime - $this->startTime;

        $this->logger->debug('Query took :'.$length.' seconds');
    }
}