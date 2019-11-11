<?php

namespace Fhp\Model;

use Fhp\Dialog\Dialog;

class DialogState {

    private $_systemId;
    private $_dialogId;
    private $_messageNumber;
    private $_supportedTanMechanisms;

    private $_bpd;
    private $_upd;

    /**
     * @param Dialog $dialog
     * @return self
     */
    public static function createFrom(Dialog $dialog) {

        $result = new self();
        $result->_systemId = $dialog->getSystemId();
        $result->_dialogId = $dialog->getDialogId();
        $result->_messageNumber = $dialog->getMessageNumber();
        $result->_supportedTanMechanisms = $dialog->getSupportedPinTanMechanisms();
        $result->_bpd = $dialog->bpd;
        $result->_upd = $dialog->upd;

        // connection

        return $result;
    }

    public function getSystemId() {
        return $this->_systemId;
    }

    public function getDialogId() {
        return $this->_dialogId;
    }

    public function getMessageNumber() {
        return $this->_messageNumber;
    }

    public function getSupportedTanMechanisms() {
        return $this->_supportedTanMechanisms;
    }

    public function getBpd() {
        return $this->_bpd;
    }

    public function getUpd() {
        return $this->_upd;
    }
}