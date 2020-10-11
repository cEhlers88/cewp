<?php

namespace CEWP;

class PostType
{
    private bool $isPublic = false;

    private string $key;

    private string $label = '';

    /**
     * @return bool
     */
    public function getIsPublic(): bool
    {
        return $this->isPublic;
    }

    /**
     * @param bool $isPublic
     * @return PostType
     */
    public function setIsPublic(bool $isPublic): PostType {
        $this->isPublic = $isPublic;
        return $this;
    }

    /**
     * @return string
     */
    public function getKey(): string {
        return $this->key;
    }

    /**
     * @param string $key
     * @return PostType
     */
    public function setKey(string $key): PostType {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return PostType
     */
    public function setLabel(string $label): PostType {
        $this->label = $label;
        return $this;
    }

    public function getArgs():array {
        return [
            'public'=>$this->isPublic,
            'label'=>$this->label
        ];
    }
}