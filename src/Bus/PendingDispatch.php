<?php

namespace kkchaulagain\phpQueue\Bus;
class PendingDispatch
{

    /**
     * The job.
     *
     * @var mixed
     */
    public $job, $payload;

    /**
     * Create a new pending job dispatch.
     *
     * @param mixed $job
     * @return void
     */
    public function __construct($job)
    {
        $payload = [];
        $this->job = $job;
        $payload['data'] = json_encode($this->job);

        $payload['classname'] = $this->job->getNameOfClass();
        $this->payload = $payload;

    }

    public function __destruct()
    {
        // $this->job->saveToDatabase($this->payload);
    }

}