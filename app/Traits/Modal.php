<?php

namespace App\Traits;

trait Modal
{
    public $mode = 'create';

    public $showModal = false;

    public function getModeTitle()
    {
        $createModalTitle = 'Create';
        
        $updateModalTitle = 'Update';

        if (property_exists($this, 'createModalTitle')) {
            $createModalTitle = $this->createModalTitle;
        }

        if (property_exists($this, 'updateModalTitle')) {
            $updateModalTitle = $this->updateModalTitle;
        }

        if ($this->mode == 'create') {
            return $createModalTitle;
        } else {
            return $updateModalTitle;
        }
    }

    public function add()
    {
        $this->mode = 'create';
        if (method_exists($this, 'onClickAdd')) {
            $this->onClickAdd();
        }
        $this->showModal = true;
    }

    public function edit($edit_id)
    {
        $this->mode = 'update';
        if (method_exists($this, 'onClickEdit')) {
            $this->onClickEdit($edit_id);
        }
        $this->showModal = true;
    }

}