<?php

namespace CEWP;

class PostType
{
    private bool $isPublic = false;

    private string $key = '';

    private string $labelName = '';

    private string $labelSingularName = '';

    private string $labelMenuName = '';

    private string $labelParentItemColon = '';

    private string $labelAllItems = '';

    private string $labelViewItem = '';

    private string $labelAddNewItem = '';

    private string $labelAddNew = '';

    private string $labelEditItem = '';

    private string $labelUpdateItem = '';

    private string $labelSearchItems = '';

    private string $labelNotFound = '';

    private string $labelNotFoundInTrash = '';

    public function getIsPublic(): bool {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): PostType {
        $this->isPublic = $isPublic;
        return $this;
    }

    public function getKey(): string {
        return $this->key;
    }

    public function setKey(string $key): PostType {
        $this->key = $key;
        return $this;
    }

    public function getLabelName(): string {
        return $this->labelName;
    }

    public function setLabelName(string $labelName): PostType {
        $this->labelName = $labelName;
        return $this;
    }

    public function getLabelSingularName(): string {
        return $this->labelSingularName;
    }

    public function setLabelSingularName(string $labelSingularName): PostType {
        $this->labelSingularName = $labelSingularName;
        return $this;
    }

    public function getLabelMenuName(): string {
        return $this->labelMenuName;
    }

    public function setLabelMenuName(string $labelMenuName): PostType {
        $this->labelMenuName = $labelMenuName;
        return $this;
    }

    public function getLabelParentItemColon(): string {
        return $this->labelParentItemColon;
    }

    public function setLabelParentItemColon(string $labelParentItemColon): PostType {
        $this->labelParentItemColon = $labelParentItemColon;
        return $this;
    }

    public function getLabelAllItems(): string {
        return $this->labelAllItems;
    }

    public function setLabelAllItems(string $labelAllItems): PostType {
        $this->labelAllItems = $labelAllItems;
        return $this;
    }

    public function getLabelViewItem(): string {
        return $this->labelViewItem;
    }

    public function setLabelViewItem(string $labelViewItem): PostType {
        $this->labelViewItem = $labelViewItem;
    }

    public function getLabelAddNewItem(): string {
        return $this->labelAddNewItem;
    }

    public function setLabelAddNewItem(string $labelAddNewItem): PostType {
        $this->labelAddNewItem = $labelAddNewItem;
        return $this;
    }

    public function getLabelAddNew(): string {
        return $this->labelAddNew;
    }

    public function setLabelAddNew(string $labelAddNew): PostType {
        $this->labelAddNew = $labelAddNew;
        return $this;
    }

    public function getLabelEditItem(): string{
        return $this->labelEditItem;
    }

    public function setLabelEditItem(string $labelEditItem): PostType {
        $this->labelEditItem = $labelEditItem;
    }

    public function getLabelUpdateItem(): string {
        return $this->labelUpdateItem;
    }

    public function setLabelUpdateItem(string $labelUpdateItem): PostType {
        $this->labelUpdateItem = $labelUpdateItem;
        return $this;
    }

    public function getLabelSearchItems(): string {
        return $this->labelSearchItems;
    }

    public function setLabelSearchItems(string $labelSearchItems): PostType {
        $this->labelSearchItems = $labelSearchItems;
        return $this;
    }

    public function getLabelNotFound(): string {
        return $this->labelNotFound;
    }

    public function setLabelNotFound(string $labelNotFound): PostType {
        $this->labelNotFound = $labelNotFound;
        return $this;
    }

    public function getLabelNotFoundInTrash(): string {
        return $this->labelNotFoundInTrash;
    }

    public function setLabelNotFoundInTrash(string $labelNotFoundInTrash): PostType {
        $this->labelNotFoundInTrash = $labelNotFoundInTrash;
        return $this;
    }

    public function getArgs():array {
        return [
            'public'=>$this->isPublic,
            'supports' => ['title'],
            'labels'=>[
                'name' => $this->labelName,
                'singular_name' => $this->labelSingularName,
                'menu_name' => $this->labelMenuName,
                'parent_item_colon' => $this->labelParentItemColon,
                'all_items' => $this->labelAllItems,
                'view_item' => $this->labelViewItem,
                'add_new_item' => $this->labelAddNewItem,
                'add_new' => $this->labelAddNew,
                'edit_item' => $this->labelEditItem,
                'update_item' => $this->labelUpdateItem,
                'search_items' => $this->labelSearchItems,
                'not_found' => $this->labelNotFound,
                'not_found_in_trash' => $this->labelNotFoundInTrash
            ]
        ];
    }
}