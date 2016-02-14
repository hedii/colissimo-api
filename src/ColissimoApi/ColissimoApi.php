<?php

namespace Hedii\ColissimoApi;

class ColissimoApi
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @var bool
     */
    private $show = false;

    /**
     * @var bool
     */
    public $error = false;

    /**
     * @param string $id
     *
     * @return $this
     */
    public function get($id)
    {
        $parser     = new Parser($id);
        $this->data = $parser->parseAll();

        if (empty($this->data)) {
            $this->error = 'Invalid Colissimo id provided';
        }

        return $this;
    }

    /**
     * @param string $id
     *
     * @return $this
     */
    public function show($id)
    {
        $this->show = true;
        $parser     = new Parser($id);
        $this->data = $parser->parseAll();

        if (empty($this->data)) {
            $this->error = 'Invalid Colissimo id provided';
        }

        return $this;
    }

    /**
     * @return bool|mixed|string|void
     */
    public function all()
    {
        if ($this->show) {
            echo $this->asJson($this->respondWith($this->data));

            return $this->asJson($this->respondWith($this->data));
        }

        return $this->respondWith($this->data);
    }

    /**
     * @return bool|mixed|string|void
     */
    public function status()
    {
        if ($this->show) {
            echo $this->asJson($this->respondWith($this->data['status']));

            return $this->asJson($this->respondWith($this->data['status']));
        }

        return $this->respondWith($this->data['status']);
    }

    /**
     * @return bool|mixed|string|void
     */
    public function destination()
    {
        if ($this->show) {
            echo $this->asJson($this->respondWith($this->data['destination']));

            return $this->asJson($this->respondWith($this->data['destination']));
        }

        return $this->respondWith($this->data['destination']);
    }

    /**
     * @return bool|mixed|string|void
     */
    public function id()
    {
        if ($this->show) {
            echo $this->asJson($this->respondWith($this->data['id']));

            return $this->asJson($this->respondWith($this->data['id']));
        }

        return $this->respondWith($this->data['id']);
    }

    /**
     * @param mixed|string|array $value
     *
     * @return mixed|string|void
     */
    public function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param mixed|string|bool|array $content
     *
     * @return mixed|string|bool|array
     */
    private function respondWith($content)
    {
        if ($this->error) {
            if ($this->show) {
                return $this->error;
            }

            return false;
        }

        return $content;
    }
}