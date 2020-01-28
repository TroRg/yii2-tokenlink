<?php

namespace trorg\yii2\tokenlink;

use yii\base\{Component, InvalidConfigException};
use trorg\tokenlink\{Identificator, Token};

class TokenLink extends Component
{
    /* @var string token secret */
    public $secret;

    /* @var int token ttl */
    public $ttl;

    /* @var string[] identificator's fields names*/
    public $fields;

    private $_options = [];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if (!$this->secret) {
            throw new InvalidConfigException('"secret" is mandatory.');
        }
        if (!$this->fields || !is_array($this->fields) || count($this->fields) < 1) {
            throw new InvalidConfigException('"fields" must be an array with minimum 1 element.');
        }
    }

    /**
     * Reassembly token from string
     *
     * @param string $rawToken raw token string
     *
     * @return trorg\tokenlink\Token
     */
    public function load(string $rawToken): Token
    {
        return Token::load($rawToken, $this->getOptions());
    }

    /**
     */
    public function generate(array $idAttributes)
    {
        $id = new Identificator($idAttributes);
        return new Token($id, $this->getOptions());
    }

    /**
     * Validate token
     *
     * @param string $rawToken raw token string
     *
     * @return bool
     */
    public function isValid(string $rawToken): bool
    {
        return $this->load($rawToken)->isValid();
    }

    /**
     * Generate options array
     *
     * @return array
     */
    private function getOptions(): array
    {
        return [
            'secret' => $this->secret,
            'ttl' => $this->ttl,
            'idFields' => $this->fields,
        ];
    }

}

