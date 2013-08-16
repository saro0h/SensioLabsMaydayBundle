<?php

namespace SensioLabs\Bundle\MaydayBundle\Server;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

/**
 * React server remote control.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class ReactServer
{
    /**
     * @var string
     */
    private $runFilePath;

    /**
     * @var string
     */
    private $pidFilePath;

    /**
     * @var int
     */
    private $port;

    /**
     * @param string $runFilePath
     * @param string $pidFilePath
     * @param int    $port
     */
    public function __construct($runFilePath, $pidFilePath, $port)
    {
        $this->runFilePath = $runFilePath;
        $this->pidFilePath = $pidFilePath;
        $this->port = $port;
    }

    /**
     * Pings react server.
     *
     * @return boolean
     */
    public function ping()
    {
        if (!$this->getPid()) {
            return false;
        }

        // todo: ping react server
        return true;
    }

    /**
     * Starts react server.
     *
     * @return boolean False if already started
     *
     * @throws \Exception
     */
    public function start()
    {
        if ($this->getPid()) {
            return false;
        }

        $process = proc_open(sprintf('%s %s 127.0.0.1 &', $this->runFilePath, $this->port), array(), $pipes);
        $info = proc_get_status($process);
        proc_close($process);

        if ($info['exitcode'] > 0) {
            throw new \Exception(sprintf('Start failed with code "%s".', $info['exitcode']));
        }

        // todo: find something more accurate
        file_put_contents($this->pidFilePath, $info['pid'] + 1);

        return true;
    }

    /**
     * Stops react server.
     *
     * @return boolean False if not started
     *
     * @throws \Exception
     */
    public function stop()
    {
        if (!$pid = $this->getPid()) {
            return false;
        }

        $process = ProcessBuilder::create(array('kill', (string) $pid))->getProcess();
        $process->run();

        if ($process->isSuccessful()) {
            file_put_contents($this->pidFilePath, '');
        } else {
            throw new \Exception('Failed to kill process: '.$process->getErrorOutput());
        }

        return true;
    }

    /**
     * Broadcasts a command to all react server clients.
     *
     * @param string $event
     * @param array  $parameters
     *
     * @return boolean
     *
     * @throws \Exception
     */
    public function broadcast($event, array $parameters = array())
    {
        $process = proc_open(sprintf(
            'nc -w 1 localhost %s < <(echo "%s" ; cat)',
            $this->port, escapeshellarg(json_encode(array(
                'event'      => $event,
                'parameters' => $parameters,
            )))
        ), array(), $pipes);

        $info = proc_get_status($process);
        proc_close($process);

        if ($info['exitcode'] > 0) {
            throw new \Exception(sprintf('Broadcast failed with code "%s".', $info['exitcode']));
        }

        return true;
    }

    /**
     * Returns react server process ID.
     *
     * @return string|null
     */
    private function getPid()
    {
        return file_get_contents($this->pidFilePath) ?: null;
    }
}
